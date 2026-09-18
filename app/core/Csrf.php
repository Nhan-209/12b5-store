<?php
namespace App\Core;

/**
 * Cross-Site Request Forgery (CSRF) Protection Helper
 */
class Csrf {
    /**
     * Generate or retrieve current CSRF token from PHP Session
     */
    public static function token(): string {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        return $_SESSION['csrf_token'];
    }

    /**
     * Generate HTML hidden input field with CSRF token
     */
    public static function field(): string {
        return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(self::token(), ENT_QUOTES, 'UTF-8') . '">';
    }

    /**
     * Validate CSRF token against session token
     */
    public static function validate(?string $token = null): bool {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $sessionToken = $_SESSION['csrf_token'] ?? '';
        if (empty($sessionToken)) {
            return false;
        }

        $submittedToken = $token ?? $_POST['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
        if (empty($submittedToken) && function_exists('apache_request_headers')) {
            $headers = apache_request_headers();
            $submittedToken = $headers['X-CSRF-Token'] ?? $headers['X-Csrf-Token'] ?? '';
        }

        return !empty($submittedToken) && hash_equals($sessionToken, $submittedToken);
    }

    /**
     * Enforce CSRF check; abort with 403 HTTP status if invalid
     */
    public static function check(): void {
        if (!self::validate()) {
            http_response_code(403);
            header('Content-Type: text/html; charset=utf-8');
            echo "<!DOCTYPE html><html><head><meta charset='utf-8'><title>403 Forbidden - ElectroStore</title><link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css'></head><body class='bg-light d-flex align-items-center justify-content-center' style='min-height: 100vh;'><div class='text-center p-5 bg-white rounded-4 shadow-sm' style='max-width: 500px;'><h3>403 Forbidden</h3><p class='lead text-danger'>Mã xác thực CSRF không hợp lệ hoặc phiên làm việc đã hết hạn.</p><p class='text-muted small'>Vui lòng quay lại, tải lại trang và thực hiện lại thao tác.</p><a href='javascript:history.back()' class='btn btn-primary'>Quay lại</a></div></body></html>";
            exit;
        }
    }
}
