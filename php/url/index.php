<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URL Shortener</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>URL Shortener</h1>
        <form action="index.php" method="post" autocomplete="off">
            <input class="input-url" type="text" name="url" placeholder="Enter URL" required>
            <input class="button-submit" type="submit" value="Shorten">
        </form>
    </div>
</body>
</html>


<?php

require_once __DIR__ . '/../utility/load_env.php';
require_once __DIR__ . '/../config/database.php';


if(!isset($db)) {
    loadEnv('/.env');
    $db = new Database();
    $conn = $db->connect();
}

if(isset($_POST['url'])) {
    $url = $_POST['url'];
    $url = filter_var($url, FILTER_SANITIZE_URL);

    if(filter_var($url, FILTER_VALIDATE_URL)) {
        $unique_id = $db->shortenUrl($url);
    
        if($unique_id !== null) {
            echo 'URL was shortened to ' . "$_SERVER[HTTP_HOST]/?u=$unique_id";
        } else {
            echo 'Error: ' . $conn->error;
        }
    } else {
        echo 'Invalid URL';
        exit;
    }
}

?>