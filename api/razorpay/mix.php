<?php
session_start();

require 'config.php';
require 'vendor/autoload.php';

use Razorpay\Api\Api;

if (!empty($_GET['email']) && !empty($_GET['amount'])) {
    $email = $_GET['email'];
    $amount = $_GET['amount'];

    // Fetch user data from the database
    $conn = new mysqli("localhost", "ayaz", "ayaz29292", "test_ayafitech_com");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT first_name, last_name, phone_no FROM users WHERE email_id = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['first_name'] . ' ' . $row['last_name'];
        $phone = $row['phone_no'];
    } else {
        // Handle the case where the user with the given email is not found
        echo "User not found.";
        exit;
    }

    if (isset($_POST['razorpay_payment_id'])) {
        // This block handles payment success notification

        $razorpay_order_id = $_POST['razorpay_order_id'];
        $razorpay_payment_id = $_POST['razorpay_payment_id'];
        $razorpay_signature = $_POST['razorpay_signature'];

        $generated_signature = hash_hmac('sha256', $razorpay_order_id . "|" . $razorpay_payment_id, API_SECRET);

        if ($generated_signature == $razorpay_signature) {
            // Payment successful

            // Update wallet balance in the database (you can modify this part)
            $currentBalance = 0;
            $New_Full_Name = "";
            if (!empty($email)) {
                $sql = "SELECT * FROM users WHERE email_id = '$email'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $currentBalance = (float) $row['wallet'];
                    $currentPhone = $row['phone_no'];
                    $New_Full_Name = $row['first_name'] . " " . $row['last_name'];
                }
            }

            // Calculate new wallet balance and update it in the database
            $newBalance = $currentBalance + $amount;

            // Update the wallet balance in the database
            $updateSql = "UPDATE users SET wallet = '$newBalance' WHERE email_id = '$email'";
            $conn->query($updateSql);

            // Record the payment in the payments table
            $insertSql = "INSERT INTO payments (order_id, email, name, phone, amount, payment_status, payment_response, payment_link)
                VALUES ('$razorpay_order_id', '$email', '$New_Full_Name', '$currentPhone', '$amount', 'success', '$razorpay_signature', '" . $_SERVER['REQUEST_URI'] . "')";

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

            // Record the failed payment in the payments table
            $insertSql = "INSERT INTO payments (order_id, email, name, phone, amount, payment_status, payment_response, payment_link)
                VALUES ('$razorpay_order_id', '$email', '$name', '$phone', '$amount', 'failure', '$razorpay_signature', '" . $_SERVER['REQUEST_URI'] . "')";

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
        // This block handles wallet top-up requests

        $api = new Api(API_KEY, API_SECRET);

        $res = $api->order->create(
            array(
                'receipt' => '123',
                'amount' => $amount * 100,
                'currency' => 'INR',
                'notes' => array('key1' => 'value1', 'key2' => 'value2'),
            )
        );

        if (!empty($res['id'])) {
            $_SESSION['order_id'] = $res['id'];
        } else {
            // Handle the case where the order creation failed
            echo "Order creation failed. Please try again.";
            exit;
        }
    }
} else {
    // Handle the case where the required parameters are not provided in the URL
    echo "Missing required parameters in the URL.";
    exit;
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo COMPANY_NAME; ?> Wallet Topup</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        h4 {
            text-align: center;
            color: #333;
        }

        .bill-details {
            background-color: #f3f3f3;
            padding: 10px;
            border-radius: 5px;
        }

        .amount {
            font-size: 24px;
            color: #333;
            font-weight: bold;
        }

        .razorpay-payment-button {
            display: block;
            width: 100%;
            padding: 14px 0;
            background-color: #4CAF50;
            color: #fff;
            font-size: 16px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            text-transform: uppercase;
        }
    </style>
</head>

<body>
    <div class="container">
        <?php if (!empty($_SESSION['order_id'])) : ?>
            <h1><?php echo COMPANY_NAME; ?> Wallet Topup</h1>
            <div class="bill-details">
                <h4>Bill Details</h4>
                <p>Amount: <span class="amount">₹<?php echo number_format($amount, 2); ?></span></p>
                <p>Name: <?php echo $name; ?></p>
                <p>Email: <?php echo $email; ?></p>
                <p>Phone: <?php echo $phone; ?></p>
            </div>
            <form action="https://api.razorpay.com/v1/checkout/embedded" method="POST">
                <input type="hidden" name="key_id" value="<?php echo API_KEY; ?>">
                <input type="hidden" name="order_id" value="<?php echo $_SESSION['order_id']; ?>">
                <input type="hidden" name="name" value="<?php echo $name; ?>">
                <input type="hidden" name="description" value="<?php echo COMPANY_NAME; ?> Wallet Topup">
                <input type="hidden" name="image" value="<?php echo COMPANY_LOGO_URL; ?>">
                <input type="hidden" name="prefill[name]" value="<?php echo $name; ?>">
                <input type="hidden" name="prefill[email]" value="<?php echo $email; ?>">
                <input type="hidden" name="prefill[contact]" value="<?php echo $phone; ?>">
                <input type="hidden" name="notes[shipping address]" value="Bommanahalli">
                <input type="hidden" name="callback_url" value="<?php echo BASE_URL . 'razorpay.php?email=' . $email . '&amount=' . $amount; ?>">
                <button class="razorpay-payment-button" type="submit">Pay Now</button>
            </form>
        <?php else : ?>
            <p>Order creation failed. Please try again.</p>
        <?php endif; ?>
    </div>
</body>

</html>
