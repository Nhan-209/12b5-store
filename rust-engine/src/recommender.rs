use crate::models::{ProductItem, RecommendationItem, RecommendationRequest, RecommendationResponse};
use std::collections::HashMap;

/// Build feature vector for electronic product
pub fn build_feature_vector(product: &ProductItem) -> HashMap<String, f64> {
    let mut vec = HashMap::new();

    // 1. Category feature
    if let Some(cat_id) = product.category_id {
        vec.insert(format!("cat_{}", cat_id), 2.5);
    }

    // 2. Brand feature
    if let Some(brand_id) = product.brand_id {
        vec.insert(format!("brand_{}", brand_id), 2.0);
    }

    // 3. Normalized price tier (logarithmic scaling)
    if product.price > 0.0 {
        let price_tier = (product.price.max(10000.0).log10() / 1.5).min(6.0).max(1.0);
        vec.insert("price_tier".to_string(), price_tier);
    }

    // 4. Technical specifications tokens
    for (_k, v) in &product.specs {
        let val_str = v.to_string().to_lowercase();
        let tokens: Vec<&str> = val_str.split(|c: char| !c.is_alphanumeric()).collect();
        for tok in tokens {
            if tok.len() >= 3 {
                vec.insert(format!("spec_{}", tok), 1.0);
            }
        }
    }

    vec
}

/// Calculate cosine similarity between two feature vectors
pub fn cosine_similarity(v1: &HashMap<String, f64>, v2: &HashMap<String, f64>) -> f64 {
    let mut dot_product = 0.0;
    let mut norm1 = 0.0;
    let mut norm2 = 0.0;

    for (k, val1) in v1 {
        norm1 += val1 * val1;
        if let Some(val2) = v2.get(k) {
            dot_product += val1 * val2;
        }
    }

    for (_k, val2) in v2 {
        norm2 += val2 * val2;
    }

    if norm1 <= 0.0 || norm2 <= 0.0 {
        return 0.0;
    }

    dot_product / (norm1.sqrt() * norm2.sqrt())
}

/// Compute top-N product recommendations for a target item
pub fn generate_recommendations(req: RecommendationRequest) -> RecommendationResponse {
    let target = match req.products.iter().find(|p| p.id == req.target_id) {
        Some(t) => t,
        None => {
            return RecommendationResponse {
                recommendations: Vec::new(),
            };
        }
    };

    let target_vec = build_feature_vector(target);
    let mut scored: Vec<RecommendationItem> = Vec::new();

    for p in &req.products {
        if p.id == req.target_id {
            continue;
        }

        let p_vec = build_feature_vector(p);
        let sim = cosine_similarity(&target_vec, &p_vec);

        if sim > 0.05 {
            scored.push(RecommendationItem {
                product_id: p.id,
                similarity: (sim * 10000.0).round() / 10000.0,
                product: p.clone(),
            });
        }
    }

    // Sort descending by similarity
    scored.sort_by(|a, b| b.similarity.total_cmp(&a.similarity));

    scored.truncate(req.limit);

    RecommendationResponse {
        recommendations: scored,
    }
}

#[cfg(test)]
mod tests {
    use super::*;

    #[test]
    fn test_cosine_similarity() {
        let mut v1 = HashMap::new();
        v1.insert("cat_1".to_string(), 2.5);
        v1.insert("brand_1".to_string(), 2.0);

        let mut v2 = HashMap::new();
        v2.insert("cat_1".to_string(), 2.5);
        v2.insert("brand_1".to_string(), 2.0);

        let sim = cosine_similarity(&v1, &v2);
        assert!((sim - 1.0).abs() < 1e-6);

        let mut v3 = HashMap::new();
        v3.insert("cat_2".to_string(), 2.5);
        v3.insert("brand_2".to_string(), 2.0);

        let sim_diff = cosine_similarity(&v1, &v3);
        assert_eq!(sim_diff, 0.0);
    }
}
