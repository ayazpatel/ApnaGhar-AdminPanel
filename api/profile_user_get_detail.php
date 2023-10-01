<?php
header("Content-Type: application/json");

// Include your database connection configuration here
$servername = "localhost";
$username = "ayaz";
$password = "ayaz29292";
$dbname = "test_ayafitech_com";

$email = $_GET['email'];

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare and execute the SQL query to fetch user details
    $stmt = $conn->prepare("SELECT user_id, first_name, last_name, phone_no, wallet FROM users WHERE email_id = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $userDetails = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($userDetails) {
        // Create a response array
        $response = [
            'data' => $userDetails,
        ];

        // Return the response as JSON
        echo json_encode($response);
    } else {
        // Handle the case where the user with the provided email is not found
        echo json_encode(['error' => 'User not found']);
    }
} catch (PDOException $e) {
    // Handle database connection or query errors
    echo json_encode(['error' => 'Database error']);
}
?>
