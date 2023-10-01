<?php
if (isset($_GET['n']) && isset($_GET['o'])) {
    $phoneNumber = $_GET['n'];
    $otp = $_GET['o'];
    
    $route = 0;

    if ($route == 0) {
        $response = OTP_SMS_Route($phoneNumber, $otp);
    } elseif ($route == 1) {
        $response = QUICK_SMS_Route($phoneNumber, $otp);
    } else {
        echo "Invalid route value.";
        exit;
    }

    
    $responseObj = json_decode($response);

    if ($responseObj && isset($responseObj->return) && $responseObj->return === true) {
        echo json_encode(array("message" => "SMS sent successfully."));
    } else {
        echo json_encode(array("message" => "Failed to send SMS."));
    }
} else {
    echo json_encode(array("message" => "Invalid parameters."));
}

function OTP_SMS_Route($phoneNumber, $otp) {
    $authorization = "ZLGJsme3Dzh0wpcayVPuQoAqrtfBNUOKMRvT9Hi1nIXbCWY7xln208sgjiHyEwxK3P4AzlReTNJrqVcI";
    $variables_values = $otp;
    $numbers = $phoneNumber;
    $flash = 0;

    $url = "https://www.fast2sms.com/dev/bulkV2?authorization=$authorization&route=otp&variables_values=$variables_values&flash=$flash&numbers=$numbers";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}

function QUICK_SMS_Route($phoneNumber, $otp) {
    $authorization = "ZLGJsme3Dzh0wpcayVPuQoAqrtfBNUOKMRvT9Hi1nIXbCWY7xln208sgjiHyEwxK3P4AzlReTNJrqVcI";
    $message = "Your%20OTP%20is%0A$otp%0A%0A-by%20APNA%20GHAR";
    $numbers = $phoneNumber;
    $flash = 0;
    
    $url = "https://www.fast2sms.com/dev/bulkV2?authorization=$authorization&route=q&message=$message&flash=$flash&numbers=$numbers";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}
?>
