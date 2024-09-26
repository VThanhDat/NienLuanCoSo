from rasa_sdk import Action,Tracker
import mysql.connector
from rasa_sdk.events import SlotSet

config = {
            'user': 'root',
            'password': '',
            'host': 'localhost',
            'database': 'dl_tuyen_sinh',
            'raise_on_warnings': True
        }

def chuan_hoa(text):
    if(text=="cntt"):
        return "Công nghệ thông tin"
    elif(text == "khmt"):
        return "Khoa học máy tính"
    elif(text == "antt"):
        return "An toàn thông tin"
    elif(text == "httt"):
        return "Hệ thống thông tin"
    else:
        return text
    
# print(chuan_hoa("cntt"))
    
def chuan_hoa_pt(text):
    if(text == "Phương thức 1"):
        return "PT1"
    elif(text == "Phương thức 2"):
        return "PT2"
    elif(text == "Phương thức 3"):
        return "PT3"
    elif(text == "Phương thức 4"):
        return "PT4"    
    elif(text == "Phương thức 5"):
        return "PT5"
    elif(text == "Phương thức 6"):
        return "PT6"
    else:
        return text

class ActionUpdateNganhHocSlot(Action):
    def name(self):
        return "action_update_nganh_hoc_slot"
    def run(self, dispatcher, tracker, domain):
        nganh_hoc_values = list(tracker.get_latest_entity_values("nganh"))
        if nganh_hoc_values:
            nganh_hoc_value = nganh_hoc_values[-1]
            return [SlotSet("nganh_hoc", nganh_hoc_value)]
        else:
            return []

class ActionGetDataNhanh(Action):
    def name(self):
        return "action_hoi_nganh"
    
    def run(self, dispatcher, tracker:Tracker, domain):
        
        conn = mysql.connector.connect(**config)
        cursor = conn.cursor()
        cursor.execute("SELECT ten_nganh FROM nganh_hoc")
        rows = cursor.fetchall()
        dispatcher.utter_message(text="Trường mình năm nay tuyển sinh các ngành sau:")
        i = 1
        for data in rows:
            text = str(i) + ". " + data[0]
            i = i + 1
            dispatcher.utter_message(text=text)
        return []

class ActionGetData(Action):
    def name(self):
        return "action_gioi_thieu"
    
    def run(self, dispatcher, tracker:Tracker, domain):
        get_nganh = next(tracker.get_latest_entity_values('nganh'))
        get_nganh = chuan_hoa(get_nganh)
        conn = mysql.connector.connect(**config)
        cursor = conn.cursor()
        sql_query = "SELECT gioi_thieu FROM nganh_hoc WHERE ten_nganh LIKE %s"
        cursor.execute(sql_query, ('%' + get_nganh + '%',))
        rows = cursor.fetchall()
        if rows:
            data = rows[0][0]
            dispatcher.utter_message(text=data)
        else:
            dispatcher.utter_message(text="Xin lỗi, tôi không hiểu yêu cầu của bạn. vui lòng nêu rõ câu hỏi hơn")
        return []

class GetData(Action):
    def name(self):
        return "action_hoc_phi"
    
    def run(self, dispatcher, tracker:Tracker, domain):
        get_nganh = next(tracker.get_latest_entity_values('nganh'),None)
        if get_nganh == None:
            get_nganh = tracker.get_slot("nganh_hoc")
        get_nganh = chuan_hoa(get_nganh)
        
        conn = mysql.connector.connect(**config)
        cursor = conn.cursor()

        sql_query = "SELECT h.nam_hoc,h.h_phi FROM nganh_hoc n join hoc_phi_nganh h on n.ma_nganh=h.ma_nganh WHERE ten_nganh LIKE %s"
        cursor.execute(sql_query, ('%' + get_nganh + '%',))

        rows = cursor.fetchall()
        if rows: 

            txt = "Học phí ngành " + get_nganh + " trong năm " + str(rows[0][0]) + " là " + str(rows[0][1]) + " đồng trên một năm"
            dispatcher.utter_message(text=txt)
        else:
            dispatcher.utter_message(text="Xin lỗi, tôi không hiểu yêu cầu của bạn. vui lòng nêu rõ câu hỏi hơn")
        return []

        
