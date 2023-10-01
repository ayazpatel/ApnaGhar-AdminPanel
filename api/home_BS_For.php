<?php
// Define database connection parameters
$servername = "localhost";
$username = "ayaz";
$password = "ayaz29292";
$database = "test_ayafitech_com";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get parameters from the API request
$BS_For = $_GET['BS_For'];

// Sanitize the input (for security, consider using prepared statements instead)
$BS_For = mysqli_real_escape_string($conn, $BS_For);

// Prepare the SQL query
$sql = "SELECT * FROM `buy_sell` WHERE `BS_For` = '$BS_For'";

// Execute the query
$result = $conn->query($sql);

// Initialize an array to store the results
$data = [];

// Fetch data from the result set
while ($row = $result->fetch_assoc()) {
    $row['Image1'] = 'https://et.ayafitech.com/api/' . $row['Image1'];
    $row['Image2'] = 'https://et.ayafitech.com/api/' . $row['Image2'];
    $data[] = $row;
}

// Close the database connection
$conn->close();

// Convert the result to JSON and send it as a response
header('Content-Type: application/json');
echo json_encode($data);
?>
