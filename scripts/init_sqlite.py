import sqlite3
import os

db_path = os.path.join(os.path.dirname(os.path.dirname(__file__)), 'database', 'electro.sqlite')
schema_path = os.path.join(os.path.dirname(os.path.dirname(__file__)), 'database', 'schema_sqlite.sql')
seed_path = os.path.join(os.path.dirname(os.path.dirname(__file__)), 'database', 'seed_sqlite.sql')

print(f"Initializing SQLite database at: {db_path}")

if os.path.exists(db_path):
    os.remove(db_path)

conn = sqlite3.connect(db_path)
cursor = conn.cursor()

with open(schema_path, 'r', encoding='utf-8') as f:
    schema_sql = f.read()
cursor.executescript(schema_sql)

with open(seed_path, 'r', encoding='utf-8') as f:
    seed_sql = f.read()
cursor.executescript(seed_sql)

conn.commit()

# Verify counts
cursor.execute("SELECT COUNT(*) FROM products")
prod_count = cursor.fetchone()[0]
cursor.execute("SELECT COUNT(*) FROM categories")
cat_count = cursor.fetchone()[0]
cursor.execute("SELECT COUNT(*) FROM users")
user_count = cursor.fetchone()[0]

print(f"SQLite DB initialized successfully!")
print(f"Products: {prod_count}, Categories: {cat_count}, Users: {user_count}")

conn.close()
