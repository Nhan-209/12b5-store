import sqlite3

conn = sqlite3.connect('database/electro.sqlite')
c = conn.cursor()
c.execute("UPDATE users SET password_hash = '$2y$10$7rLSvRVyTQORapkDOqmkhetjF6H9lJHngr4hJMSM2lHObJbW5EQh6' WHERE id = 1")
c.execute("UPDATE users SET password_hash = '$2y$10$J0pK/1DAyYxzDi5diGbfeCyyHJovwvHmjfqa06eq6ytcn7eTkNdD2' WHERE id = 2")
conn.commit()
conn.close()
print("Updated database/electro.sqlite successfully!")
