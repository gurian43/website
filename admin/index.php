<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == 1) {
    header('Location: admin.php');
    exit;
}

require_once __DIR__ . '/../php/config/database.php';
require_once __DIR__ . '/../php/utility/load_env.php';

loadEnv(__DIR__ . '/../.env');

$db = new Database();
$conn = $db->connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($db->authenticate($username, $password)) {
        $_SESSION['user_id'] = 1;
        header('Location: admin.php');
        exit;
    } else {
        echo '<p class="error">Invalid username or password</p>';
    }
}
?>