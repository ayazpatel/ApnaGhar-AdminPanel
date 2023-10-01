<?php
// Database configuration
$host = "localhost"; // Change to your database host
$username = "ayaz"; // Change to your database username
$password = "ayaz29292"; // Change to your database password
$database = "test_ayafitech_com"; // Change to your database name

// Get email_id from GET parameter
if (isset($_GET['id'])) {
    $emailId = $_GET['id'];

    // Create a database connection
    $conn = new mysqli($host, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the SQL query
    $sql = "SELECT * FROM users WHERE email_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $emailId);
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if any rows were returned
    if ($result->num_rows > 0) {
        // Fetch the data and store it in an array
        $data = $result->fetch_assoc();

        // Convert the data to JSON and send the response
        header('Content-Type: application/json');
        echo json_encode($data);
    } else {
        // No data found for the given email_id
        http_response_code(404);
        echo json_encode(array("message" => "No user found with the specified email_id."));
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
} else {
    // Email_id parameter is missing
    http_response_code(400);
    echo json_encode(array("message" => "Missing email_id parameter."));
}
?>
