<?php

$curl = curl_init();

$appId = '154f9590-dafd-4bd5-858d-23ec30506fad';
$apiKey = 'YzU1OTJkYjQtNjU1Ny00MDE3LWJmZmQtMGI4MjJhODJjZDhk';

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
        'Total Subscriptions'
    ],
    'contents' => [
        'en' => 'Admin is a good guy
        eats healthy food'
    ],
    'name' => 'INTERNAL_CAMPAIGN_NAME'
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
?>

<?php

// $curl = curl_init();

// $appId = '154f9590-dafd-4bd5-858d-23ec30506fad'; // Replace with your OneSignal App ID
// $apiKey = 'YzU1OTJkYjQtNjU1Ny00MDE3LWJmZmQtMGI4MjJhODJjZDhk'; // Replace with your OneSignal REST API Key

// curl_setopt_array($curl, [
//   CURLOPT_URL => "https://onesignal.com/api/v1/notifications",
//   CURLOPT_RETURNTRANSFER => true,
//   CURLOPT_ENCODING => "",
//   CURLOPT_MAXREDIRS => 10,
//   CURLOPT_TIMEOUT => 30,
//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//   CURLOPT_CUSTOMREQUEST => "POST",
//   CURLOPT_POSTFIELDS => json_encode([
//     'app_id' => $appId,
//     'included_segments' => ['Subscribed Users'], // Targeting a segment
//     'contents' => [
//         'en' => 'English or Any Language Message',
//         'es' => 'Spanish Message'
//     ],
//     'name' => 'INTERNAL_CAMPAIGN_NAME'
//   ]),
//   CURLOPT_HTTPHEADER => [
//     "Authorization: Basic $apiKey",
//     "accept: application/json",
//     "content-type: application/json"
//   ],
// ]);

// $response = curl_exec($curl);
// $err = curl_error($curl);

// curl_close($curl);

// if ($err) {
//   echo "cURL Error #:" . $err;
// } else {
//   echo $response;
// }
?>
