<?php
// Check if the ID parameter is provided in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Establish a database connection (replace with your credentials)
    $servername = "localhost";
    $username = "ayaz";
    $password = "ayaz29292";
    $dbname = "test_ayafitech_com";

    // Create a connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL query to update the 'is_Sold' field
    $sql = "UPDATE `buy_sell` SET `is_Sold` = 1 WHERE `id` = $id";

    if ($conn->query($sql) === TRUE) {
        // If the update is successful, return a success JSON response
        $response = array("status" => "success", "message" => "Record marked as sold successfully.");
        echo json_encode($response);
    } else {
        // If the update fails, return an error JSON response
        $response = array("status" => "error", "message" => "Error updating record: " . $conn->error);
        echo json_encode($response);
    }

    // Close the database connection
    $conn->close();
} else {
    // If the 'id' parameter is not provided in the URL, return an error JSON response
    $response = array("status" => "error", "message" => "ID parameter is missing.");
    echo json_encode($response);
}
?>
