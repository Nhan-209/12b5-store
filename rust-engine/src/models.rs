use serde::de::Deserializer;
use serde::{Deserialize, Serialize};
use std::collections::HashMap;

fn deserialize_specs<'de, D>(deserializer: D) -> Result<HashMap<String, serde_json::Value>, D::Error>
where
    D: Deserializer<'de>,
{
    let val = serde_json::Value::deserialize(deserializer)?;
    match val {
        serde_json::Value::Object(map) => {
            let mut h = HashMap::new();
            for (k, v) in map {
                h.insert(k, v);
            }
            Ok(h)
        }
        serde_json::Value::Array(_) | serde_json::Value::Null => Ok(HashMap::new()),
        _ => Ok(HashMap::new()),
    }
}

#[derive(Debug, Clone, Serialize, Deserialize)]
pub struct ProductItem {
    pub id: i64,
    pub name: String,
    pub slug: Option<String>,
    pub price: f64,
    pub category_id: Option<i64>,
    pub brand_id: Option<i64>,
    pub category_name: Option<String>,
    pub brand_name: Option<String>,
    pub short_description: Option<String>,
    pub rating: Option<f64>,
    pub stock: Option<i64>,
    pub sales_count: Option<i64>,
    #[serde(default, deserialize_with = "deserialize_specs")]
    pub specs: HashMap<String, serde_json::Value>,
}

#[derive(Debug, Clone, Deserialize)]
pub struct SearchRequest {
    pub query: String,
    pub min_price: Option<f64>,
    pub max_price: Option<f64>,
    pub category_id: Option<i64>,
    pub brand_id: Option<i64>,
    pub products: Vec<ProductItem>,
}

#[derive(Debug, Clone, Serialize, Deserialize)]
pub struct ScoredProduct {
    pub id: i64,
    pub name: String,
    pub slug: Option<String>,
    pub price: f64,
    pub category_name: Option<String>,
    pub brand_name: Option<String>,
    pub short_description: Option<String>,
    pub match_score: f64,
}

#[derive(Debug, Clone, Serialize, Deserialize)]
pub struct SearchResponse {
    pub count: usize,
    pub results: Vec<ScoredProduct>,
}

#[derive(Debug, Clone, Deserialize)]
pub struct RecommendationRequest {
    pub target_id: i64,
    #[serde(default = "default_limit")]
    pub limit: usize,
    pub products: Vec<ProductItem>,
}

fn default_limit() -> usize {
    4
}

#[derive(Debug, Clone, Serialize, Deserialize)]
pub struct RecommendationItem {
    pub product_id: i64,
    pub similarity: f64,
    pub product: ProductItem,
}

#[derive(Debug, Clone, Serialize, Deserialize)]
pub struct RecommendationResponse {
    pub recommendations: Vec<RecommendationItem>,
}

#[derive(Debug, Clone, Deserialize)]
pub struct OrderRecord {
    pub id: i64,
    pub final_amount: f64,
    pub order_status: String,
    pub created_at: String,
}

#[derive(Debug, Clone, Deserialize)]
pub struct AnalyticsRequest {
    pub orders: Vec<OrderRecord>,
    pub products: Vec<ProductItem>,
}

#[derive(Debug, Clone, Serialize, Deserialize)]
pub struct AbcItem {
    pub id: i64,
    pub name: String,
    pub sales_value: f64,
    pub stock: i64,
    pub category: String,
}

#[derive(Debug, Clone, Serialize, Deserialize)]
pub struct AbcAnalysisResult {
    pub class_a_count: usize,
    pub class_b_count: usize,
    pub class_c_count: usize,
    pub top_revenue_items: Vec<AbcItem>,
}

#[derive(Debug, Clone, Serialize, Deserialize)]
pub struct AnalyticsResponse {
    pub total_revenue: f64,
    pub total_orders: usize,
    pub completed_orders_count: usize,
    pub forecast_next_day_revenue: f64,
    pub trend_slope: f64,
    pub abc_analysis: AbcAnalysisResult,
}

#[derive(Debug, Clone, Deserialize)]
pub struct ImageBatchRequest {
    pub images: Vec<String>,
    pub target_width: Option<u32>,
    pub target_height: Option<u32>,
}

#[derive(Debug, Clone, Serialize, Deserialize)]
pub struct ProcessedImageInfo {
    pub filename: String,
    pub simulated_original_bytes: usize,
    pub simulated_compressed_bytes: usize,
    pub compression_ratio: f64,
    pub output_format: String,
    pub status: String,
}

#[derive(Debug, Clone, Serialize, Deserialize)]
pub struct ImageBatchResponse {
    pub processed_count: usize,
    pub total_saved_bytes: usize,
    pub images: Vec<ProcessedImageInfo>,
}

#[derive(Debug, Clone, Serialize, Deserialize)]
pub struct HealthResponse {
    pub status: String,
    pub service: String,
    pub version: String,
    pub uptime_seconds: u64,
    pub worker_threads: usize,
}
