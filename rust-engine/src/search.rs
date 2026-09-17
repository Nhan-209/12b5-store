use crate::models::{ProductItem, ScoredProduct, SearchRequest, SearchResponse};

/// Calculate Levenshtein distance between two strings
pub fn levenshtein_distance(s1: &str, s2: &str) -> usize {
    let s1_chars: Vec<char> = s1.chars().collect();
    let s2_chars: Vec<char> = s2.chars().collect();
    let len1 = s1_chars.len();
    let len2 = s2_chars.len();

    if len1 == 0 {
        return len2;
    }
    if len2 == 0 {
        return len1;
    }

    let mut dp = vec![vec![0; len2 + 1]; len1 + 1];

    for i in 0..=len1 {
        dp[i][0] = i;
    }
    for j in 0..=len2 {
        dp[0][j] = j;
    }

    for i in 1..=len1 {
        for j in 1..=len2 {
            let cost = if s1_chars[i - 1] == s2_chars[j - 1] { 0 } else { 1 };
            dp[i][j] = (dp[i - 1][j] + 1)
                .min(dp[i][j - 1] + 1)
                .min(dp[i - 1][j - 1] + cost);
        }
    }

    dp[len1][len2]
}

/// Execute high-speed fuzzy and token relevance search
pub fn execute_search(req: SearchRequest) -> SearchResponse {
    let q = req.query.trim().to_lowercase();
    let query_tokens: Vec<&str> = q.split_whitespace().collect();

    let mut scored_results: Vec<ScoredProduct> = Vec::new();

    for p in req.products {
        // Price filtering
        if let Some(min_p) = req.min_price {
            if p.price < min_p {
                continue;
            }
        }
        if let Some(max_p) = req.max_price {
            if p.price > max_p {
                continue;
            }
        }
        // Category filtering
        if let Some(cat_id) = req.category_id {
            if p.category_id != Some(cat_id) {
                continue;
            }
        }
        // Brand filtering
        if let Some(br_id) = req.brand_id {
            if p.brand_id != Some(br_id) {
                continue;
            }
        }

        if query_tokens.is_empty() {
            scored_results.push(ScoredProduct {
                id: p.id,
                name: p.name,
                slug: p.slug,
                price: p.price,
                category_name: p.category_name,
                brand_name: p.brand_name,
                short_description: p.short_description,
                match_score: 1.0,
            });
            continue;
        }

        // Build composite searchable text
        let mut text_parts = Vec::new();
        text_parts.push(p.name.to_lowercase());
        if let Some(ref b) = p.brand_name {
            text_parts.push(b.to_lowercase());
        }
        if let Some(ref c) = p.category_name {
            text_parts.push(c.to_lowercase());
        }
        if let Some(ref d) = p.short_description {
            text_parts.push(d.to_lowercase());
        }
        for (k, v) in &p.specs {
            text_parts.push(k.to_lowercase());
            text_parts.push(v.to_string().to_lowercase());
        }

        let full_text = text_parts.join(" ");
        let full_text_tokens: Vec<&str> = full_text.split_whitespace().collect();

        let mut score = 0.0;

        // 1. Exact phrase match
        if full_text.contains(&q) {
            score += 15.0;
        }

        // 2. Token overlap and fuzzy matching
        for q_tok in &query_tokens {
            let mut best_token_score = 0.0;

            for d_tok in &full_text_tokens {
                if d_tok == q_tok {
                    best_token_score = best_token_score.max(5.0);
                } else if d_tok.contains(q_tok) {
                    best_token_score = best_token_score.max(3.0);
                } else if q_tok.len() >= 4 && d_tok.len() >= 4 {
                    let dist = levenshtein_distance(q_tok, d_tok);
                    if dist == 1 {
                        best_token_score = best_token_score.max(2.0);
                    } else if dist == 2 && q_tok.len() >= 6 {
                        best_token_score = best_token_score.max(1.0);
                    }
                }
            }
            score += best_token_score;
        }

        if score > 0.0 {
            scored_results.push(ScoredProduct {
                id: p.id,
                name: p.name,
                slug: p.slug,
                price: p.price,
                category_name: p.category_name,
                brand_name: p.brand_name,
                short_description: p.short_description,
                match_score: (score * 100.0).round() / 100.0,
            });
        }
    }

    // Sort descending by score
    scored_results.sort_by(|a, b| b.match_score.total_cmp(&a.match_score));

    SearchResponse {
        count: scored_results.len(),
        results: scored_results,
    }
}

#[cfg(test)]
mod tests {
    use super::*;
    use std::collections::HashMap;

    #[test]
    fn test_levenshtein() {
        assert_eq!(levenshtein_distance("iphone", "iphone"), 0);
        assert_eq!(levenshtein_distance("iphone", "iphne"), 1);
        assert_eq!(levenshtein_distance("macbook", "machook"), 1);
        assert_eq!(levenshtein_distance("samsung", "smasung"), 2);
    }

    #[test]
    fn test_search_scoring() {
        let p1 = ProductItem {
            id: 1,
            name: "iPhone 16 Pro Max".to_string(),
            slug: Some("iphone-16".to_string()),
            price: 34000000.0,
            category_id: Some(1),
            brand_id: Some(1),
            category_name: Some("Điện thoại".to_string()),
            brand_name: Some("Apple".to_string()),
            short_description: Some("Titanium frame".to_string()),
            rating: Some(5.0),
            stock: Some(10),
            sales_count: Some(5),
            specs: HashMap::new(),
        };

        let req = SearchRequest {
            query: "iphone pro".to_string(),
            min_price: None,
            max_price: None,
            category_id: None,
            brand_id: None,
            products: vec![p1],
        };

        let res = execute_search(req);
        assert_eq!(res.count, 1);
        assert!(res.results[0].match_score > 0.0);
    }
}
