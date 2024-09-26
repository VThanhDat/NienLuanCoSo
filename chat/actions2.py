import mysql.connector
import json

config = {
    'user': 'root',
    'password': '',
    'host': 'localhost',
    'database': 'webcongnghe',
    'raise_on_warnings': True
}

def chuan_hoa(text):
    replacements = {
        "sp": "sản phẩm",
        "dmsp": "danh mục sản phẩm",
    }
    for word, replacement in replacements.items():
        text = text.replace(word, replacement)
    return text

def chuan_hoa_intents(intents):
    for key in ['patterns', 'responses']:
        if key in intents:
            intents[key] = [chuan_hoa(text) for text in intents[key]]
    return intents

class ActionGetDataNhanh():
    def GetDataBrand():
        conn = mysql.connector.connect(**config)
        cur = conn.cursor()
        cur.execute("SELECT * FROM tbl_brand")
        rows = cur.fetchall()
        brand_names = [row[1] for row in rows]
        brand_string = ", ".join(brand_names)
        intents = {
            "tag": "action_danhmucsanpham",
            "patterns": ["Các thương hiệu sp nào?"],
            "responses": ["Có {} thương hiệu trong cửa hàng đó là {}.".format(len(brand_names), brand_string)],
            "context": [""]
        }
        return intents

# Lấy dữ liệu từ file JSON hiện có
with open("intents.json", "r", encoding="utf-8") as file:
    existing_data = json.load(file)

# Thêm dữ liệu mới từ hàm GetDataBrand() vào danh sách intents
new_data = ActionGetDataNhanh.GetDataBrand()
new_data = chuan_hoa_intents(new_data)
existing_data['intents'].append(new_data)

# Ghi dữ liệu đã kết hợp vào tệp JSON
with open("intents2.json", "w", encoding="utf-8") as file:
    json.dump(existing_data, file, indent=4, ensure_ascii=False)
