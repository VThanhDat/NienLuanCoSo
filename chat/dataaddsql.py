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

# Load dữ liệu từ file JSON
with open('intents2.json', 'r', encoding='utf-8') as file:
    data = json.load(file)
# Lặp qua từng item trong danh sách intents trong JSON
for intent in data["intents"]:
    tag = intent["tag"]
    patterns = json.dumps(intent["patterns"], ensure_ascii=False).replace('["', '').replace('"]', '')
    responses = json.dumps(intent["responses"], ensure_ascii=False).replace('["', '').replace('"]', '')
    context = json.dumps(intent["context"], ensure_ascii=False).replace('["', '').replace('"]', '')

    # Thêm dữ liệu vào bảng chatbot với mỗi tag
    sql = "INSERT INTO chatbot (tag, patterns, responses, context) VALUES (%s, %s, %s, %s)"
    val = (tag, patterns, responses, context)

    cursor.execute(sql, val)

    # Lưu các thay đổi
    conn.commit()

# Đóng kết nối
conn.close()
