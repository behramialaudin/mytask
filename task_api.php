<?php
session_start();
require_once "functions.php";

header('Content-type: application/json');

$title = $_POST['title'];
$description = trim($_POST['description']);
$status = $_POST['status'];

$userId = $_SESSION['user_id'];

$task = [
    'title' => $title,
    'description' => $description,
    'status' => $status
];


if(!empty($title) && !empty($description)){
    storeTaskToFile($task, $userId);
    echo json_encode([
        'success' => true,
        'message' => 'Task added',
        'data' => $task
    ]);
    die();
}

if (isUserLoggedIn()) {
    header("Location: /mytask/mytask.php");
    die();
}


?>