<?php

session_start();

if(!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once __DIR__ . '/../php/config/database.php';
    require_once __DIR__ . '/../php/utility/load_env.php';

    loadEnv(__DIR__ . '/../.env');

    $db = new Database();
    $conn = $db->connect();

    $project_id = $_POST['project_id'];

    if($db->removeProject($project_id)) {
        echo "Project removed successfully.";
        header('Location: admin.php');
        exit;
    } else {
        echo "Failed to remove project.";
    }
} else {
    echo "Invalid request method.";
}

?>