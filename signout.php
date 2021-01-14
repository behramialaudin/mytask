<?php
    require_once "functions.php";
    
    signOut();

    header('Content-Type: application/json');

    echo json_encode([
        'success' => true,
        'message' => 'User session is destroyed'
    ]);
    die();
?>