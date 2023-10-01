<?php
// Database connection parameters
$servername = "localhost";
$username = "ayaz";
$password = "ayaz29292";
$database = "test_ayafitech_com";

// Get the product ID from the request
$id = $_GET['id'];

// Create a connection to the MySQL database
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch data by ID
$sql = "SELECT * FROM `buy_sell` WHERE `id` = '$id'";

$result = $conn->query($sql);

// Check if any rows were returned
if ($result->num_rows > 0) {
    $data = array();

    // Fetch the row and modify the Created_At field
    $row = $result->fetch_assoc();
    $row['Created_At'] = date("Y-m-d", strtotime($row['Created_At']));

    // Modify the Image1 and Image2 fields by adding the desired text
    $row['Image1'] = 'https://et.ayafitech.com/api/' . $row['Image1'];
    $row['Image2'] = 'https://et.ayafitech.com/api/' . $row['Image2'];

    $data[] = $row;

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
