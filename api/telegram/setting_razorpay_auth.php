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

$update = json_decode(file_get_contents("php://input"), TRUE);
$chatId = $update["message"]["chat"]["id"];
$messageText = $update["message"]["text"];

// Define the conversation step
$step = 0;

// Check if a message with /start command is received
if ($messageText == "/start") {
    sendMessage($chatId, "Welcome to the Telegram Admin Bot. Let's get started!");

    // Step 1: Ask the user to choose an option
    $step = 1;

    // Create an array of custom buttons for Option 1 and Option 2
    $keyboard = [
        ["Option 1"],
        ["Option 2"]
    ];

    // Convert the keyboard array to JSON
    $keyboardJson = json_encode([
        "keyboard" => $keyboard,
        "resize_keyboard" => true,
        "one_time_keyboard" => true,
        "selective" => false
    ]);

    // Send a message with the custom keyboard
    sendMessage($chatId, "Choose an option:", $keyboardJson);
} elseif ($messageText == "Option 1") {
    // Handle Option 1
    // You can add code here to handle Option 1, e.g., ask for sub-options
    sendMessage($chatId, "You selected 'Option 1'. What would you like to do next?");
    $step = 2; // Update the step to indicate that we are handling Option 1
} elseif ($messageText == "Option 2") {
    // Handle Option 2
    // You can add code here to handle Option 2
    sendMessage($chatId, "You selected 'Option 2'. What would you like to do next?");
    $step = 3; // Update the step to indicate that we are handling Option 2
} elseif ($step == 2) {
    // Handle sub-options for Option 1
    if ($messageText == "/upload_buy_rent_details") {
        // Handle the "/upload_buy_rent_details" sub-option
        // You can add your code here to handle this sub-option
        sendMessage($chatId, "You selected '/upload_buy_rent_details'. Please send Image 1.");
    } elseif ($messageText == "/other_sub_option") {
        // Handle the "/other_sub_option" sub-option
        // You can add your code here to handle this sub-option
        sendMessage($chatId, "You selected '/other_sub_option'.");
    } else {
        // Handle other user input or invalid options for Option 1
        sendMessage($chatId, "Invalid input for Option 1. Please follow the instructions.");
    }
} elseif ($step == 3) {
    // Handle actions for Option 2
    // You can add your code here to handle actions for Option 2
} else {
    // Handle other user input or invalid options
    sendMessage($chatId, "Invalid input. Please follow the instructions.");
}

// ...
?>
