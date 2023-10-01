<?php
require 'smtp/PHPMailerAutoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['e']) && isset($_GET['p'])) {
        $email = $_GET['e'];
        $password = $_GET['p'];

        if (!empty($email) && !empty($password)) {

            $servername = "localhost";
            $username = "ayaz";
            $db_password = "ayaz29292";
            $dbname = "test_ayafitech_com";

            $conn = new mysqli($servername, $username, $db_password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }  else {
                $sql = "SELECT is_verified FROM users WHERE email_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $stmt->store_result();

                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($is_verified);
                    $stmt->fetch();

                    if ($is_verified == 1) {
                        $checkEmailSql = "SELECT * FROM users WHERE email_id = '$email'";
                        $result = $conn->query($checkEmailSql);

                        if ($result->num_rows > 0) {
                            $user = $result->fetch_assoc();
                            $hashed_password = $user['password'];

                            if (password_verify($password, $hashed_password)) {
                                // Move the connection closure here
                                $conn->close();
                                echo json_encode(array("message" => "Login successful!"));
                            } else {
                                $conn->close();
                                http_response_code(401);
                                echo json_encode(array("message" => "Invalid password."));
                            }
                        } else {
                            $conn->close();
                            http_response_code(401);
                            echo json_encode(array("message" => "Invalid email."));
                        }
                    } else {
                        $conn->close(); // Close the connection if email is not verified
                        echo json_encode(array("message" => "Email is not verified."));
                    }
                } else {
                    $conn->close(); // Close the connection if email is not found
                    echo json_encode(array("message" => "Email not found in the database."));
                }
                $stmt->close();
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Email and password parameters are required."));
        }
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "Email and password parameters are required."));
    }
} else {
    http_response_code(405);
    echo json_encode(array("message" => "Method not allowed."));
}


?>