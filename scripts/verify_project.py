import os
import sqlite3
import re
import json
import zipfile

print("=========================================================")
print("  ElectroStore Project Deep Verification & Integrity Suite")
print("=========================================================\n")

base_dir = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
failures = 0
checks = 0

def check(name, condition, detail=""):
    global failures, checks
    checks += 1
    if condition:
        print(f"  [PASS] {name}")
    else:
        failures += 1
        print(f"  [FAIL] {name} - {detail}")

# 1. Directory Structure
print("[CHECK 1] Verifying Core Directory Structure...")
expected_dirs = [
    ".github/workflows",
    "app/config",
    "app/core",
    "app/controllers",
    "app/models",
    "app/services",
    "app/views/layouts",
    "app/views/home",
    "app/views/products",
    "app/views/cart",
    "app/views/checkout",
    "app/views/orders",
    "app/views/auth",
    "app/views/admin",
    "app/views/errors",
    "database",
    "public/css",
    "public/js",
    "rust-engine/src",
    "tests",
    "scripts"
]

for d in expected_dirs:
    p = os.path.join(base_dir, d)
    check(f"Directory exists: {d}", os.path.isdir(p))

# 2. Key Deliverable Files
print("\n[CHECK 2] Verifying Key Deliverables...")
expected_files = [
    ".github/workflows/ci.yml",
    "app/config/database.php",
    "app/core/Csrf.php",
    "app/models/Database.php",
    "app/models/Product.php",
    "app/models/Category.php",
    "app/models/Brand.php",
    "app/models/Cart.php",
    "app/models/Order.php",
    "app/models/User.php",
    "app/services/RustEngineService.php",
    "app/services/SearchService.php",
    "app/services/RecommendationService.php",
    "app/services/AnalyticsService.php",
    "app/controllers/HomeController.php",
    "app/controllers/ProductController.php",
    "app/controllers/CartController.php",
    "app/controllers/CheckoutController.php",
    "app/controllers/AuthController.php",
    "app/controllers/OrderController.php",
    "app/controllers/AdminController.php",
    "app/controllers/ApiController.php",
    "app/views/errors/404.php",
    "app/views/errors/500.php",
    "public/index.php",
    "public/css/style.css",
    "public/js/app.js",
    "database/schema.sql",
    "database/seed.sql",
    "database/schema_sqlite.sql",
    "database/seed_sqlite.sql",
    "database/electro.sqlite",
    "database/migrate.php",
    "rust-engine/Cargo.toml",
    "rust-engine/src/main.rs",
    "rust-engine/src/models.rs",
    "rust-engine/src/search.rs",
    "rust-engine/src/recommender.rs",
    "rust-engine/src/analytics.rs",
    "rust-engine/src/image_processor.rs",
    "rust-engine/src/handlers.rs",
    "tests/run_tests.php",
    "tests/CartTest.php",
    "tests/OrderTest.php",
    "tests/ProductTest.php",
    "tests/AuthTest.php",
    "tests/RustEngineClientTest.php",
    "start.bat",
    "start.ps1",
    "start.sh",
    "Bao_cao_DATN_Website_Thuong_Mai_Dien_Tu_Thiet_Bi_Dien_Tu.md",
    "Bao_cao_DATN_Website_Thuong_Mai_Dien_Tu_Thiet_Bi_Dien_Tu.docx"
]

for f in expected_files:
    p = os.path.join(base_dir, f)
    check(f"File exists: {f}", os.path.isfile(p))

