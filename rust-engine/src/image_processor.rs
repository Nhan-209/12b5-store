use crate::models::{ImageBatchRequest, ImageBatchResponse, ProcessedImageInfo};

pub fn process_images_batch(req: ImageBatchRequest) -> ImageBatchResponse {
    let mut processed = Vec::new();
    let mut total_saved: usize = 0;

    for img in req.images {
        // Simulated image dimension & compression calculations
        let simulated_orig_size: usize = 1024 * 1024 * 2; // ~2MB raw
        let simulated_comp_size: usize = (1024.0 * 240.0 * 0.75) as usize; // WebP ~180KB
        let saved = simulated_orig_size.saturating_sub(simulated_comp_size);
        total_saved += saved;

        let ratio = (simulated_comp_size as f64 / simulated_orig_size as f64) * 100.0;

        processed.push(ProcessedImageInfo {
            filename: img,
            simulated_original_bytes: simulated_orig_size,
            simulated_compressed_bytes: simulated_comp_size,
            compression_ratio: (ratio * 100.0).round() / 100.0,
            output_format: "webp".to_string(),
            status: "success".to_string(),
        });
    }

    ImageBatchResponse {
        processed_count: processed.len(),
        total_saved_bytes: total_saved,
        images: processed,
    }
}
