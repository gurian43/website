<?php

session_start();

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
    <link rel="icon" type="image/x-icon" href="../resources/images/logo.webp">
    <link rel="stylesheet" href="../resources/css/index.css">
    <link rel="stylesheet" href="../resources/css/admin.css">
    <title>Admin Page</title>
</head>
<body>
    <div class="container">
        <h1>Welcome to the Admin Page</h1>
        <form action="logout.php" method="POST">
            <input type="submit" value="logout">
        </form>
        <div class="admin-actions">
            <form action="add_project.php" method="POST" enctype="multipart/form-data" autocomplete="off">
                <h2>Add Project</h2>
                <input type="text" name="project_name" placeholder="Project Name*" required>
                <input type="text" name="project_url" placeholder="Project URL">
                <textarea name="project_description" placeholder="Project Description*" required></textarea>
                <input type="file" name="project_image" required>
                <input type="submit" value="Add Project">
            </form>
            <div>
                <form action="remove_project.php" method="POST" autocomplete="off">
                    <h2>Remove Project</h2>
                    <input type="text" name="project_id" placeholder="Project ID*" required>
                    <input type="submit" value="Remove Project">
                </form>
                <form action="remove_message.php" method="POST" autocomplete="off">
                    <h2>Remove Message</h2>
                    <input type="text" name="message_id" placeholder="Message ID*" required>
                    <input type="submit" value="Remove Message">
                </form>
            </div>
        </div>
        <h2>Projects</h2>
        <div class="projects">
            <?php
            require_once __DIR__ . '/../php/config/database.php';
            require_once __DIR__ . '/../php/utility/load_env.php';

            loadEnv(__DIR__ . '/../.env');

            $db = new Database();
            $conn = $db->connect();

            $projects = $db->getProjects();
            if($projects) {
                foreach($projects as $project) {
                    echo "<div class='project'>";
                    echo "<h3>" . htmlspecialchars($project['name']) .  "</h3>";
                    echo "<p>ID: " . htmlspecialchars($project['id']) . "</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>No projects found.</p>";
            }
            ?>
        </div>
        <h2>Messages</h2>
        <div class="messages">
            <?php
            $messages = $db->getMessages();
            if($messages) {
                foreach($messages as $message) {
                    echo "<div class='message'>";
                    echo "<h3>" . htmlspecialchars($message['name']) .  "</h3>";
                    echo "<p>ID: " . htmlspecialchars($message['id']) . "</p>";
                    echo "<p>Email: " . htmlspecialchars($message['email']) . "</p>";
                    echo "<p>Message: " . htmlspecialchars($message['message']) . "</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>No messages found.</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>