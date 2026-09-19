# Project: 12B5 Store E-Commerce Web Application

## Architecture
- **Presentation Layer**: PHP MVC pattern. Controllers in `app/controllers/`, Views in `app/views/`, Static Assets (CSS, JS, images) in `public/`.
- **Domain & Model Layer**: Models in `app/models/` (`Brand`, `Cart`, `Category`, `Database`, `Order`, `Product`, `User`). Atomic transactions for orders and stock management.
- **Core & Security**: Front Controller (`public/index.php`), dynamic `BASE_URL` detection, CSRF protection (`app/core/Csrf.php`), Session management.
- **Database Resilience**: Dual-engine auto-detection in `app/models/Database.php` and `app/config/database.php`. Supports MySQL (`12b5_store`) and automatic fallback to SQLite (`database/electro.sqlite`) with auto-migration and timeout resilience.
- **Dual Hosting Support**:
  1. XAMPP Apache subfolder mode (e.g. `http://localhost/12b5-store/public/` or `http://localhost/12b5-store/`).
  2. Standalone mode (`php -S localhost:8000 -t public`).
- **Testing & Verification**: CLI Test runner `tests/run_tests.php` and comprehensive HTTP flow verification suite `tests/HttpFlowTest.php`.

## Feature Inventory
| # | Feature | Description | Milestone | Source |
|---|---------|-------------|-----------|--------|
| 1 | Dynamic BASE_URL Detection | Robust calculation of `BASE_URL` handling Windows backslashes and subfolder prefixes | M1 | Survey R1 |
| 2 | Configurable BASE_URL Override | Safe override via `config.php` without breaking standalone auto-detection | M1 | Survey R1 |
| 3 | Controller Redirects Normalization | Prepend `BASE_URL` to all 8 hardcoded `header('Location: ...')` statements | M1 | Survey R1 |
| 4 | Form Actions Normalization | Prepend `BASE_URL` to admin product form action and all template forms | M1 | Survey R1 |
| 5 | Error Fallback Links Normalization | Prepend `BASE_URL` to inline 404/500 error pages in `public/index.php` | M1 | Survey R1 |
| 6 | Root Entry Routing | Add root `.htaccess` and root `index.php` forwarding to `public/` | M1 | Survey R1 |
| 7 | Startup Scripts PHP Path | Update `start.bat` and `start.ps1` to include `C:\xamppnp\php\php.exe` | M1 | Survey R1 |
| 8 | Config Override in Database Layer | Honor `config.php` constants (`DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS`, `DB_PORT`, `DB_DRIVER`) in `app/config/database.php` | M2 | Survey R2 |
| 9 | MySQL Connection Timeout | Add `PDO::ATTR_TIMEOUT => 2` to `connectMysql()` to prevent dead host hang | M2 | Survey R2 |
| 10 | SQLite Auto-Migration & Seeding | Auto-execute `schema_sqlite.sql` and `seed_sqlite.sql` if SQLite file or tables are missing | M2 | Survey R2 |
| 11 | Database Connection Reset | Add `Database::reset()` to enable runtime engine switching in tests | M2 | Survey R2 |
| 12 | Password Hash Integrity | Fix corrupted password hashes in `seed.sql`, `seed_sqlite.sql`, and live MySQL `12b5_store` for `admin123` / `user123` | M2 | Survey R2 |
| 13 | Coupon Removal Workflow | Allow removing applied coupon by submitting empty `coupon_code` to clear `$_SESSION['coupon']` | M3 | Survey R3 |
| 14 | Product Detail Quantity Selector | Fix input ID mismatch (`qty_` vs `qtyInput`) so fast AJAX Add to Cart adds selected quantity | M3 | Survey R3 |
| 15 | Shipping Fee Calculation | Incorporate 30,000₫ shipping fee into `Cart::getCart()` final amount calculation for orders under 5M | M3 | Survey R3 |
| 16 | CSRF Protection & AJAX Badges | Validate CSRF across AJAX & form submissions; ensure JSON responses update cart count badge | M3 | Survey R3 |
| 17 | Test Runner Session Warning Fix | Call `session_start()` before standard output in `tests/run_tests.php` to eliminate 17 warnings | M4 | Survey R4 |
| 18 | Programmatic HTTP Test Suite | Add `tests/HttpFlowTest.php` testing both Standalone and XAMPP URL modes, 200/302 status codes for Add to Cart, Login, Checkout | M4 | Survey R4 |
| 19 | Dual-Engine DB Test Verification | Verify 100% test pass on both MySQL and SQLite engines | M4 | Survey R4 |
| 20 | Adversarial Hardening & Forensic Audit | Complete review, challenger stress tests, and forensic integrity audit | M5 | Process Gate |

