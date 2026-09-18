use crate::analytics::calculate_analytics;
use crate::image_processor::process_images_batch;
use crate::models::{
    AnalyticsRequest, HealthResponse, ImageBatchRequest, RecommendationRequest, SearchRequest,
};
use crate::recommender::generate_recommendations;
use crate::search::execute_search;
use std::time::Instant;

pub struct ServerContext {
    pub start_time: Instant,
}

pub fn handle_health(ctx: &ServerContext) -> String {
    let uptime = ctx.start_time.elapsed().as_secs();
    let resp = HealthResponse {
        status: "ok".to_string(),
        service: "rust-engine-microservice".to_string(),
        version: "0.1.0".to_string(),
        uptime_seconds: uptime,
        worker_threads: 1, // Native event loop execution model
    };
    serde_json::to_string(&resp).unwrap_or_else(|_| "{}".to_string())
}

pub fn handle_search(body: &str) -> Result<String, String> {
    let req: SearchRequest = serde_json::from_str(body).map_err(|e| e.to_string())?;
    let resp = execute_search(req);
    serde_json::to_string(&resp).map_err(|e| e.to_string())
}

pub fn handle_recommendations(body: &str) -> Result<String, String> {
    let req: RecommendationRequest = serde_json::from_str(body).map_err(|e| e.to_string())?;
    let resp = generate_recommendations(req);
    serde_json::to_string(&resp).map_err(|e| e.to_string())
}

pub fn handle_analytics(body: &str) -> Result<String, String> {
    let req: AnalyticsRequest = serde_json::from_str(body).map_err(|e| e.to_string())?;
    let resp = calculate_analytics(req);
    serde_json::to_string(&resp).map_err(|e| e.to_string())
}

pub fn handle_image_batch(body: &str) -> Result<String, String> {
    let req: ImageBatchRequest = serde_json::from_str(body).map_err(|e| e.to_string())?;
    let resp = process_images_batch(req);
    serde_json::to_string(&resp).map_err(|e| e.to_string())
}
