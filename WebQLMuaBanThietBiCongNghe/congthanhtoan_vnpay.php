<?php
    //code thanh toán vnpay
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    /*
        * To change this license header, choose License Headers in Project Properties.
        * To change this template file, choose Tools | Templates
        * and open the template in the editor.
        */

    $vnp_TmnCode = "06IZ70U6"; //Mã định danh merchant kết nối (Terminal Id)
    $vnp_HashSecret = "OTKUYUTXOKGLYFNJAMFFYKACBSBEWOAY"; //Secret key
    $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
    $vnp_Returnurl = "http://localhost:3000/donhangthanhtoanonline.php";
    $vnp_apiUrl = "http://sandbox.vnpayment.vn/merchant_webapi/merchant.html";
    $apiUrl = "https://sandbox.vnpayment.vn/merchant_webapi/api/transaction";
    //Config input format
    //Expire
    $startTime = date("YmdHis");
    $expire = date('YmdHis', strtotime('+15 minutes', strtotime($startTime)));
    $vnp_TxnRef = time(); //Mã giao dịch thanh toán tham chiếu của merchant
    $vnp_OrderInfo = 'vnpay';
    $vnp_OrderType = 'order';
    $vnp_Amount = $_POST['total_congthanhtoan']; // Số tiền thanh toán
    $vnp_Locale = 'vn'; //Ngôn ngữ chuyển hướng thanh toán
    $vnp_BankCode ='NCB'; //Mã phương thức thanh toán
    $vnp_IpAddr = $_SERVER['REMOTE_ADDR']; //IP Khách hàng thanh toán

    $inputData = array(
        "vnp_Version" => "2.1.0",
        "vnp_TmnCode" => $vnp_TmnCode,
        "vnp_Amount" => $vnp_Amount * 100,
        "vnp_Command" => "pay",
        "vnp_CreateDate" => date('YmdHis'),
        "vnp_CurrCode" => "VND",
        "vnp_IpAddr" => $vnp_IpAddr,
        "vnp_Locale" => $vnp_Locale,
        "vnp_OrderInfo" => $vnp_OrderInfo,
        "vnp_OrderType" => $vnp_OrderType,
        "vnp_ReturnUrl" => $vnp_Returnurl,
        "vnp_TxnRef" => $vnp_TxnRef,
        "vnp_ExpireDate" => $expire
    );

    if (isset($vnp_BankCode) && $vnp_BankCode != "") {
        $inputData['vnp_BankCode'] = $vnp_BankCode;
    }

    ksort($inputData);
    $query = "";
    $i = 0;
    $hashdata = "";
    foreach ($inputData as $key => $value) {
        if ($i == 1) {
            $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
        } else {
            $hashdata .= urlencode($key) . "=" . urlencode($value);
            $i = 1;
        }
        $query .= urlencode($key) . "=" . urlencode($value) . '&';
    }

    $vnp_Url = $vnp_Url . "?" . $query;
    if (isset($vnp_HashSecret)) {
        $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
        $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
    }
    $returnData = array('code'=>'00'
    , 'message' => 'success'
    , 'data' => $vnp_Url);
    if(isset($_POST['redirect'])){
        header('Location: '.$vnp_Url);
        die();
    }else{
        echo json_encode($returnData);
    }
    //code thanh toán momo
    //code thanh toán paypal
    //code thanh toán onepay

?>

<!-- vnp_Amount=2500000000&
vnp_BankCode=NCB&
vnp_BankTranNo=VNP14261471&
vnp_CardType=ATM&
vnp_OrderInfo=thanh+to%C3%A1n+%C4%91%C6%A1n+h%C3%A0ng+vnpay&
vnp_PayDate=20231226210337&
vnp_ResponseCode=00&
vnp_TmnCode=06IZ70U6&
vnp_TransactionNo=14261471&
vnp_TransactionStatus=00&
vnp_TxnRef=1703599356&
vnp_SecureHash=d4c50957168e49c41dc60958a39a36cebf350e0a24ea76d34c86fc91122258253e799ad0ad684ddd29b7c4d2a07b561dd3055244af7c3ccfb4161f7c62544596 -->
