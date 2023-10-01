<?php
$servername = "localhost";
$username = "ayaz";
$password = "ayaz29292";
$dbname = "test_ayafitech_com";

$email = isset($_GET['e']) ? $_GET['e'] : "";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    $sql = "SELECT is_verified FROM users WHERE email_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($is_verified);
        $stmt->fetch();

        if ($is_verified == 1) {
            echo json_encode(array("message" => "Email is verified."));
        } else {
            echo json_encode(array("message" => "Email is not verified."));
        }
    } else {
        echo json_encode(array("message" => "Email not found in the database."));
    }
    $stmt->close();
    $conn->close();
}
?>
