<?php
require 'smtp/PHPMailerAutoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (
        isset($_GET['ph']) &&
        isset($_GET['fn']) &&
        isset($_GET['ln']) &&
        isset($_GET['ps']) &&
        isset($_GET['pc']) &&
        isset($_GET['w']) &&
        isset($_GET['e']) &&
        isset($_GET['p'])
    ) {
        $phone_number = $_GET['ph'];
        $first_name = $_GET['fn'];
        $last_name = $_GET['ln'];
        $prefered_state = $_GET['ps'];
        $prefered_city = $_GET['pc'];
        $wallet = $_GET['w'];
        $email = $_GET['e'];
        $password = $_GET['p'];

        $servername = "localhost";
        $username = "ayaz";
        $db_password = "ayaz29292";
        $dbname = "test_ayafitech_com";

        $conn = new mysqli($servername, $username, $db_password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        $checkDuplicateSql = "SELECT * FROM users WHERE email_id = '$email' OR phone_no = '$phone_number'";
        $result = $conn->query($checkDuplicateSql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $is_verified = $row['is_verified'];

            if ($is_verified == 1) {
                $conn->close();
                echo json_encode(array("message" => "Email or phone number is already registered and verified."));
            } else {
                if ($email == $row['email_id']) {
                    $verificationToken = $row['verification_token'];
                    sendVerificationEmail($email, $verificationToken);
                    $conn->close();
                    //echo json_encode(array("message" => "Verification email sent successfully!"));
                } else {
                    $conn->close();
                    echo json_encode(array("message" => "Phone number already exists in the database."));
                }
            }
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $verificationToken = md5(uniqid(rand(), true));

            $insertSql = "INSERT INTO users (phone_no, first_name, last_name, prefered_state, prefered_city, wallet, email_id, password, verification_token, is_verified, created_at) 
              VALUES ('$phone_number', '$first_name', '$last_name', '$prefered_state', '$prefered_city', '$wallet', '$email', '$hashed_password', '$verificationToken', 0, NOW())";

            if ($conn->query($insertSql) === TRUE) {
                $conn->close();
                sendVerificationEmail($email, $verificationToken);
                
            } else {
                $conn->close();
                http_response_code(500);
                echo json_encode(array("message" => "Error inserting record into the database."));
            }
        }
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "Required parameters are missing."));
    }
} else {
    http_response_code(405);
    echo json_encode(array("message" => "Method not allowed."));
}

function sendVerificationEmail($email, $verificationToken) {
     $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'johnpaul3615786@gmail.com';
    $mail->Password = 'osqjhgpavohsfbje';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->setFrom('johnpaul3615786@gmail.com', 'AYAFI TECH');
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = 'Email Verification - OTP';
    $mail->Body = 'Click the following link to verify your email: 
                        https://et.ayafitech.com/api/verify_email.php?email=' . urlencode($email) . '&token=' . $verificationToken;

    if (!$mail->send()) {
        http_response_code(500);
        echo json_encode(array("message" => "Failed to send confirmation email."));
    } else {
        echo json_encode(array("message" => "Confirmation email sent successfully!"));
    }
}
?>
