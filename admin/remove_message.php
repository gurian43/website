<?php

if($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once __DIR__ . '/../php/config/database.php';
    require_once __DIR__ . '/../php/utility/load_env.php';

    loadEnv(__DIR__ . '/../.env');

    $db = new Database();
    $conn = $db->connect();

    $message_id = $_POST['message_id'];

    if($db->removeMessage($message_id)) {
        echo "Message removed successfully.";
        header('Location: admin.php');
        exit;
    } else {
        echo "Failed to remove message.";
    }
} else {
    echo "Invalid request method.";
}
?>