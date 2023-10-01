<?php
$response = array(); // Initialize a response array

if (!empty($_GET['email']) && !empty($_GET['amount'])) {
    $email = $_GET['email'];
    $amount = $_GET['amount'];
    $newBalance = "";

    $conn = new mysqli("localhost", "ayaz", "ayaz29292", "test_ayafitech_com");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT wallet FROM users WHERE email_id = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $currentBalance = (float) $row['wallet'];
        $newBalance = $currentBalance - $amount;
        // Update the wallet balance in the database
        $updateSql = "UPDATE users SET wallet = '$newBalance' WHERE email_id = '$email'";
        if ($conn->query($updateSql) === TRUE) {
            // Update was successful, set success key to true
            $response['success'] = true;
            $response['message'] = "Wallet updated successfully.";
        } else {
            // Handle the case where the update failed
            $response['success'] = false;
            $response['message'] = "Error updating wallet: " . $conn->error;
        }
    } else {
        // Handle the case where the user with the given email is not found
        $response['success'] = false;
        $response['message'] = "User not found.";
    }
    // Close the database connection
    $conn->close();
} else {
    // Handle the case where the required parameters are not provided in the URL
    $response['success'] = false;
    $response['message'] = "Missing required parameters in the URL.";
}

// Encode the response as JSON and send it
echo json_encode($response);
?>
