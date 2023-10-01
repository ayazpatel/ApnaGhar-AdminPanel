<?php
if (isset($_GET['email']) && isset($_GET['token'])) {
    $email = $_GET['email'];
    $verificationToken = $_GET['token'];

    $servername = "localhost";
    $username = "ayaz";
    $password = "ayaz29292";
    $dbname = "test_ayafitech_com";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM users WHERE email_id = '" . $email . "' AND verification_token = '" . $verificationToken . "' AND is_verified = 0";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $updateSql = "UPDATE users SET is_verified = 1 WHERE email_id = '" . $email . "' AND verification_token = '" . $verificationToken . "'";
        if ($conn->query($updateSql) === TRUE) {
            $conn->close();

            echo 'Email verified successfully!';
        } else {
            echo 'Error updating record: ' . $conn->error;
        }
    } else {
        echo 'Invalid verification link or email already verified.';
    }
} else {
    echo 'Both email and token parameters are required.';
}
