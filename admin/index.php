<?php
session_start();

if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == 1) {
    header('Location: admin.php');
    exit;
}

require_once __DIR__ . '/../php/config/database.php';
require_once __DIR__ . '/../php/utility/load_env.php';

loadEnv(__DIR__ . '/../.env');

$db = new Database();
$conn = $db->connect();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($db->authenticate($username, $password)) {
        $_SESSION['user_id'] = 1;
        header('Location: admin.php');
        exit;
    } else {
        $error = 'Invalid username or password';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/resources/css/index.css">
    <link rel="stylesheet" href="/resources/css/admin.css">
    <title>Admin Login</title>
</head>
<body>
    <div class="container">
        <?php if ($error) { echo '<p class="error">' . $error . "</p>"; } ?>
        <form action="#" method="POST" autocomplete="off">
            <div class="login-container">
                <h1>Admin Login</h1>
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="submit" value="Login"></input>
            </div>
        </form>
    </div>
</body>
</html>