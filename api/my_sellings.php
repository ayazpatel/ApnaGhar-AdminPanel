<?php
// Database connection parameters
$servername = "localhost";
$username = "ayaz";
$password = "ayaz29292";
$database = "test_ayafitech_com";

// Get parameters from the URL
$email = $_GET['email'];

// Create a connection to the MySQL database
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch data using parameters
// $sql = "SELECT * FROM `buy_sell` WHERE `State` = '$state' AND `City` = '$city' ORDER BY `is_Featured` DESC, `id` DESC";
$sql = "SELECT * FROM `buy_sell` WHERE `email_id` = '$email' AND `is_Sold` = 0";

$result = $conn->query($sql);

// Check if any rows were returned
if ($result->num_rows > 0) {
    $data = array();

    // Fetch rows and add them to the data array
    while ($row = $result->fetch_assoc()) {
        // Modify the Image1 field by adding the desired text
        $row['Image1'] = 'https://et.ayafitech.com/api/' . $row['Image1'];
        $row['Image2'] = 'https://et.ayafitech.com/api/' . $row['Image2'];
        $data[] = $row;
    }

    // Return data as JSON
    header('Content-Type: application/json');
    echo json_encode(array('data' => $data));
} else {
    // No data found
    echo "No data found.";
}

// Close the database connection
$conn->close();
?>