class GetDataptxt(Action):
    def name(self):
        return "action_phuong_thuc_ten"
    
    def run(self, dispatcher, tracker:Tracker, domain):
        get_nganh = next(tracker.get_latest_entity_values('nganh'),None)

        if get_nganh == None:
            get_nganh = tracker.get_slot("nganh_hoc")
        get_nganh = chuan_hoa(get_nganh)
        
        conn = mysql.connector.connect(**config)
        cursor = conn.cursor()

        sql_query = "SELECT p.Ten_pt FROM nganh_hoc n join nganh_hoc_phuong_thuc_xet_tuyen h on n.ma_nganh=h.ma_nganh join pt_xet_tuyen p on h.ma_pt = p.ma_pt WHERE ten_nganh LIKE %s"
        cursor.execute(sql_query, ('%' + get_nganh + '%',))

        rows = cursor.fetchall()
        dispatcher.utter_message(text="Ngành mình có phương thức xét tuyển sau:")
        if rows:
            i= 0
            for it in rows:
                i = i+1
                txt = "Phương thức "+ str(i) +": "+ it[0]
                dispatcher.utter_message(text=txt)
        else:
            dispatcher.utter_message(text="Xin lỗi, tôi không hiểu yêu cầu của bạn. vui lòng nêu rõ câu hỏi hơn")
        return []
    
class GetDataViecLam(Action):
    def name(self):
        return "action_viec_lam"
    
    def run(self, dispatcher, tracker:Tracker, domain):
        get_nganh = next(tracker.get_latest_entity_values('nganh'),None)

        if get_nganh == None:
            get_nganh = tracker.get_slot("nganh_hoc")
        get_nganh = chuan_hoa(get_nganh)
        
        conn = mysql.connector.connect(**config)
        cursor = conn.cursor()

        sql_query = "SELECT c.vt_lam_viec FROM nganh_hoc n join co_hoi_nghe_nghiep c on n.ma_nganh=c.ma_nganh WHERE ten_nganh LIKE %s"
        cursor.execute(sql_query, ('%' + get_nganh + '%',))
        rows = cursor.fetchall()

        
        if rows:
            cac_phan = rows[0][0].split('\r\n')
            dispatcher.utter_message(text="Ngành mình có các công việc sau khi ra trường là:")
            i= 0
            for it in cac_phan:
                i = i+1
                txt = str(i) +". "+ it
                dispatcher.utter_message(text=txt)
        else:
            dispatcher.utter_message(text="Xin lỗi, tôi không hiểu yêu cầu của bạn. vui lòng nêu rõ câu hỏi hơn")
        return []

class GetDataHoiDiem(Action):
    def name(self):
        return "action_hoi_diem"
    
    def run(self, dispatcher, tracker:Tracker, domain):
        get_nganh = next(tracker.get_latest_entity_values('nganh'),None)

        if get_nganh == None:
            get_nganh = tracker.get_slot("nganh_hoc")
        get_nganh = chuan_hoa(get_nganh)
        
        conn = mysql.connector.connect(**config)
        cursor = conn.cursor()
        sql_query = "SELECT h.nam_hoc,h.diem_hb,h.diem_thpt FROM nganh_hoc n join hoc_phi_nganh h on n.ma_nganh=h.ma_nganh WHERE ten_nganh LIKE %s"
        cursor.execute(sql_query, ('%' + get_nganh + '%',))

        rows = cursor.fetchall()
        if rows:
            dispatcher.utter_message(text="Trong năm "+ str(rows[0][0]) + " Trường mình tuyển sinh điểm như sau:")
            dispatcher.utter_message(text="Điểm học bạ là: "+ str(rows[0][1]))
            dispatcher.utter_message(text="Điểm thi trung học phổ thông quốc gia là: "+ str(rows[0][2]))
        else:
            dispatcher.utter_message(text="Xin lỗi, tôi không hiểu yêu cầu của bạn. vui lòng nêu rõ câu hỏi hơn")
        return []

class GetDataChiTieu(Action):
    def name(self):
        return "action_chi_tieu"
    
    def run(self, dispatcher, tracker:Tracker, domain):
        get_nganh = next(tracker.get_latest_entity_values('nganh'),None)
        if get_nganh == None:
            get_nganh = tracker.get_slot("nganh_hoc")
        get_nganh = chuan_hoa(get_nganh)
        
        conn = mysql.connector.connect(**config)
        cursor = conn.cursor()
        sql_query = "SELECT h.nam_hoc,h.chi_tieu FROM nganh_hoc n join hoc_phi_nganh h on n.ma_nganh=h.ma_nganh WHERE ten_nganh LIKE %s"
        cursor.execute(sql_query, ('%' + get_nganh + '%',))

        rows = cursor.fetchall()
        if rows: 
            txt = "Chỉ tiêu ngành " + get_nganh + " trong năm " + str(rows[0][0]) + " là: " + str(rows[0][1])
            dispatcher.utter_message(text=txt)
        else:
            dispatcher.utter_message(text="Xin lỗi, tôi không hiểu yêu cầu của bạn. vui lòng nêu rõ câu hỏi hơn")
        return []

