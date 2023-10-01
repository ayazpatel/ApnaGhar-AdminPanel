<?php
$botToken = '6656255922:AAHGB1i23gG-F2n7VhXNZS5TebcYruLz_44';
$apiUrl = "https://api.telegram.org/bot$botToken";

// Function to send a message to a specific chat ID
function sendMessage($chatId, $message) {
    global $apiUrl;
    $data = [
        'chat_id' => $chatId,
        'text' => $message,
    ];
    file_get_contents("$apiUrl/sendMessage?" . http_build_query($data));
}

// Function to send a photo request to the user
function requestImage($chatId, $message) {
    global $apiUrl;
    $data = [
        'chat_id' => $chatId,
        'text' => $message,
        'reply_markup' => json_encode([
            'keyboard' => [[['text' => 'Send a Photo', 'request_contact' => false, 'request_location' => false]]],
            'resize_keyboard' => true,
            'one_time_keyboard' => true,
        ]),
    ];
    file_get_contents("$apiUrl/sendMessage?" . http_build_query($data));
}

$update = json_decode(file_get_contents("php://input"), TRUE);
$chatId = $update["message"]["chat"]["id"];
$messageText = $update["message"]["text"];

// Start a conversation
if ($messageText == "/start1") {
    sendMessage($chatId, "Welcome to the Telegram Admin Bot. Let's get started!");

    // Step 1: Ask the user to upload Image 1
    $step = 1;
    requestImage($chatId, "Please send Image 1.");
} elseif ($update["message"]["photo"]) {
    // Handle image uploads based on the step
    $photo = end($update["message"]["photo"]);
    $fileId = $photo["file_id"];

    // Depending on the step, call your API to upload the image
    // Modify the URL to match your API endpoint
    $apiEndpoint = 'https://your-api-url.com/upload.php';
    $postData = [
        'step' => $step,
        'image' => $fileId,
    ];

    $options = [
        'http' => [
            'method' => 'POST',
            'header' => 'Content-Type: application/x-www-form-urlencoded',
            'content' => http_build_query($postData),
        ],
    ];

    $context = stream_context_create($options);
    $apiResponse = file_get_contents($apiEndpoint, false, $context);
    $apiResponse = json_decode($apiResponse, true);

    if ($apiResponse['status'] === 'success') {
        sendMessage($chatId, $apiResponse['message']);

        // Move to the next step
        $step++;
        if ($step == 2) {
            requestImage($chatId, "Please send Image 2.");
        } elseif ($step == 3) {
            // Proceed to collect other details
            sendMessage($chatId, "Please provide the details needed for the database.");
        } elseif ($step == 3) {
    // Collect and handle other details from the user
    sendMessage($chatId, "Please provide the following details:");
    sendMessage($chatId, "1. BS_Type (e.g., House, Apartment)");
    // Update the step for collecting BS_Type
    $step = 4;
}
elseif ($step == 4) {
    // Handle the BS_Type provided by the user
    $bsType = $messageText;
    sendMessage($chatId, "2. BS_Sub_Type (e.g., Rent, Sale)");
    // Update the step for collecting BS_Sub_Type
    $step = 5;
}
elseif ($step == 5) {
    // Handle the BS_Sub_Type provided by the user
    $bsSubType = $messageText;
    sendMessage($chatId, "3. BS_Sub_Type2 (e.g., Residential, Commercial)");
    // Update the step for collecting BS_Sub_Type2
    $step = 6;
}
elseif ($step == 6) {
    // Handle the BS_Sub_Type2 provided by the user
    $bsSubType2 = $messageText;
    sendMessage($chatId, "4. BS_For (e.g., Buy, Rent)");
    // Update the step for collecting BS_For
    $step = 7;
}
elseif ($step == 7) {
    // Handle the BS_For provided by the user
    $bsFor = $messageText;
    sendMessage($chatId, "5. Price");
    // Update the step for collecting Price
    $step = 8;
}
elseif ($step == 8) {
    // Handle the Price provided by the user
    $price = $messageText;
    sendMessage($chatId, "6. Address");
    // Update the step for collecting Address
    $step = 9;
}
elseif ($step == 9) {
    // Handle the Address provided by the user
    $address = $messageText;
    sendMessage($chatId, "7. Landmark");
    // Update the step for collecting Landmark
    $step = 10;
}
elseif ($step == 10) {
    // Handle the Landmark provided by the user
    $landmark = $messageText;
    sendMessage($chatId, "8. State");
    // Update the step for collecting State
    $step = 11;
}
elseif ($step == 11) {
    // Handle the State provided by the user
    $state = $messageText;
    sendMessage($chatId, "9. City");
    // Update the step for collecting City
    $step = 12;
}
elseif ($step == 12) {
    // Handle the City provided by the user
    $city = $messageText;
    sendMessage($chatId, "10. Description");
    // Update the step for collecting Description
    $step = 13;
}
elseif ($step == 13) {
    // Handle the Description provided by the user
    $description = $messageText;
    sendMessage($chatId, "11. Owner");
    // Update the step for collecting Owner
    $step = 14;
}
elseif ($step == 14) {
    // Handle the Owner provided by the user
    $owner = $messageText;
    sendMessage($chatId, "12. Phone No.");
    // Update the step for collecting Phone No.
    $step = 15;
}
elseif ($step == 15) {
    // Handle the Phone No. provided by the user
    $phoneNo = $messageText;
    sendMessage($chatId, "13. Email Id");
    // Update the step for collecting Email Id
    $step = 16;
}
elseif ($step == 16) {
    // Handle the Email Id provided by the user
    $emailId = $messageText;
    sendMessage($chatId, "14. Is Featured (yes or no)");
    // Update the step for collecting Is Featured
    $step = 17;
}
elseif ($step == 17) {
    // Handle the Is Featured provided by the user
    $isFeatured = $messageText;
    sendMessage($chatId, "15. Is Sold (yes or no)");
    // Update the step for collecting Is Sold
    $step = 18;
}
elseif ($step == 18) {
    // Handle the Is Sold provided by the user
    $isSold = $messageText;

    // Insert data into the database
    // You can modify the SQL query to insert all collected data
    $sql = "INSERT INTO buy_sell (Image1, Image2, BS_Type, BS_Sub_Type, BS_Sub_Type2, BS_For, Price, Address, Landmark, State, City, Description, Owner, Phone_No, Email_Id, is_Featured, is_Sold, Created_At) VALUES ('$path1', '$path2', '$bsType', '$bsSubType', '$bsSubType2', '$bsFor', '$price', '$address', '$landmark', '$state', '$city', '$description', '$owner', '$phoneNo', '$emailId', '$isFeatured', '$isSold', NOW())";

    if ($conn->query($sql) === TRUE) {
        sendMessage($chatId, "Data successfully submitted!");
    } else {
        sendMessage($chatId, "Failed to insert data into the database");
    }
}
    } else {
        sendMessage($chatId, "Error: " . $apiResponse['message']);
    }
} elseif ($step == 3) {
    // Handle user input for other details and send them to your API
    // Modify the URL to match your API endpoint
    $apiEndpoint = 'https://your-api-url.com/upload.php';
    $postData = [
        'step' => $step,
        'other_details' => $messageText,
    ];

    $options = [
        'http' => [
            'method' => 'POST',
            'header' => 'Content-Type: application/x-www-form-urlencoded',
            'content' => http_build_query($postData),
        ],
    ];

    $context = stream_context_create($options);
    $apiResponse = file_get_contents($apiEndpoint, false, $context);
    $apiResponse = json_decode($apiResponse, true);

    if ($apiResponse['status'] === 'success') {
        sendMessage($chatId, "Data successfully submitted!");
    } else {
        sendMessage($chatId, "Error: " . $apiResponse['message']);
    }
} else {
    sendMessage($chatId, "Invalid input. Please follow the instructions.");
}
?>
