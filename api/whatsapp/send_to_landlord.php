<?php
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['phone']) && isset($_GET['content']) && isset($_GET['property'])) {
    $phone = $_GET['phone'];
    $content = $_GET['content'];
    $property = $_GET['property'];
    
    $postData = array(
        'appkey' => '40a3d9ad-efa2-4482-b475-e3186a10fd3a',
        'authkey' => 'WfOPYetF5p3hd5SoFXKOm1H2T9ebtRNwqzP67C0fhpOe35bSEJ',
        'to' => '91'.$phone,
        'message' => $content,
        'sandbox' => 'false',
        'file' => $property, 
    );

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://wasender.ayafitech.com/api/create-message',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $postData, 
    ));

    $response = curl_exec($curl);

    curl_close($curl);

    echo $response;
} else {
    echo "Invalid request or missing 'name' parameter.";
}
?>