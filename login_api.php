<?php
    session_start();

    require_once "db.php";
    require_once "functions.php";


    header('Content-type: application/json');

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode([
            'success' => false,
            'message' => 'POST HTTP METHOD REQUIRED'
        ]);
        die(); 
   }

    // if logged in then redirect to timeline.php
    if (isUserLoggedIn()) {
        echo json_encode([
            'success' => false,
            'message' => 'User is already athenticated'
        ]);
        die(); 
    }

    // get the data
    $email = $_POST['email'];
    $password= $_POST['password'];

    $user = findUserByEmailAndPassword($email, $password);


    if($user != null){
        $_SESSION['logged_in'] = true;
        $_SESSION['email'] = $email;

        echo json_encode([
            'success' => true,
            'message' => 'Authenticated'
        ]);
        die();
        
    } else {
        $_SESSION['logged_in'] = false;
        echo json_encode([
            'success' => false,
            'message' => 'Wrong credentials!!'
        ]);
        die();
    }
