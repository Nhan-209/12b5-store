mod analytics;
mod handlers;
mod image_processor;
mod models;
mod recommender;
mod search;

use handlers::ServerContext;
use std::io::Read;
use std::sync::Arc;
use std::time::Instant;
use tiny_http::{Header, Response, Server, StatusCode};

fn main() {
    let port = std::env::var("RUST_PORT").unwrap_or_else(|_| "5000".to_string());
    let addr = format!("0.0.0.0:{}", port);

    println!("=======================================================");
    println!("  ElectroStore - Rust High-Performance Engine v0.1.0");
    println!("  Listening on http://{}", addr);
    println!("  Endpoints:");
    println!("    - GET  /api/health");
    println!("    - POST /api/search");
    println!("    - POST /api/recommendations");
    println!("    - POST /api/analytics");
    println!("    - POST /api/image/batch-process");
    println!("=======================================================");

    let server = match Server::http(&addr) {
        Ok(s) => s,
        Err(e) => {
            eprintln!("[FATAL] Failed to bind server on {}: {}", addr, e);
            std::process::exit(1);
        }
    };

    let ctx = Arc::new(ServerContext {
        start_time: Instant::now(),
    });

    for mut request in server.incoming_requests() {
        let ctx = Arc::clone(&ctx);

        let url = request.url().to_string();
        let method = request.method().as_str().to_uppercase();

        let mut body = String::new();
        if let Err(e) = request.as_reader().read_to_string(&mut body) {
            eprintln!("[WARN] Failed to read request body: {}", e);
        }

        let content_type = Header::from_bytes(&b"Content-Type"[..], &b"application/json"[..]).unwrap();
        let cors = Header::from_bytes(&b"Access-Control-Allow-Origin"[..], &b"*"[..]).unwrap();

        let (status_code, resp_body) = match (method.as_str(), url.as_str()) {
            ("GET", "/api/health") => (200, handlers::handle_health(&ctx)),
            ("POST", "/api/search") => match handlers::handle_search(&body) {
                Ok(res) => (200, res),
                Err(err) => (400, format!(r#"{{"error": "{}"}}"#, err)),
            },
            ("POST", "/api/recommendations") => match handlers::handle_recommendations(&body) {
                Ok(res) => (200, res),
                Err(err) => (400, format!(r#"{{"error": "{}"}}"#, err)),
            },
            ("POST", "/api/analytics") => match handlers::handle_analytics(&body) {
                Ok(res) => (200, res),
                Err(err) => (400, format!(r#"{{"error": "{}"}}"#, err)),
            },
            ("POST", "/api/image/batch-process") => match handlers::handle_image_batch(&body) {
                Ok(res) => (200, res),
                Err(err) => (400, format!(r#"{{"error": "{}"}}"#, err)),
            },
            _ => (404, r#"{"error": "Endpoint not found"}"#.to_string()),
        };

        let response = Response::from_string(resp_body)
            .with_status_code(StatusCode(status_code))
            .with_header(content_type)
            .with_header(cors);

        let _ = request.respond(response);
    }
}
