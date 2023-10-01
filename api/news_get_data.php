<?php
// Database connection details
$host = "localhost"; // Your database host (usually "localhost")
$username = "ayaz"; // Your database username
$password = "ayaz29292"; // Your database password
$database = "test_ayafitech_com"; // Your database name

// Create a connection to the database
$connection = mysqli_connect($host, $username, $password, $database);

// Check the connection
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}
// Query to retrieve approved records sorted by 'created_at' in descending order
$query = "SELECT * FROM news WHERE is_approved = 1 ORDER BY created_at DESC";

// Execute the query
$result = mysqli_query($connection, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($connection));
}

// Initialize an array to store the results
$data = array();

// Fetch rows from the result set
while ($row = mysqli_fetch_assoc($result)) {
    // Create a new item in the 'data' array
    $item = array(
        "id" => $row["id"],
        "content" => $row["content"],
        "writer_id" => $row["writer_id"],
        "writer_name" => $row["writer_name"],
        "writer_email" => $row["writer_email"],
        "writer_phone" => $row["writer_phone"],
        "content_region_state" => $row["content_region_state"],
        "content_region_city" => $row["content_region_city"],
        "created_at" => $row["created_at"]
    );

    // Add the item to the 'data' array
    $data[] = $item;
}

// Create a JSON response
$response = array("data" => $data);

// Send the JSON response
header("Content-Type: application/json");
echo json_encode($response);

// Close the database connection
mysqli_close($connection);
?>
