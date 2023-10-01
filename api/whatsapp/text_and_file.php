<?php
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://ayafihost.cloud/api/create-message',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array(
  'appkey' => '0585c173-a091-4e12-8023-7efd80655566',
  'authkey' => 'WfOPYetF5p3hd5SoFXKOm1H2T9ebtRNwqzP67C0fhpOe35bSEJ',
  'to' => '919328299200',
  'message' => 'Example message',
  'file' => 'https://www.africau.edu/images/default/sample.pdf',
  'sandbox' => 'false'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
?>