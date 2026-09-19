# Original User Request

## Initial Request — 2026-09-19T02:36:28Z

Review, debug, and fix the 12B5 Store e-commerce web application so that it operates seamlessly both under XAMPP (Apache subfolder URL routing, MySQL database) and in standalone mode (PHP built-in server with flexible fallback to SQLite or MySQL), ensuring all critical shopping and authentication flows function without failure.

Working directory: c:\Users\Admin\Desktop\pc\doantotnghiep\12b5-store
Integrity mode: development

## Requirements

### R1. Dual-Environment URL Routing & Asset Resolution
The application must dynamically resolve base URLs, asset links (CSS, JavaScript, images), form action targets, AJAX endpoints, and HTTP redirects whether accessed via an Apache subfolder (e.g., `http://localhost/12b5-store/public/`) or via root-level execution (e.g., `php -S localhost:8000 -t public`). No hardcoded root paths (`/cart`, `/login`, etc.) may bypass the active base URL.

### R2. Database Dual-Engine Auto-Detection & Resilience
The database connection layer must honor configuration overrides from `config.php`, environment variables, and defaults. When running under XAMPP, it must reliably connect to the local MySQL instance (`12b5_store`). In standalone mode, if MySQL is unreachable, it must cleanly fall back to SQLite without fatal errors or broken schemas.

### R3. Core E-Commerce & User Flow Integrity
All user-facing workflows must function reliably in both hosting modes:
1. Product catalog browsing, filtering, and live search.
2. Cart operations (Add to Cart via AJAX and standard form, update item quantity, remove items, coupon discounts).
3. CSRF token validation and session persistence across page navigations and redirects.
4. User authentication (registration, login, logout, profile view) and Admin management panels.
5. Checkout completion and order placement recording into the database.

### R4. Comprehensive Automated Verification Suite
All existing test suites (`tests/run_tests.php` covering Auth, Cart, Order, Product, RustEngineClient) plus programmatic HTTP endpoint tests for both URL modes must execute and pass completely.

## Acceptance Criteria

### Environment & Routing
- [ ] In XAMPP mode (under `/12b5-store/public/`), all pages render CSS, JS, and images with HTTP 200 (no 404 broken asset links).
- [ ] In Standalone mode (under `http://localhost:8000/`), all pages and assets load properly without referencing `/12b5-store/public/`.
- [ ] All redirect targets (`header('Location: ...')`) dynamically prepend the appropriate `BASE_URL`.

### Shopping Cart & Session Logic
- [ ] Clicking "Thêm vào giỏ" (Add to Cart) on product cards or details successfully increments the cart count badge and returns an HTTP 200 JSON success response.
- [ ] CSRF validation succeeds on both AJAX and POST requests across session lifetimes in both environments.
- [ ] Cart summary page correctly calculates item subtotal, discounts, shipping, and total.

### Database & Authentication
- [ ] Connecting to XAMPP MySQL succeeds using credentials defined in `config.php` or `app/config/database.php`.
- [ ] If MySQL is unavailable in standalone mode, database operations execute against the SQLite database without crashing.
- [ ] User login and registration write to/read from the active database and maintain user session state.

### Automated Test Verification
- [ ] `php tests/run_tests.php` runs with 100% of test suites passing (0 failures, 0 errors).
- [ ] Programmatic end-to-end simulation confirms Add to Cart, Login, and Checkout response status codes are 200/302 as expected.
