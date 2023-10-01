<?php
$botToken = '6656255922:AAHGB1i23gG-F2n7VhXNZS5TebcYruLz_44';

$apiUrl = "https://api.telegram.org/bot$botToken";

function sendMessage($chatId, $message) {
    global $apiUrl;
    $data = [
        'chat_id' => $chatId,
        'text' => $message,
    ];
    file_get_contents("$apiUrl/sendMessage?" . http_build_query($data));
}

function sendVerificationEmail($email, $verificationToken) {
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = 'smtp.mailgun.org';
    $mail->SMTPAuth = true;
    $mail->Username = 'verification@mg.gharadmin.com';
    $mail->Password = 'b356983e9cde8d6698990370b757a101-262b213e-df19c577';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->setFrom('verification@mg.gharadmin.com', 'AYAFI TECH');
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = 'Email Verification - OTP';
    $mail->Body = 'Click the following link to verify your email: 
                        https://et.ayafitech.com/verify_email.php?email=' . urlencode($email) . '&token=' . $verificationToken;

    if (!$mail->send()) {
        http_response_code(500);
        sendMessage($chatId, "Failed to send confirmation email.");
    } else {
        sendMessage($chatId, "Verification email sent successfully!");
    }
}

$update = json_decode(file_get_contents("php://input"), TRUE);

$servername = "localhost";
$username = "ayaz";
$db_password = "ayaz29292";
$dbname = "test_ayafitech_com";