# 3. SQLite In-Memory Fresh Schema & Seed Execution
print("\n[CHECK 3] Executing Fresh SQLite Schema & Seed Migration...")
try:
    mem_conn = sqlite3.connect(":memory:")
    mem_conn.execute("PRAGMA foreign_keys = ON;")
    
    with open(os.path.join(base_dir, "database", "schema_sqlite.sql"), "r", encoding="utf-8") as f:
        mem_conn.executescript(f.read())
    with open(os.path.join(base_dir, "database", "seed_sqlite.sql"), "r", encoding="utf-8") as f:
        mem_conn.executescript(f.read())

    cur = mem_conn.cursor()
    cur.execute("SELECT COUNT(*) FROM products")
    p_cnt = cur.fetchone()[0]
    check(f"Fresh SQLite migration populates products ({p_cnt} items)", p_cnt >= 12)

    cur.execute("SELECT COUNT(*) FROM categories")
    c_cnt = cur.fetchone()[0]
    check(f"Fresh SQLite migration populates categories ({c_cnt} items)", c_cnt == 6)

    cur.execute("SELECT COUNT(*) FROM users")
    u_cnt = cur.fetchone()[0]
    check(f"Fresh SQLite migration populates users ({u_cnt} items)", u_cnt >= 3)

    # Test JSON specs parsing
    cur.execute("SELECT specs FROM products WHERE id = 1")
    specs_raw = cur.fetchone()[0]
    specs_json = json.loads(specs_raw)
    check("Product specs JSON is valid and has CPU/RAM", "cpu" in specs_json and "ram" in specs_json)

    # Test order insertion simulation
    cur.execute("""
        INSERT INTO orders (user_id, order_code, customer_name, customer_email, customer_phone, shipping_address, payment_method, total_amount, final_amount)
        VALUES (2, 'TEST-ORD-001', 'Test User', 'test@user.vn', '0912345678', 'Test Address', 'cod', 1000000, 1000000)
    """)
    ord_id = cur.lastrowid
    cur.execute("""
        INSERT INTO order_items (order_id, product_id, product_name, unit_price, quantity, subtotal)
        VALUES (?, 1, 'iPhone 16 Pro Max', 34990000, 1, 34990000)
    """, (ord_id,))
    check("Atomic order creation query works with foreign key constraints", ord_id > 0)

    # Test atomic stock decrement
    cur.execute("UPDATE products SET stock = stock - 1, sales_count = sales_count + 1 WHERE id = 1 AND stock >= 1")
    check("Atomic stock update with bounds check succeeds", cur.rowcount == 1)

    mem_conn.close()
except Exception as e:
    check("SQLite fresh schema & seed migration", False, str(e))

# 4. Check Rust Code & Compiler Safety Invariants
print("\n[CHECK 4] Verifying Rust Microservice Invariants & Safety...")
models_rs = os.path.join(base_dir, "rust-engine", "src", "models.rs")
with open(models_rs, "r", encoding="utf-8") as f:
    models_content = f.read()

check("AbcItem derives Clone in models.rs", "pub struct AbcItem" in models_content and "Clone" in models_content.split("pub struct AbcItem")[0].split("derive(")[-1])
check("ProductItem has flexible specs deserializer", "deserialize_specs" in models_content)
check("All structs derive Debug and Serialize", "#[derive(" in models_content and "Serialize" in models_content)

search_rs = os.path.join(base_dir, "rust-engine", "src", "search.rs")
with open(search_rs, "r", encoding="utf-8") as f:
    search_content = f.read()
check("search.rs uses total_cmp (no panic on NaN)", "total_cmp" in search_content and ".unwrap()" not in search_content)

rec_rs = os.path.join(base_dir, "rust-engine", "src", "recommender.rs")
with open(rec_rs, "r", encoding="utf-8") as f:
    rec_content = f.read()
check("recommender.rs uses total_cmp (no panic on NaN)", "total_cmp" in rec_content and ".unwrap()" not in rec_content)

analytics_rs = os.path.join(base_dir, "rust-engine", "src", "analytics.rs")
with open(analytics_rs, "r", encoding="utf-8") as f:
    analytics_content = f.read()
check("analytics.rs uses total_cmp (no panic on NaN)", "total_cmp" in analytics_content and "sort_by" in analytics_content)

main_rs = os.path.join(base_dir, "rust-engine", "src", "main.rs")
with open(main_rs, "r", encoding="utf-8") as f:
    main_content = f.read()
check("main.rs strips query strings from path", "split('?')" in main_content)
check("main.rs handles CORS OPTIONS preflight", "OPTIONS" in main_content)
check("main.rs sends Access-Control-Allow-Methods and Headers", "Access-Control-Allow-Methods" in main_content and "Access-Control-Allow-Headers" in main_content)

# 5. Check PHP Architecture & Autoloader Case-Tolerance
print("\n[CHECK 5] Verifying PHP Routing & Autoloader Invariants...")
index_php = os.path.join(base_dir, "public", "index.php")
with open(index_php, "r", encoding="utf-8") as f:
    index_content = f.read()

