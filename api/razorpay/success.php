<?php
session_start();
require 'config.php';

if (!empty($_POST)) {
    $order_id = $_SESSION['order_id'];
    
    $razorpay_order_id = $_POST['razorpay_signature'];
    $razorpay_signature = $_POST['razorpay_signature'];
    $razorpay_payment_id = $_POST['razorpay_payment_id'];

    $generated_signature = hash_hmac('sha256', $order_id . "|" . $razorpay_payment_id, API_SECRET);

    if ($generated_signature == $razorpay_signature) {
        // Payment successful

        // Get amount and email from POST data
        $amount = $_POST['amount'];
        $email = $_POST['email'];

        // Update wallet balance in the database (you can modify this part)
        $conn = new mysqli("localhost", "ayaz", "ayaz29292", "test_ayafitech_com");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Calculate new wallet balance and update it in the database
        $sql = "SELECT * FROM users WHERE email_id = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $currentBalance = (float) $row['wallet'];
            $currentPhone = $row['phone_no'];
            $New_Full_Name = $row['first_name']." ".$row['last_name'];
            $newBalance = $currentBalance + $amount;
            // Update the wallet balance in the database
            $updateSql = "UPDATE users SET wallet = '$newBalance' WHERE email_id = '$email'";
            $conn->query($updateSql);
        }

        // Record the payment in the payments table
        $insertSql = "INSERT INTO payments (order_id, email, name, phone, amount, payment_status, payment_response, payment_link)
            VALUES ('$order_id', '$email', '$New_Full_Name', '$currentPhone', '$amount', 'success', '$razorpay_signature', '" . $_SERVER['REQUEST_URI'] . "')";

        if ($conn->query($insertSql) === true) {
            // Payment recorded successfully
            echo "Payment Successful. Wallet balance updated.";
        } else {
            // Failed to record payment
            echo "Payment Successful. Failed to record payment.";
        }

        // Clear the session data
        unset($_SESSION['order_id']);
    } else {
        // Payment failed

        // Get amount from POST data
        $amount = $_POST['amount'];

        // Record the failed payment in the payments table
        $insertSql = "INSERT INTO payments (order_id, email, name, phone, amount, payment_status, payment_response, payment_link)
            VALUES ('$order_id', '$email', '$name', '$phone', '$amount', 'failure', '$razorpay_signature', '" . $_SERVER['REQUEST_URI'] . "')";

        if ($conn->query($insertSql) === true) {
            // Payment recorded as failed
            echo "Payment Failed.";
        } else {
            // Failed to record payment
            echo "Payment Failed. Failed to record payment.";
        }

        // Clear the session data
        unset($_SESSION['order_id']);
    }
} else {
    echo "Invalid request.";
}

?>
