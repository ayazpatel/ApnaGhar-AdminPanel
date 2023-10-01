<?php
require 'vendor/autoload.php';

use Telegram\Bot\Api;

// Replace 'YOUR_BOT_TOKEN' with your actual bot token
$telegram = new Api('6533824375:AAFICZ_03tGu1QD4gG0CHHwLlJha1fnBCQ8');

// Get updates from Telegram
$updates = $telegram->getWebhookUpdates();

// Handle incoming messages and callbacks
$message = $updates->getMessage();
$callbackQuery = $updates->getCallbackQuery();

if ($message) {
    // Handle regular messages here
    $chatId = $message->getChat()->getId();

    // Send a welcome message with a menu button
    $keyboard = [
        [
            ['text' => 'Menu', 'callback_data' => 'menu']
        ]
    ];

    $markup = $telegram->replyKeyboardMarkup([
        'keyboard' => $keyboard,
        'resize_keyboard' => true,
        'one_time_keyboard' => true,
    ]);

    $telegram->sendMessage([
        'chat_id' => $chatId,
        'text' => 'Welcome to your chatbot! Please choose an option:',
        'reply_markup' => $markup,
    ]);
}

if ($callbackQuery) {
    // Handle button clicks here
    $callbackData = $callbackQuery->getData();
    $chatId = $callbackQuery->getMessage()->getChat()->getId();
    $messageId = $callbackQuery->getMessage()->getMessageId();

    if ($callbackData === 'menu') {
        // User clicked the "Menu" button
        $keyboard = [
            [
                ['text' => 'Option 1', 'callback_data' => 'option1'],
                ['text' => 'Option 2', 'callback_data' => 'option2']
            ]
        ];

        $markup = $telegram->inlineKeyboardMarkup([
            'inline_keyboard' => $keyboard
        ]);

        $telegram->editMessageText([
            'chat_id' => $chatId,
            'message_id' => $messageId,
            'text' => 'Choose an option:',
            'reply_markup' => $markup,
        ]);
    }

    // Handle other button callbacks here if needed
}
