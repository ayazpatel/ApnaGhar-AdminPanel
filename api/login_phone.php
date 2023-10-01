<?php
if (isset($_GET['n']) && isset($_GET['o'])) {
    $phoneNumber = $_GET['n'];
    $otp = $_GET['o'];

    $db_servername = "localhost";
    $db_username = "ayaz";
    $db_password = "ayaz29292";
    $db_name = "test_ayafitech_com";

    $conn = new mysqli($db_servername, $db_username, $db_password, $db_name);

    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    } else {
        $sql = "SELECT is_verified FROM users WHERE phone_no = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $phoneNumber);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($is_verified);
            $stmt->fetch();

            if ($is_verified == 1) {
            // echo json_encode(array("message" => "Email is verified."));
                $checkPhoneNumberSql = "SELECT * FROM users WHERE phone_no = '$phoneNumber'";
                $result = $conn->query($checkPhoneNumberSql);

                if ($result->num_rows > 0) {
                    $route = 0;

                    if ($route == 0) {
                        $response = OTP_SMS_Route($phoneNumber, $otp);
                    } elseif ($route == 1) {
                        $response = QUICK_SMS_Route($phoneNumber, $otp);
                    } else {
                        $response = "Invalid route value.";
                    }
                } else {
                    $response = "Phone number does not exist in the database.";
                }
            } else {
                echo json_encode(array("message" => "Email is not verified."));
            }
        } else {
            echo json_encode(array("message" => "Email not found in the database."));
        }
            $stmt->close();
           // $conn->close();
    }
    $conn->close();
} else {
    $response = "Invalid parameters.";
}

if (isset($response)) {
    $responseObj = json_decode($response);

    if ($responseObj && isset($responseObj->return) && $responseObj->return === true) {
        echo json_encode(array("message" => "SMS sent successfully."));
    } else {
        echo json_encode(array("message" => "Failed to send SMS."));
    }
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