## Milestones
| # | Name | Scope | Dependencies | Status |
|---|------|-------|-------------|--------|
| M1 | Dual-Environment URL Routing & Asset Resolution | Features 1, 2, 3, 4, 5, 6, 7: `public/index.php`, `config.php`, controllers, views, root router, startup scripts | none | DONE |
| M2 | Database Dual-Engine Auto-Detection & Resilience | Features 8, 9, 10, 11, 12: `app/config/database.php`, `app/models/Database.php`, seeders, MySQL live table sync | none | DONE |
| M3 | Core E-Commerce & User Flow Integrity | Features 13, 14, 15, 16: `app/models/Cart.php`, `app/views/products/detail.php`, `public/js/app.js`, checkout/cart views | M1, M2 | DONE |
| M4 | Automated Test Suite & Dual-Track Verification | Features 17, 18, 19: `tests/run_tests.php`, `tests/HttpFlowTest.php`, full test execution | M1, M2, M3 | DONE |
| M5 | Adversarial Review & Forensic Integrity Audit | Feature 20: Independent Reviewers, Challengers, and Forensic Auditor verification | M4 | IN_PROGRESS |

## Interface Contracts

### 1. URL & Base URL Resolution Contract
- **Constant**: `BASE_URL`
- **Standalone Mode**: `BASE_URL === ''` (empty string)
- **XAMPP Subfolder Mode**: `BASE_URL === '/12b5-store/public'` (or `/12b5-store` if root rewritten)
- **Asset Links**: Must use `<?= BASE_URL ?>/css/...`, `<?= BASE_URL ?>/js/...`, `<?= BASE_URL ?>/images/...`
- **Redirects**: Must use `header('Location: ' . BASE_URL . '/target')`
- **Form Actions**: Must use `action="<?= BASE_URL ?>/target"`

### 2. Database Resilience Contract
- **Config Hierarchy**: `Environment Variable` > `config.php Constant` > `Default Value`
- **Connection Fallback**:
  1. In `driver => 'auto'`, try MySQL with `PDO::ATTR_TIMEOUT => 2`.
  2. If MySQL fails (or database has no tables), fall back to SQLite without throwing uncaught exceptions.
  3. In SQLite mode, if tables do not exist, auto-run `schema_sqlite.sql` and `seed_sqlite.sql`.
- **Query Compatibility**: All queries in models must remain compatible with both MySQL 8 and SQLite 3.
- **Connection Reset**: `Database::reset()` resets static instance and driver cache.

### 3. Cart & Checkout Flow Contract
- **AJAX Add to Cart**: `POST /cart/add` returns JSON `{ "success": true, "message": "...", "cart": { "total_items": N, "formatted_total": "..." } }`
- **Coupon Removal**: `POST /cart/coupon` with empty `coupon_code` removes coupon, clears `$_SESSION['coupon']`, and returns success.
- **Total Calculation**: `final_amount = max(0, subtotal - discount + (subtotal > 0 && subtotal < 5000000 ? 30000 : 0))`
- **Order Placement**: Atomically inserts order and items, decrements stock, updates coupon usage, clears cart, and sets `$_SESSION['last_order_code']`.

## Code Layout
- `app/config/database.php` - Database credentials & engine configuration
- `app/controllers/` - MVC controllers (`AdminController.php`, `AuthController.php`, `CartController.php`, `CheckoutController.php`, `HomeController.php`, `ProductController.php`)
- `app/core/` - Core utilities (`Csrf.php`, `Router.php`, `Session.php`)
- `app/models/` - Domain models (`Brand.php`, `Cart.php`, `Category.php`, `Database.php`, `Order.php`, `Product.php`, `User.php`)
- `app/views/` - PHP view templates (admin, auth, cart, checkout, home, products, layouts)
- `config.php` - Root environment configuration file
- `database/` - DDL schemas (`schema.sql`, `schema_sqlite.sql`), seed data (`seed.sql`, `seed_sqlite.sql`), migration runner (`migrate.php`)
- `public/` - Web root (`index.php`, `.htaccess`, `css/`, `js/`, `images/`)
- `tests/` - Test suites (`run_tests.php`, `CartTest.php`, `OrderTest.php`, `ProductTest.php`, `AuthTest.php`, `RustEngineClientTest.php`, `HttpFlowTest.php`)