class GetDatadk(Action):
    def name(self):
        return "action_dieu_kien_xt"
    
    def run(self, dispatcher, tracker:Tracker, domain):
        phuong_thuc = next(tracker.get_latest_entity_values('phuong_thuc'),None)
        phuong_thuc = chuan_hoa_pt(phuong_thuc)
        conn = mysql.connector.connect(**config)
        cursor = conn.cursor()
        sql_query = "SELECT n.dk_xt FROM `pt_xet_tuyen` n WHERE n.ma_pt =  %s"
        cursor.execute(sql_query, (phuong_thuc,))

        rows = cursor.fetchall()
        if rows: 
            txt = phuong_thuc + " có điều kiện như sau:"
            dispatcher.utter_message(text=txt)
            dispatcher.utter_message(text=rows[0][0])
            
        else:
            dispatcher.utter_message(text="Xin lỗi, tôi không hiểu yêu cầu của bạn. vui lòng nêu rõ câu hỏi hơn")
        return []

class GetDatadt(Action):
    def name(self):
        return "action_doi_tuong_xt"
    
    def run(self, dispatcher, tracker:Tracker, domain):
        phuong_thuc = next(tracker.get_latest_entity_values('phuong_thuc'),None)
        phuong_thuc = chuan_hoa_pt(phuong_thuc)
        conn = mysql.connector.connect(**config)
        cursor = conn.cursor()
        sql_query = "SELECT n.doi_tuong_xt FROM `pt_xet_tuyen` n WHERE n.ma_pt =  %s"
        cursor.execute(sql_query, (phuong_thuc,))

        rows = cursor.fetchall()
        if rows: 
            txt = phuong_thuc + " có đối tượng như sau:"
            dispatcher.utter_message(text=txt)
            dispatcher.utter_message(text=rows[0][0])
            
        else:
            dispatcher.utter_message(text="Xin lỗi, tôi không hiểu yêu cầu của bạn. vui lòng nêu rõ câu hỏi hơn")
        return []
    
class GetDatant(Action):
    def name(self):
        return "action_nguyen_tac_xt"
    
    def run(self, dispatcher, tracker:Tracker, domain):
        phuong_thuc = next(tracker.get_latest_entity_values('phuong_thuc'),None)
        phuong_thuc = chuan_hoa_pt(phuong_thuc)
        conn = mysql.connector.connect(**config)
        cursor = conn.cursor()
        sql_query = "SELECT n.nguyen_tac_xt FROM `pt_xet_tuyen` n WHERE n.ma_pt =  %s"
        cursor.execute(sql_query, (phuong_thuc,))

        rows = cursor.fetchall()
        if rows: 
            txt = phuong_thuc + " có nguyên tắc xét tuyển như sau:"
            dispatcher.utter_message(text=txt)
            dispatcher.utter_message(text=rows[0][0])
            
        else:
            dispatcher.utter_message(text="Xin lỗi, tôi không hiểu yêu cầu của bạn. vui lòng nêu rõ câu hỏi hơn")
        return []

class GetDatanoidung(Action):
    def name(self):
        return "action_noi_dung_xt"
    
    def run(self, dispatcher, tracker:Tracker, domain):
        phuong_thuc = next(tracker.get_latest_entity_values('phuong_thuc'),None)
        phuong_thuc = chuan_hoa_pt(phuong_thuc)
        conn = mysql.connector.connect(**config)
        cursor = conn.cursor()
        sql_query = "SELECT n.diem_xt FROM `pt_xet_tuyen` n WHERE n.ma_pt =  %s"
        cursor.execute(sql_query, (phuong_thuc,))

        rows = cursor.fetchall()
        if rows: 
            txt = phuong_thuc + " có nội dung như sau:"
            dispatcher.utter_message(text=txt)
            dispatcher.utter_message(text=rows[0][0])
            
        else:
            dispatcher.utter_message(text="Xin lỗi, tôi không hiểu yêu cầu của bạn. vui lòng nêu rõ câu hỏi hơn")
        return []
    
class GetDatatoan(Action):
    def name(self):
        return "action_hoi_ve_toan"
    
    def run(self, dispatcher, tracker:Tracker, domain):
        phuong_thuc = "2"
        conn = mysql.connector.connect(**config)
        cursor = conn.cursor()
        sql_query = "SELECT c.tra_loi FROM `chatbot` c WHERE c.STT = %s"
        cursor.execute(sql_query, (phuong_thuc,))
        rows = cursor.fetchall()
        if rows: 
            dispatcher.utter_message(text=rows[0][0])
            
        else:
            dispatcher.utter_message(text="Xin lỗi, tôi không hiểu yêu cầu của bạn. vui lòng nêu rõ câu hỏi hơn")
        return []