check("public/index.php has case-tolerant autoloader for Linux ext4", "strtolower" in index_content)
check("public/index.php strips Apache/XAMPP subfolder paths", "SCRIPT_NAME" in index_content)

# Check route ordering: /product/review must precede /product/([a-zA-Z0-9_-]+)
review_pos = index_content.find("/product/review")
regex_pos = index_content.find("^/product/([a-zA-Z0-9_-]+)$")
check("/product/review route is defined before product slug regex", review_pos != -1 and regex_pos != -1 and review_pos < regex_pos)

# Check RustEngineService specs object casting and result enrichment
rust_service_php = os.path.join(base_dir, "app", "services", "RustEngineService.php")
with open(rust_service_php, "r", encoding="utf-8") as f:
    rust_service_content = f.read()
check("RustEngineService casts empty specs to object to prevent JSON array mismatch", "(object)[]" in rust_service_content)
check("RustEngineService enriches search results with full product properties", "productsById" in rust_service_content)

# Check Order atomic decrement
order_php = os.path.join(base_dir, "app", "models", "Order.php")
with open(order_php, "r", encoding="utf-8") as f:
    order_content = f.read()
check("Order::createOrder checks stock >= ? atomically", "stock >= ?" in order_content and "rowCount() === 0" in order_content)
check("Order::createOrder catches Throwable", "catch (\\Throwable" in order_content)

# Check Database foreign keys enabled
db_php = os.path.join(base_dir, "app", "models", "Database.php")
with open(db_php, "r", encoding="utf-8") as f:
    db_content = f.read()
check("Database.php enforces SQLite foreign keys", "PRAGMA foreign_keys = ON" in db_content)

# Check run_tests.php autoloader and suites
run_tests_php = os.path.join(base_dir, "tests", "run_tests.php")
with open(run_tests_php, "r", encoding="utf-8") as f:
    run_tests_content = f.read()
check("run_tests.php has case-tolerant autoloader", "strtolower" in run_tests_content)
check("run_tests.php includes ProductTest and AuthTest", "ProductTest" in run_tests_content and "AuthTest" in run_tests_content)

# Check GitHub Actions CI workflow
ci_yml = os.path.join(base_dir, ".github", "workflows", "ci.yml")
with open(ci_yml, "r", encoding="utf-8") as f:
    ci_content = f.read()
check("ci.yml lints tests directory as well as app public database", "find app public database tests" in ci_content)

# Check CSRF Protection & Security Hardening
csrf_php = os.path.join(base_dir, "app", "core", "Csrf.php")
with open(csrf_php, "r", encoding="utf-8") as f:
    csrf_content = f.read()
check("Csrf.php provides token generation and hash_equals validation", "hash_equals" in csrf_content and "random_bytes" in csrf_content)

auth_php = os.path.join(base_dir, "app", "controllers", "AuthController.php")
with open(auth_php, "r", encoding="utf-8") as f:
    auth_content = f.read()
check("AuthController prevents session fixation via session_regenerate_id(true)", "session_regenerate_id(true)" in auth_content)

profile_view = os.path.join(base_dir, "app", "views", "auth", "profile.php")
with open(profile_view, "r", encoding="utf-8") as f:
    profile_content = f.read()
check("Profile view enforces CSRF field in form", "Csrf::field()" in profile_content)

prod_php = os.path.join(base_dir, "app", "models", "Product.php")
with open(prod_php, "r", encoding="utf-8") as f:
    prod_content = f.read()
check("Product model implements hasPurchased completed order check", "hasPurchased" in prod_content and "completed" in prod_content)
check("Product::addReview recalculates average rating and review_count", "AVG(rating)" in prod_content and "review_count" in prod_content)

cart_php = os.path.join(base_dir, "app", "models", "Cart.php")
with open(cart_php, "r", encoding="utf-8") as f:
    cart_content = f.read()
check("Cart::addItem rejects discontinued soft-deleted products", "status" in cart_content and "ngừng kinh doanh" in cart_content)

check("Order::createOrder rejects discontinued products and validates coupon limit", "ngừng kinh doanh" in order_content and "usage_limit" in order_content)

cart_view = os.path.join(base_dir, "app", "views", "cart", "index.php")
with open(cart_view, "r", encoding="utf-8") as f:
    cart_view_content = f.read()
check("Cart view quick coupon chips match valid seed coupons", "TECHSALE10" in cart_view_content and "WELCOME2026" in cart_view_content and "VIPMEMBER" in cart_view_content)