$conn = new mysqli($servername, $username, $db_password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($update["message"]["chat"]["id"])) {
    $chatId = $update["message"]["chat"]["id"];
    $messageText = isset($update["message"]["text"]) ? $update["message"]["text"] : "";

    if (strpos($messageText, "/adduser") === 0) {
        $userDetails = explode(",", substr($messageText, strlen("/adduser ")));
        if (count($userDetails) == 7) {
            list($first_name, $last_name, $email_id, $password, $phone_no, $user_state, $user_city) = $userDetails;

            $phone_number = $phone_no;
            $first_name = $first_name;
            $last_name = $last_name;
            $prefered_state = $user_state;
            $prefered_city = $user_city;
            $wallet = 0;
            $email = $email_id;
            $password = $password;

            $checkDuplicateSql = "SELECT * FROM users WHERE email_id = '$email' OR phone_no = '$phone_number'";
            $result = $conn->query($checkDuplicateSql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $is_verified = $row['is_verified'];

                if ($is_verified == 1) {
                    $conn->close();
                    sendMessage($chatId, "Email or phone number is already registered and verified.");
                } else {
                    if ($email == $row['email_id']) {
                        $verificationToken = $row['verification_token'];
                        sendVerificationEmail($email, $verificationToken);
                        sendMessage($chatId, "Verification email sent to $email");
                        $conn->close();
                    } else {
                        $conn->close();
                        sendMessage($chatId, "Phone number already exists in the database.");
                    }
                }
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $verificationToken = md5(uniqid(rand(), true));

                $insertSql = "INSERT INTO users (phone_no, first_name, last_name, prefered_state, prefered_city, wallet, email_id, password, verification_token, is_verified, created_at) 
                  VALUES ('$phone_number', '$first_name', '$last_name', '$prefered_state', '$prefered_city', '$wallet', '$email', '$hashed_password', '$verificationToken', 0, NOW())";
                  sendMessage($chatId, "User registered successfully!");
                if ($conn->query($insertSql) === TRUE) {
                    $conn->close();
                    sendVerificationEmail($email, $verificationToken);
                    sendMessage($chatId, "User registered successfully!");
                } else {
                    $conn->close();
                    http_response_code(500);
                    sendMessage($chatId, "Error inserting record into the database.");
                }
            }
            sendMessage($chatId, "User details received. Registration process initiated.");
        } else {
            sendMessage($chatId, "Invalid input format. Please provide user details in the specified format.");
        }
    } elseif (strpos($messageText, "/deleteuser") === 0) {
        $userInput = substr($messageText, strlen("/deleteuser "));

        if (empty($userInput)) {
            sendMessage($chatId, "Please provide an email or phone number for the user you want to delete.");
        } else {
            $searchSql = "SELECT * FROM users WHERE email_id LIKE '%$userInput%' OR phone_no LIKE '%$userInput%'";
            $searchResult = $conn->query($searchSql);

            if ($searchResult->num_rows > 0) {
                while ($row = $searchResult->fetch_assoc()) {
                    $userId = $row['user_id'];
                    $email = $row['email_id'];
                    $phone = $row['phone_no'];

                    $deleteSql = "DELETE FROM users WHERE user_id = '$userId'";
                    if ($conn->query($deleteSql) === TRUE) {
                        sendMessage($chatId, "User deleted: Email: $email, Phone: $phone");
                    } else {
                        sendMessage($chatId, "Error deleting the user: Email: $email, Phone: $phone");
                    }
                }
            } else {
                sendMessage($chatId, "No users found with the provided email or phone number.");
            }
        } 
    } elseif (strpos($messageText, "/addwallet") === 0) {
        $userInput = explode(",", substr($messageText, strlen("/addwallet ")));
        if (count($userInput) == 2) {
            list($phoneNumber, $amountToAdd) = $userInput;

            $getUserSql = "SELECT * FROM users WHERE phone_no = '$phoneNumber'";
            $userResult = $conn->query($getUserSql);

            if ($userResult->num_rows > 0) {
                $user = $userResult->fetch_assoc();
                $userId = $user['user_id'];
                $currentBalance = $user['wallet'];

                $newBalance = $currentBalance + (int)$amountToAdd;

                $updateBalanceSql = "UPDATE users SET wallet = '$newBalance' WHERE user_id = '$userId'";
                if ($conn->query($updateBalanceSql) === TRUE) {
                    sendMessage($chatId, "Wallet balance updated successfully. New balance: $newBalance");
                } else {
                    sendMessage($chatId, "Error updating wallet balance.");
                }
            } else {
                sendMessage($chatId, "User not found with the provided phone number.");
            }
        } else {
            sendMessage($chatId, "Invalid input format. Please provide phone number and amount (eg. xxxx845378,100).");
        }
    } elseif (strpos($messageText, "/verifyuser") === 0) {
        $userInput = substr($messageText, strlen("/verifyuser "));

        if (empty($userInput)) {
            sendMessage($chatId, "Please provide an email or phone number for the user you want to verify.");
        } else {
            if (filter_var($userInput, FILTER_VALIDATE_EMAIL)) {
                $getUserSql = "SELECT * FROM users WHERE email_id = '$userInput'";
            } else {
                $getUserSql = "SELECT * FROM users WHERE phone_no = '$userInput'";
            }

            $userResult = $conn->query($getUserSql);

            if ($userResult->num_rows > 0) {
                $user = $userResult->fetch_assoc();
                $userId = $user['user_id'];
                $email = $user['email_id'];
                $phone = $user['phone_no'];

                $updateBalanceSql = "UPDATE users SET is_verified = 1 WHERE user_id = '$userId'";
                if ($conn->query($updateBalanceSql) === TRUE) {
                    sendMessage($chatId, "Email/Phone $userInput is now verified");
                } else {
                    sendMessage($chatId, "Error Verifying Email/Phone.");
                }
            } else {
                sendMessage($chatId, "User not found with the provided Email/Phone.");
            }
        }
    } else {
        if ($messageText == "/start") {
            $message = "Welcome to the Telegram Bot! Please select a command:\n\n"
                     . "USER MENU\n\n"
                     . "/start_add_user - Creates a user\n"
                     . "/start_delete_user - Deletes a user\n"
                     . "/start_add_wallet - Adds Credits in Wallet\n"
                     . "/start_verify_user - Verifies User Email\n";
            sendMessage($chatId, $message);
        }  elseif ($messageText == "/start_add_user") {
            sendMessage($chatId, "/adduser - Syntax Below");
            sendMessage($chatId, "Please use the FIRSTNAME,LASTNAME,EMAIL,PASSWORD,PHONE,STATE,CITY in given format to add user\n
            (eg. /adduser John,Doe,johndoe@example.com,securepassword,1234567890,California,San Francisco)");
            
        } elseif ($messageText == "/start_add_wallet") {
            sendMessage($chatId, "/addwallet - Syntax Below");
            sendMessage($chatId, "Please add user phone number and amount to add \n(eg. /addwallet xxxx845378,100)");
            
        }  elseif ($messageText == "/start_delete_user") {
            sendMessage($chatId, "/deleteuser - Syntax Below");
            sendMessage($chatId, "Please add user phone number or email to delete \n(eg. /deleteuser xxxx845378 or eg. /deleteuser user@example.com)");
            
        } elseif ($messageText == "/start_verify_user") {
            sendMessage($chatId, "/verifyuser - Syntax Below");
            sendMessage($chatId, "Please add user phone number or email to verify \n(eg. /verifyuser xxxx845378 or eg. /verifyuser user@example.com)");
            
        } else {
            sendMessage($chatId, "Invalid Command. Please use one of the provided commands.");
        }
    }
}
?>
