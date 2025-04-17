<?php

if($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once __DIR__ . '/../config/database.php';
    require_once __DIR__ . '/../utility/load_env.php';

    loadEnv(__DIR__ . '/../../.env');

    $db = new Database();
    $conn = $db->connect();

    $message_name = $_POST['name'];
    $message_email = $_POST['email'];
    $message_text = $_POST['message'];

    if($db->addMessage($message_name, $message_email, $message_text)) {

        echo "Message added successfully.";
        header('Location: ../../index.php');
        exit;
    } else {
        echo "Failed to add message..";
    }
} else {
    echo "Invalid request method.";
}

?>