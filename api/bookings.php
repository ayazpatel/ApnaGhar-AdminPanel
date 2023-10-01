<?php
$host = "localhost";
$username = "ayaz";
$password = "ayaz29292";
$database = "test_ayafitech_com";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['name']) && isset($_GET['phone']) && isset($_GET['email']) && isset($_GET['amount']) && isset($_GET['property_id'])) {
        // Extract data from the URL
        $name = $_GET['name'];
        $phone = $_GET['phone'];
        $email = $_GET['email'];
        $amount = $_GET['amount'];
        $property_id = $_GET['property_id'];

        // Construct and execute the SQL query
        $sql = "INSERT INTO `bookings` (`name`, `email`, `phone`, `property_id`, `amount`, `booked_at`) VALUES (?, ?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $name, $email, $phone, $property_id, $amount);

        if ($stmt->execute()) {
            echo "Booking added successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Missing parameters in the URL.";
    }
} else {
    echo "Only GET requests are allowed for this API.";
}

$conn->close();
?>
