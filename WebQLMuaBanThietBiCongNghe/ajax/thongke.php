<?php
    $filepath = realpath(dirname(__FILE__));
    include_once($filepath . '/../lib/database.php');
    include_once($filepath . '/../helpers/format.php');


    require('../carbon/autoload.php');

    use Carbon\Carbon;
    use Carbon\CarbonInterval;
?>


<?php 
    $db = new Database();

    if(isset($_POST['thoigian'])){
        $thoigian = $_POST['thoigian']; // Lấy ra thời gian
    }else{
        $thoigian = '';
        $subdays = Carbon::now('Asia/Ho_Chi_Minh')->subdays(365)->toDateString(); // 365 ngày
    }

    if($thoigian == '7ngay'){
        $subdays = Carbon::now('Asia/Ho_Chi_Minh')->subdays(7)->toDateString(); // 7 ngày
    }elseif($thoigian == '30ngay'){
        $subdays = Carbon::now('Asia/Ho_Chi_Minh')->subdays(30)->toDateString(); // 30 ngày
    }elseif($thoigian == '90ngay'){
        $subdays = Carbon::now('Asia/Ho_Chi_Minh')->subdays(90)->toDateString(); // 90 ngày
    }elseif($thoigian == '365ngay'){
        $subdays = Carbon::now('Asia/Ho_Chi_Minh')->subdays(365)->toDateString(); // 365 ngày
    }    

    $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString(); // lấy time hiện tại

    if(isset($_POST['from_date']) && $_POST['from_to']){
        $from = $_POST['from_date'];
        $to = $_POST['from_to'];
        $query = "SELECT * FROM tbl_thongke where date_thongke between '$from' and '$to' order by date_thongke asc";
    }else{
        $query = "SELECT * FROM tbl_thongke where date_thongke between '$subdays' and '$now' order by date_thongke asc";
    }
    $result = $db->select($query);

    // dữ liệu là mảng gồm các phần tử phái dưới
    foreach($result as $key => $row){
        $chart_data[] = array(
            'date' => $row['date_thongke'],
            'revenue' => $row['doanhthu'],
            'quantity' => $row['soluong']
        );
    }

    echo $data = json_encode($chart_data);
?>

