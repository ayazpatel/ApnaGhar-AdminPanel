<?php
$servername = "localhost";
$username = "ayaz";
$password = "ayaz29292";
$dbname = "test_ayafitech_com";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['email'])) {
    $email = $_GET['email'];

    // Retrieve the user's state and city based on their email
    $getUserInfoSql = "SELECT prefered_state, prefered_city FROM users WHERE email_id = ?";
    $stmt = $conn->prepare($getUserInfoSql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $userInfoResult = $stmt->get_result();

    // Check if the user exists
    if ($userInfoResult->num_rows === 1) {
        $userInfo = $userInfoResult->fetch_assoc();

        // Get the user's state and city
        $state = $userInfo['prefered_state'];
        $city = $userInfo['prefered_city'];

        // Query the news table based on the user's state and city, ordering by the latest created_at
        $sql = "SELECT title, content, created_at
                FROM news
                WHERE content_region_state = ? AND content_region_city = ?
                ORDER BY created_at DESC";
    
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $state, $city);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = array();

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        $stmt->close();
        $conn->close();

        $response = array("data" => $data);
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        $errorResponse = array("error" => "User with the provided email not found.");
        header('Content-Type: application/json');
        echo json_encode($errorResponse);
    }
} else {
    $errorResponse = array("error" => "Missing email parameter.");
    header('Content-Type: application/json');
    echo json_encode($errorResponse);
}
?>
