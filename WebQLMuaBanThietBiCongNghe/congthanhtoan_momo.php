<?php
function execPostRequest($url, $data)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data))
    );
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    //execute post
    $result = curl_exec($ch);
    //close connection
    curl_close($ch);
    return $result;
}


$endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";


$partnerCode = 'MOMOBKUN20180529';
$accessKey = 'klm05TvNBzhg7h7j';
$secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
$orderInfo = "Thanh toán qua MoMo qua mã QR";
$amount = $_POST['total_congthanhtoan'];
$orderId = time() ."";
$redirectUrl = "http://localhost:3000/donhangthanhtoanonline.php";
$ipnUrl = "https://webhook.site/b3088a6a-2d17-4f8d-a383-71389a6c600b";
$extraData = "";


    $partnerCode = $partnerCode;
    $accessKey = $accessKey;
    $secretKey = $secretKey;
    $orderId = time(); // Mã đơn hàng
    $orderInfo = $orderInfo;
    $amount = $amount;
    // $ipnUrl = $_POST["ipnUrl"];
    $redirectUrl = $redirectUrl;
    // $extraData = $extraData;

    $requestId = time() . "";
    if (isset($_POST['captureWallet'])) {
        $requestType = "captureWallet";
    }else if (isset($_POST['payWithATM'])){
        $requestType = "payWithATM";
    }
    // $extraData = ($_POST["extraData"] ? $_POST["extraData"] : "");
    //before sign HMAC SHA256 signature
    $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
    $signature = hash_hmac("sha256", $rawHash, $secretKey);
    $data = array('partnerCode' => $partnerCode,
        'partnerName' => "Test",
        "storeId" => "MomoTestStore",
        'requestId' => $requestId,
        'amount' => $amount,
        'orderId' => $orderId,
        'orderInfo' => $orderInfo,
        'redirectUrl' => $redirectUrl,
        'ipnUrl' => $ipnUrl,
        'lang' => 'en',
        'extraData' => $extraData,   
        'requestType' => $requestType,
        'signature' => $signature);
    $result = execPostRequest($endpoint, json_encode($data));
    $jsonResult = json_decode($result, true);  // decode json

    //Just a example, please check more in there

    header('Location: ' . $jsonResult['payUrl']);

?>

<!-- 
    http://localhost:3000/donhangthanhtoanonline.php?partnerCode=MOMOBKUN20180529
    &orderId=1704882193
    &requestId=1704882193
    &amount=3300
    &orderInfo=Thanh+to%C3%A1n+qua+MoMo+qua+m%C3%A3+QR
    &orderType=momo_wallet
    &transId=3115903231
    &resultCode=0
    &message=Th%C3%A0nh+c
    %C3%B4ng.&payType=qr
    &responseTime=1704828229445&extraData=
    &signature=8cffe6939ce854f089556a7e00fef8b8475312a597a25a220fa4dfaead276268
    &paymentOption=momo
 -->