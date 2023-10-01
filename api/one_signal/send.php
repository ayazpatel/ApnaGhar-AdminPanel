<?php
// Step 1: Parse the GET Parameter
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Step 2: Connect to the Database
$host = 'localhost';
$username = 'ayaz';
$password = 'ayaz29292';
$database = 'test_ayafitech_com';

$mysqli = new mysqli($host, $username, $password, $database);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Step 3: Retrieve Data from the Database
$query = "SELECT `segment`, `campaign`, `content` FROM `notification` WHERE `id` = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($segment, $campaign, $content);
$stmt->fetch();
$stmt->close();

// Step 4: Retrieve OneSignal App ID and API Key from the `config` table
$query = "SELECT `onesignal_app_id`, `onesignal_api_key` FROM `config` WHERE `id` = 1"; // Assuming the config ID is 1
$result = $mysqli->query($query);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $onesignalAppId = $row['onesignal_app_id'];
    $onesignalApiKey = $row['onesignal_api_key'];
} else {
    echo "No OneSignal configuration data found.";
    exit();
}

// Step 5: Fill Data into OneSignal API Request

$curl = curl_init();

// $appId = '154f9590-dafd-4bd5-858d-23ec30506fad';
$appId = $onesignalAppId;
$apiKey = 'YzU1OTJkYjQtNjU1Ny00MDE3LWJmZmQtMGI4MjJhODJjZDhk';
// $apiKey = $onesignalApiKey;

curl_setopt_array($curl, [
  CURLOPT_URL => "https://onesignal.com/api/v1/notifications",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => json_encode([
    'app_id' => $appId,
    'included_segments' => [
        // 'Subscribed Users'
        // 'Active Users'
        // 'Total Subscriptions'
        $segment
    ],
    'contents' => [
        'en' => $content
    ],
    'name' => $campaign
  ]),
  CURLOPT_HTTPHEADER => [
    "Authorization: Basic $apiKey",
    "accept: application/json",
    "content-type: application/json"
  ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}
$mysqli->close();
?>
