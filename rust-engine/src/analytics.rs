use crate::models::{AbcAnalysisResult, AbcItem, AnalyticsRequest, AnalyticsResponse};
use std::collections::BTreeMap;

pub fn calculate_analytics(req: AnalyticsRequest) -> AnalyticsResponse {
    let completed_orders: Vec<_> = req
        .orders
        .iter()
        .filter(|o| o.order_status == "completed" || o.order_status == "shipping" || o.order_status == "processing")
        .collect();

    let total_revenue: f64 = completed_orders.iter().map(|o| o.final_amount).sum();
    let total_orders = req.orders.len();
    let completed_orders_count = completed_orders.len();

    // 1. Daily revenue aggregation for linear regression
    let mut daily_rev: BTreeMap<String, f64> = BTreeMap::new();
    for o in &completed_orders {
        let day = if o.created_at.len() >= 10 {
            o.created_at[0..10].to_string()
        } else {
            "2026-01-01".to_string()
        };
        *daily_rev.entry(day).or_insert(0.0) += o.final_amount;
    }

    let x_vals: Vec<f64> = (1..=daily_rev.len()).map(|i| i as f64).collect();
    let y_vals: Vec<f64> = daily_rev.values().copied().collect();

    let n = x_vals.len();
    let mut slope = 0.0;
    let mut forecast_next_day_revenue = 0.0;

    if n >= 2 {
        let mean_x: f64 = x_vals.iter().sum::<f64>() / n as f64;
        let mean_y: f64 = y_vals.iter().sum::<f64>() / n as f64;

        let mut num = 0.0;
        let mut den = 0.0;

        for i in 0..n {
            num += (x_vals[i] - mean_x) * (y_vals[i] - mean_y);
            den += (x_vals[i] - mean_x).powi(2);
        }

        if den > 0.0 {
            slope = num / den;
            let intercept = mean_y - (slope * mean_x);
            forecast_next_day_revenue = (slope * (n as f64 + 1.0) + intercept).max(0.0);
        }
    } else if n == 1 {
        forecast_next_day_revenue = y_vals[0];
    } else {
        forecast_next_day_revenue = 0.0;
    }

    // 2. ABC Inventory Classification (Pareto 80/20)
    let mut items: Vec<AbcItem> = req
        .products
        .iter()
        .map(|p| {
            let sales_count = p.sales_count.unwrap_or(0) as f64;
            let sales_value = p.price * sales_count;
            AbcItem {
                id: p.id,
                name: p.name.clone(),
                sales_value,
                stock: p.stock.unwrap_or(0),
                category: String::new(),
            }
        })
        .collect();

    items.sort_by(|a, b| b.sales_value.total_cmp(&a.sales_value));

    let total_sales_value: f64 = items.iter().map(|i| i.sales_value).sum();
    let mut cumulative_value = 0.0;

    let mut class_a_count = 0;
    let mut class_b_count = 0;
    let mut class_c_count = 0;

    for item in &mut items {
        let prev_pct = if total_sales_value > 0.0 {
            (cumulative_value / total_sales_value) * 100.0
        } else {
            0.0
        };
        cumulative_value += item.sales_value;

        if prev_pct < 70.0 || class_a_count == 0 {
            item.category = "A".to_string();
            class_a_count += 1;
        } else if prev_pct < 90.0 {
            item.category = "B".to_string();
            class_b_count += 1;
        } else {
            item.category = "C".to_string();
            class_c_count += 1;
        }
    }

    let top_revenue_items = items.iter().take(5).cloned().collect();

    AnalyticsResponse {
        total_revenue: (total_revenue * 100.0).round() / 100.0,
        total_orders,
        completed_orders_count,
        forecast_next_day_revenue: (forecast_next_day_revenue * 100.0).round() / 100.0,
        trend_slope: (slope * 100.0).round() / 100.0,
        abc_analysis: AbcAnalysisResult {
            class_a_count,
            class_b_count,
            class_c_count,
            top_revenue_items,
        },
    }
}

#[cfg(test)]
mod tests {
    use super::*;
    use crate::models::{OrderRecord, ProductItem};
    use std::collections::HashMap;

    #[test]
    fn test_analytics_abc() {
        let p1 = ProductItem {
            id: 1,
            name: "Flagship Phone".to_string(),
            slug: None,
            price: 30000000.0,
            category_id: Some(1),
            brand_id: Some(1),
            category_name: None,
            brand_name: None,
            short_description: None,
            rating: None,
            stock: Some(10),
            sales_count: Some(10), // 300,000,000
            specs: HashMap::new(),
        };

        let p2 = ProductItem {
            id: 2,
            name: "Cable".to_string(),
            slug: None,
            price: 100000.0,
            category_id: Some(6),
            brand_id: Some(2),
            category_name: None,
            brand_name: None,
            short_description: None,
            rating: None,
            stock: Some(100),
            sales_count: Some(5), // 500,000
            specs: HashMap::new(),
        };

        let o1 = OrderRecord {
            id: 1,
            final_amount: 30000000.0,
            order_status: "completed".to_string(),
            created_at: "2026-09-01 10:00:00".to_string(),
        };

        let req = AnalyticsRequest {
            orders: vec![o1],
            products: vec![p1, p2],
        };

        let res = calculate_analytics(req);
        assert_eq!(res.total_revenue, 30000000.0);
        assert_eq!(res.abc_analysis.class_a_count, 1);
    }
}