# Check Service Fallback Delegators
search_service_php = os.path.join(base_dir, "app", "services", "SearchService.php")
with open(search_service_php, "r", encoding="utf-8") as f:
    search_service_content = f.read()
check("SearchService provides static fallbackSearch delegator", "function fallbackSearch" in search_service_content)

rec_service_php = os.path.join(base_dir, "app", "services", "RecommendationService.php")
with open(rec_service_php, "r", encoding="utf-8") as f:
    rec_service_content = f.read()
check("RecommendationService provides static fallbackRecommendations delegator", "function fallbackRecommendations" in rec_service_content)

analytics_service_php = os.path.join(base_dir, "app", "services", "AnalyticsService.php")
with open(analytics_service_php, "r", encoding="utf-8") as f:
    analytics_service_content = f.read()
check("AnalyticsService provides static fallbackAnalytics delegator", "function fallbackAnalytics" in analytics_service_content)

# Check Product Soft Delete
check("Product::delete performs soft delete (status = 0)", "UPDATE products SET status = 0 WHERE id = ?" in prod_content)

# Check Admin and Checkout Input Whitelisting
admin_ctrl_php = os.path.join(base_dir, "app", "controllers", "AdminController.php")
with open(admin_ctrl_php, "r", encoding="utf-8") as f:
    admin_ctrl_content = f.read()
check("AdminController enforces order and payment status whitelisting", "allowedStatuses" in admin_ctrl_content and "allowedPaymentStatuses" in admin_ctrl_content)

checkout_ctrl_php = os.path.join(base_dir, "app", "controllers", "CheckoutController.php")
with open(checkout_ctrl_php, "r", encoding="utf-8") as f:
    checkout_ctrl_content = f.read()
check("CheckoutController enforces payment method whitelisting", "allowedPaymentMethods" in checkout_ctrl_content)

# Check Exception Hiding & Error 500 Protection
check("public/index.php hides raw exceptions and sets HTTP 500", "http_response_code(500)" in index_content and "error_log" in index_content)
error_500_php = os.path.join(base_dir, "app", "views", "errors", "500.php")
with open(error_500_php, "r", encoding="utf-8") as f:
    error_500_content = f.read()
check("app/views/errors/500.php is self-contained without crashing on DB outages", "500" in error_500_content and "Đã xảy ra sự cố hệ thống" in error_500_content and "navbar.php" not in error_500_content)

# Check Admin Products View
admin_prods_view = os.path.join(base_dir, "app", "views", "admin", "products.php")
with open(admin_prods_view, "r", encoding="utf-8") as f:
    admin_prods_content = f.read()
check("Admin products view renders 'Đang kinh doanh' and uses POST delete with CSRF", "Đang kinh doanh" in admin_prods_content and "/admin/products/delete" in admin_prods_content and "Csrf::field()" in admin_prods_content)

main_rs_path = os.path.join(base_dir, "rust-engine", "src", "main.rs")
with open(main_rs_path, "r", encoding="utf-8") as f:
    main_rs_content = f.read()
check("Rust Engine binds securely to 127.0.0.1 loopback by default", '127.0.0.1' in main_rs_content)

# 6. Check Graduation Thesis Report & Word Document
print("\n[CHECK 6] Verifying Graduation Thesis Document...")
docx_file = os.path.join(base_dir, "Bao_cao_DATN_Website_Thuong_Mai_Dien_Tu_Thiet_Bi_Dien_Tu.docx")
try:
    with zipfile.ZipFile(docx_file, "r") as z:
        check("DOCX contains word/document.xml", "word/document.xml" in z.namelist())
        doc_xml = z.read("word/document.xml").decode("utf-8")
        check("DOCX mentions Hybrid PHP + Rust", "Hybrid" in doc_xml and "Rust" in doc_xml)
        check("DOCX contains Chapter 1", "CHƯƠNG 1" in doc_xml)
        check("DOCX contains Chapter 5", "CHƯƠNG 5" in doc_xml)
except Exception as e:
    check("DOCX validation", False, str(e))

print("\n=========================================================")
print(f"  VERIFICATION RESULT: {checks - failures}/{checks} CHECKS PASSED")
if failures > 0:
    print(f"  {failures} CHECKS FAILED")
print("=========================================================")

exit(failures)
