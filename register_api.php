<?php
    session_start();
    require_once "db.php";
    require_once "functions.php";

    header('Content-Type: application/json');

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
            'success' => true,
            'message' => 'User is logged in '
        ]);
        die(); 
    }
    
    // get the data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];


    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number = preg_match('@[0-9]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);

    if (empty($password)) {
        echo json_encode([
            'success' => false,
            'message' => 'Password is empty '
        ]);
        die();
    }
    if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
        echo json_encode([
            'success' => false,
            'message' => 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.'
        ]);
        die();
    
    }


    $user = [
        'name' => $name,
        'email' => $email,
        'password' => $password
    ];

    if (doesUserExistByEmail($email)) {
        echo json_encode([
            'success' => false,
            'message' => 'This user already exists'
        ]);
        die();
    }

    storeUserToDatabase($user);

    echo json_encode([
        'success' => true,
        'message' => 'Welcome'
    ]);
    die();


?>