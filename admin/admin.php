<?php

session_start();

// Check if the user is logged in
if(!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
</head>
<body>
    <h1>Welcome to the Admin Page</h1>
    <form action="logout.php" method="POST">
        <input type="submit" value="logout">
    </form>
</body>
</html>