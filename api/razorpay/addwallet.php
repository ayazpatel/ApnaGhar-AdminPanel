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
            margin-bottom: 20px;
        }

        .bill-details p {
            margin: 0;
            padding: 5px 0;
            font-size: 16px;
        }

        .button-container {
            text-align: center;
        }

        .razorpay-button {
            display: inline-block;
            padding: 15px 30px;
            font-size: 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            text-decoration: none;
        }

        .razorpay-button:hover {
            background-color: #0056b3;
        }

        /* Media Query for smaller screens (e.g., Android devices) */
        @media (max-width: 600px) {
            .container {
                max-width: 100%;
                padding: 10px;
            }

            .bill-details {
                padding: 5px;
            }

            .bill-details p {
                font-size: 14px;
            }

            .razorpay-button {
                padding: 10px 20px;
                font-size: 18px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><?php echo COMPANY_NAME; ?></h1>
        <h4>Wallet Topup - Checkout Page</h4>
        <!-- Display the payment information and button -->
        <div class="bill-details">
            <p><strong>Name:</strong> <?php echo $name; ?></p>
            <p><strong>Email:</strong> <?php echo $email; ?></p>
            <p><strong>Phone:</strong> <?php echo $phone; ?></p>
            <p><strong>Amount:</strong> <?php echo $amount; ?> INR</p>
        </div>

        <div class="button-container">
            <form action="<?php echo BASE_URL; ?>success.php" method="POST">
                <script
                    src="https://checkout.razorpay.com/v1/checkout.js"
                    data-key="<?php echo API_KEY; ?>"
                    data-amount="<?php echo $amount; ?>"
                    data-currency="INR"
                    data-order_id="<?php echo $_SESSION['order_id']; ?>"
                    data-buttontext="Pay with Razorpay"
                    data-name="<?php echo COMPANY_NAME; ?>"
                    data-description="Payment for wallet topup balance"
                    data-image="<?php echo COMPANY_LOGO_URL; ?>"
                    data-prefill.name="<?php echo $name; ?>"
                    data-prefill.email="<?php echo $email; ?>"
                    data-prefill.contact="<?php echo $phone; ?>"
                    data-theme.color="#0000FF"
                ></script>
                <input type="hidden" name="hidden_order_id" value="<?php echo $_SESSION['order_id']; ?>">
                <input type="hidden" name="payment_link" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
                
                <input type="hidden" name="amount" value="<?php echo $amount; ?>">
                <input type="hidden" name="email" value="<?php echo $email; ?>">
            </form>
        </div>
    </div>
</body>
</html>
