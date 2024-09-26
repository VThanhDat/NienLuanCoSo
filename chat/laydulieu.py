import mysql.connector
import json

# Kết nối đến cơ sở dữ liệu
conn = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="webcongnghe"
)

# Cursor object để thực thi các truy vấn SQL
cursor = conn.cursor()

# Truy vấn dữ liệu từ bảng chatbot
sql = "SELECT id, tag, patterns, responses, context FROM chatbot"

cursor.execute(sql)

# Lấy kết quả từ truy vấn
rows = cursor.fetchall()

# In kết quả
for row in rows:
    id, tag, patterns, responses, context = row
    print(f"ID: {id}, Tag: {tag}, Patterns: {patterns}, Responses: {responses}, Context: {context}")

# Đóng kết nối
conn.close()
