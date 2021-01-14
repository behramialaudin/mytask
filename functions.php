<?php 
function isUserLoggedIn(){
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }

	function doesUserExistByEmail($email){
        global $dbConnection;

        $sqlQuery = "SELECT * FROM users WHERE user_email=:email";
        $statement = $dbConnection->prepare($sqlQuery);
        $statement->bindParam(':email', $email);
        if($statement->execute()){
            $user = $statement->fetch(PDO::FETCH_ASSOC);
            return $user !==  false;
        }
        return false;
    }

    function findUserByEmailAndPassword($email, $password){
        global $dbConnection;

        $sqlQuery = "SELECT * FROM users WHERE `user_email`=:email
                         AND `user_password`=:password";
        $encryptedPassword = md5($password);
        $statement = $dbConnection->prepare($sqlQuery);
        $statement->bindParam(':email', $email);
        $statement->bindParam(':password', $encryptedPassword);
        if ($statement->execute()) {
           $user = $statement->fetch(PDO::FETCH_ASSOC);
            return $user !==  false;
        }
        return false;
    }



    function storeUserToDatabase(array $user){
        global $dbConnection;

        $sqlQuery = "INSERT INTO `users`
            (`user_name`, `user_email`, `user_password`)
            VALUES (:fullname, :email, :password);";

        $encryptedPassword = md5($user['password']);
        $statement = $dbConnection->prepare($sqlQuery);
        $statement->bindParam(":fullname", $user['name']);
        $statement->bindParam(":email", $user['email']);
        $statement->bindParam(":password", $encryptedPassword);
            
        if($statement->execute()){
            return true;
        }else{
            return false;
        }
    }
    
    function signOut(){
        session_start();
        session_destroy();
    }

    ?>