<?php
session_start();

require_once "functions.php";
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] != 'GET') {
    echo json_encode([
        'success' => false,
        'message' => 'GET HTTP Method required!'
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
$tasks = getTasksByUserId($userId);

echo json_encode([
    'success' => true,
    'message' => 'tasks list',
    'data'    => $tasks
]);
die();