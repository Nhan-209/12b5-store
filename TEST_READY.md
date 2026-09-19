# Automated Test Suite Verification & Readiness Guide

## 1. Executive Overview
The 12B5 Store e-commerce web application features a comprehensive, multi-tiered automated verification suite. The suite validates core domain logic, atomic transactions, authentication security, search/recommendation microservices, and end-to-end HTTP request/response lifecycles under both Standalone (`BASE_URL=""`) and Apache subfolder (`BASE_URL="/12b5-store/public"`) hosting environments across dual database engines (MySQL and SQLite).

The test suite runs cleanly via PHP CLI with **0 PHP warnings**, zero headers-already-sent notices, atomic transaction isolation, and self-healing test data cleanup.

---

## 2. Test Runner Invocation

### A. Default Execution (Automatic Engine Auto-Detection)
```powershell
& "C:\xamppnp\php\php.exe" tests/run_tests.php
```

### B. Explicit MySQL Verification
Executes the entire suite against the live MySQL/MariaDB database (`12b5_store` on port 3306):
```powershell
$env:DB_DRIVER="mysql"
& "C:\xamppnp\php\php.exe" tests/run_tests.php
```

### C. Explicit SQLite Verification
Executes the entire suite against the portable SQLite database (`database/electro.sqlite`) with self-healing auto-migration:
```powershell
$env:DB_DRIVER="sqlite"
& "C:\xamppnp\php\php.exe" tests/run_tests.php
```

### Exit Codes
- `0`: 100% of tests passed successfully.
- `1`: One or more tests failed or fatal error encountered.

---

## 3. Test Suite Inventory & Tier Breakdown

| Tier | Test Suite Class | Source File | Tests | Focus Area & Verified Behaviors |
| :--- | :--- | :--- | :---: | :--- |
| **Tier 1: Domain Models** | `Tests\CartTest` | `tests/CartTest.php` | 8 | Shopping cart item additions, quantity updates, stock threshold rejections, coupon application (`WELCOME2026`), coupon removal via empty string, cart item deletions, shipping fee calculation (30,000₫ for orders under 5M, 0₫ for >= 5M). |
| **Tier 1: Transactions** | `Tests\OrderTest` | `tests/OrderTest.php` | 4 | Atomic order creation within PDO transactions, stock decrements, order retrieval by unique `order_code`, and automatic rollback upon stock deficit. |
| **Tier 1: Catalog** | `Tests\ProductTest` | `tests/ProductTest.php` | 5 | Active products retrieval, slug lookup with JSON specifications parsing, multi-criteria filtering (category ID and price bounds), verified buyer reviews persistence, and purchase check validation. |
| **Tier 1: Security & Auth** | `Tests\AuthTest` | `tests/AuthTest.php` | 3 | Bcrypt password hash verification against seeded admin (`admin@electro.vn`), rejection of invalid credentials, customer registration, and profile verification. |
| **Tier 2: Services** | `Tests\RustEngineClientTest` | `tests/RustEngineClientTest.php` | 3 | Full-text search engine scoring, item-to-item recommendation matrix, revenue forecasting, and ABC inventory classification (with automatic PHP fallback). |
| **Tier 3: HTTP & Routing** | `Tests\HttpFlowTest` | `tests/HttpFlowTest.php` | 17 | Programmatic HTTP Front Controller simulation: Dual-environment asset resolution (Standalone vs XAMPP subfolder), dynamic redirect prepending, AJAX/Form cart additions, CSRF token validation & HTTP 403 rejection, coupon apply/reset, cart summary calculation, login authentication, checkout order placement, stock decrement, and order confirmation. |

**Total Test Count:** **40 Automated Tests** across 6 Suites (100% Pass Rate).

---

## 4. Key Verification Scenarios in `HttpFlowTest`

### A. Dual-Environment URL Routing & Asset Resolution (R1)
- **Standalone Root Mode (`BASE_URL = ""`):**
  - Requests to `/`, `/products`, `/product/iphone-16-pro-max-256gb`, and `/cart` return HTTP 200.
  - HTML renders clean relative asset paths (`<link rel="stylesheet" href="/css/style.css">`, `<script src="/js/app.js"></script>`).
  - Contains no `/12b5-store/public/` subfolder prefix and no Windows backslash path separator artifacts (`/\/css`).
- **Apache Subfolder Mode (`BASE_URL = "/12b5-store/public"`):**
  - Requests to `/12b5-store/public/` and `/12b5-store/public/products` return HTTP 200.
  - HTML renders assets dynamically prefixed with `/12b5-store/public/css/style.css` and `/12b5-store/public/js/app.js`.
  - Unauthenticated access to protected routes (e.g. `/12b5-store/public/profile`) issues HTTP 302 with `Location: /12b5-store/public/login`.

### B. Shopping Cart & Session Integrity (R3)
- **AJAX Add to Cart:**
  - Valid CSRF token returns HTTP 200 JSON with updated `cart.total_items` and `cart.formatted_total`.
  - Invalid or missing CSRF token returns HTTP 403 Forbidden with `{ "success": false }`.
- **Standard Form Add to Cart:**
  - POST submission returns HTTP 302 redirecting to `BASE_URL . '/cart'`.
- **Coupon Lifecycle:**
  - Applying code `WELCOME2026` applies fixed 500,000₫ discount.
  - Submitting empty code (`coupon_code = ""`) removes the coupon and resets discount to 0₫.
- **Cart Summary Calculation:**
  - Cart with items under 5,000,000₫ calculates 30,000₫ shipping fee and correct total amount.

### C. Authentication & Checkout (R2 & R3)
- **User Authentication:**
  - POST `/login` with seeded credentials (`customer@gmail.com` / `user123`) returns HTTP 302, regenerates session ID, and establishes authenticated user in session.
  - POST `/12b5-store/public/login` in subfolder mode dynamically redirects to `/12b5-store/public/`.
  - POST `/login` with incorrect password returns HTTP 200 with error notice and does not create user session.
- **Checkout & Order Placement:**
  - POST `/checkout/process` with active cart and valid CSRF completes order placement.
  - Returns HTTP 302 redirect to `/checkout/success?code=ORD-...`.
  - Atomically writes order into `orders` table and items into `order_items` table.
  - Automatically decrements product stock and records shipping fee.
  - Verified with automatic test cleanup to guarantee database idempotency.

---

## 5. Dual Database Engine Support

Both database engines are fully supported and verified:
1. **MySQL / MariaDB (`12b5_store`):**
   - Verified on local instance `127.0.0.1:3306`.
   - All 11 relational tables, seeded bcrypt hashes, and foreign key constraints verified.
2. **SQLite (`database/electro.sqlite`):**
   - Zero-configuration portable database.
   - Self-healing auto-migration triggers automatically if the SQLite file or tables are absent.
