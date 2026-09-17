import os
import sqlite3
import re

print("=========================================================")
print("  ElectroStore Project Integrity & Verification Suite")
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

# 1. Check Directory Structure
print("[CHECK 1] Verifying Core Directory Structure...")
expected_dirs = [
    ".github/workflows",
    "app/config",
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

# 2. Check Key Files
print("\n[CHECK 2] Verifying Key Deliverables...")
expected_files = [
    ".github/workflows/ci.yml",
    "app/config/database.php",
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

# 3. Verify SQLite Database Content
print("\n[CHECK 3] Verifying SQLite Database Tables & Records...")
db_path = os.path.join(base_dir, "database", "electro.sqlite")
if os.path.isfile(db_path):
    conn = sqlite3.connect(db_path)
    cur = conn.cursor()

    cur.execute("SELECT COUNT(*) FROM products WHERE status = 1")
    active_prods = cur.fetchone()[0]
    check("Database has active electronics products", active_prods >= 10, f"Found {active_prods}")

    cur.execute("SELECT COUNT(*) FROM categories")
    categories_count = cur.fetchone()[0]
    check("Database has product categories", categories_count == 6, f"Found {categories_count}")

    cur.execute("SELECT COUNT(*) FROM brands")
    brands_count = cur.fetchone()[0]
    check("Database has tech brands", brands_count >= 5, f"Found {brands_count}")

    cur.execute("SELECT COUNT(*) FROM users WHERE role = 'admin'")
    admin_count = cur.fetchone()[0]
    check("Database has admin account", admin_count >= 1, f"Found {admin_count}")

    cur.execute("SELECT COUNT(*) FROM coupons")
    coupons_count = cur.fetchone()[0]
    check("Database has discount coupons", coupons_count >= 2, f"Found {coupons_count}")

    cur.execute("SELECT COUNT(*) FROM orders")
    orders_count = cur.fetchone()[0]
    check("Database has sample orders", orders_count >= 3, f"Found {orders_count}")

    conn.close()
else:
    check("SQLite DB file exists", False, "Missing database/electro.sqlite")

# 4. Check PHP Syntax Balance
print("\n[CHECK 4] Verifying PHP Syntax & Bracket Balance...")
php_files = []
for root, _, files in os.walk(base_dir):
    if ".git" in root or ".agents" in root or "rust-engine" in root:
        continue
    for f in files:
        if f.endswith(".php"):
            php_files.append(os.path.join(root, f))

for pf in php_files:
    rel = os.path.relpath(pf, base_dir)
    with open(pf, "r", encoding="utf-8", errors="ignore") as f:
        content = f.read()

    has_php_tag = "<?php" in content or "<?" in content
    check(f"PHP tag valid: {rel}", has_php_tag)

    # Simple parenthesis and bracket count
    open_curly = content.count("{")
    close_curly = content.count("}")
    # In views, php template syntax might have open/close across blocks, but controllers and models should match
    if "controllers" in rel or "models" in rel or "services" in rel:
        check(f"Braces balanced: {rel}", open_curly == close_curly, f"Open: {open_curly}, Close: {close_curly}")

# 5. Check Rust Engine Syntax Balance
print("\n[CHECK 5] Verifying Rust Syntax & Bracket Balance...")
rust_files = []
for root, _, files in os.walk(os.path.join(base_dir, "rust-engine")):
    for f in files:
        if f.endswith(".rs"):
            rust_files.append(os.path.join(root, f))

for rf in rust_files:
    rel = os.path.relpath(rf, base_dir)
    with open(rf, "r", encoding="utf-8") as f:
        content = f.read()
    open_curly = content.count("{")
    close_curly = content.count("}")
    check(f"Rust braces balanced: {rel}", open_curly == close_curly, f"Open: {open_curly}, Close: {close_curly}")

# 6. Check Thesis Report Completeness
print("\n[CHECK 6] Verifying Graduation Thesis Report...")
thesis_path = os.path.join(base_dir, "Bao_cao_DATN_Website_Thuong_Mai_Dien_Tu_Thiet_Bi_Dien_Tu.md")
with open(thesis_path, "r", encoding="utf-8") as f:
    report_text = f.read()

check("Report contains Chapter 1", "CHƯƠNG 1" in report_text)
check("Report contains Chapter 2", "CHƯƠNG 2" in report_text)
check("Report contains Chapter 3", "CHƯƠNG 3" in report_text)
check("Report contains Chapter 4", "CHƯƠNG 4" in report_text)
check("Report contains Chapter 5", "CHƯƠNG 5" in report_text)
check("Report details Cosine Similarity", "Cosine Similarity" in report_text)
check("Report details Levenshtein", "Levenshtein" in report_text)
check("Report details Pareto ABC", "Pareto" in report_text)
check("Report details CI/CD GitHub Actions", "GitHub Actions" in report_text)
check("Report has 20 test cases", "TC20" in report_text)

print("\n=========================================================")
print(f"  VERIFICATION RESULT: {checks - failures}/{checks} CHECKS PASSED")
if failures > 0:
    print(f"  {failures} CHECKS FAILED")
print("=========================================================")

exit(failures)
