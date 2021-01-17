<?php
session_start();

require_once "functions.php";
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'POST HTTP Method required!'
    ]);
    die();
}

// if logged in then redirect to timeline.php
if (!isUserLoggedIn()) {
    echo json_encode([
        'success' => false,
        'message' => 'User not authenticated!'
    ]);
    die();
}

// .... 

$userId = $_SESSION['user_id'];
$taskId = $_POST['task_id'];
deleteTaskByTaskId($taskId);

echo json_encode([
    'success' => true,
    'message' => 'Task deleted'
]);
die();