class GetDatakynang(Action):
    def name(self):
        return "action_ky_nang_nganh"
    
    def run(self, dispatcher, tracker:Tracker, domain):
        phuong_thuc = "1"
        conn = mysql.connector.connect(**config)
        cursor = conn.cursor()
        sql_query = "SELECT c.tra_loi FROM `chatbot` c WHERE c.STT = %s"
        cursor.execute(sql_query, (phuong_thuc,))
        rows = cursor.fetchall()
        if rows: 
            dispatcher.utter_message(text=rows[0][0])
            
        else:
            dispatcher.utter_message(text="Xin lỗi, tôi không hiểu yêu cầu của bạn. vui lòng nêu rõ câu hỏi hơn")
        return []

class GetDatahoatdong(Action):
    def name(self):
        return "action_hoat_dong_truong"
    
    def run(self, dispatcher, tracker:Tracker, domain):
        Stt = "17"
        conn = mysql.connector.connect(**config)
        cursor = conn.cursor()
        sql_query = "SELECT c.tra_loi FROM `chatbot` c WHERE c.STT = %s"
        cursor.execute(sql_query,(Stt,))
        rows = cursor.fetchall()
        if rows: 
            dispatcher.utter_message(text=rows[0][0])
            
        else:
            dispatcher.utter_message(text="Xin lỗi, tôi không hiểu yêu cầu của bạn. vui lòng nêu rõ câu hỏi hơn")
        return []

class GetDatahocbong(Action):
    def name(self):
        return "action_hoc_bong"
    
    def run(self, dispatcher, tracker:Tracker, domain):
        Stt = "18"
        conn = mysql.connector.connect(**config)
        cursor = conn.cursor()
        sql_query = "SELECT c.tra_loi FROM `chatbot` c WHERE c.STT = %s"
        cursor.execute(sql_query,(Stt,))
        rows = cursor.fetchall()
        if rows: 
            dispatcher.utter_message(text=rows[0][0])
        else:
            dispatcher.utter_message(text="Xin lỗi, tôi không hiểu yêu cầu của bạn. vui lòng nêu rõ câu hỏi hơn")
        return []

class GetDatahocphi(Action):
    def name(self):
        return "action_ho_tro_hoc_phi"
    
    def run(self, dispatcher, tracker:Tracker, domain):
        Stt = "19"
        conn = mysql.connector.connect(**config)
        cursor = conn.cursor()
        sql_query = "SELECT c.tra_loi FROM `chatbot` c WHERE c.STT = %s"
        cursor.execute(sql_query,(Stt,))
        rows = cursor.fetchall()
        if rows: 
            dispatcher.utter_message(text=rows[0][0])
            
        else:
            dispatcher.utter_message(text="Xin lỗi, tôi không hiểu yêu cầu của bạn. vui lòng nêu rõ câu hỏi hơn")
        return []

class GetDatassnganh(Action):
    def name(self):
        return "action_so_sanh_nganh"
    
    def run(self, dispatcher, tracker:Tracker, domain):
        Stt = "20"
        conn = mysql.connector.connect(**config)
        cursor = conn.cursor()
        sql_query = "SELECT c.tra_loi FROM `chatbot` c WHERE c.STT = %s"
        cursor.execute(sql_query,(Stt,))
        rows = cursor.fetchall()
        if rows: 
            dispatcher.utter_message(text=rows[0][0])
            
        else:
            dispatcher.utter_message(text="Xin lỗi, tôi không hiểu yêu cầu của bạn. vui lòng nêu rõ câu hỏi hơn")
        return []
    
class GetDatanoidung(Action):
    def name(self):
        return "action_noi_dung_xt"
    
    def run(self, dispatcher, tracker:Tracker, domain):
        Stt = "14"
        conn = mysql.connector.connect(**config)
        cursor = conn.cursor()
        sql_query = "SELECT c.tra_loi FROM `chatbot` c WHERE c.STT = %s"
        cursor.execute(sql_query,(Stt,))
        rows = cursor.fetchall()
        if rows: 
            dispatcher.utter_message(text=rows[0][0])
            
        else:
            dispatcher.utter_message(text="Xin lỗi, tôi không hiểu yêu cầu của bạn. vui lòng nêu rõ câu hỏi hơn")
        return [] 