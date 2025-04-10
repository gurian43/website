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

    $project_name = $_POST['project_name'];
    $project_description = $_POST['project_description'];
    $project_url = $_POST['project_url'];
    
    if(isset($_FILES['project_image']) && $_FILES['project_image']['error'] === UPLOAD_ERR_OK) {
        $file_tmp_path = $_FILES['project_image']['tmp_name'];
        $file_name = $_FILES['project_image']['name'];
        $file_size = $_FILES['project_image']['size'];
        $file_type = mime_content_type($file_tmp_path);

        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $max_file_size = 10 * 1024 * 1024;

        if(in_array($file_type, $allowed_types) && $file_size <= $max_file_size) {
            $upload_dir = __DIR__ . '/../resources/public/';
            $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
            $new_file_name = uniqid('img_', true) . '.' . $file_extension;
            $destination = $upload_dir . $new_file_name;

            if(move_uploaded_file($file_tmp_path, $destination)) {
                $image_url = '/resources/public/' . $new_file_name;
            } else {
                die("Failed to move uploaded file.");
            }
        } else {
            die("Invalid file type or file size exceeds 10MB.");
        }
    } else {
        die("No valid image uploaded.");
    }

    if($db->addProject($project_name, $project_description, $project_url, $image_url)) {
        echo "Project added successfully.";
    } else {
        echo "Failed to add project.";
    }
} else {
    echo "Invalid request method.";
}

?>