<?php 

require_once "db.php";

function isUserLoggedIn(){
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }

	function doesUserExistByEmail($email){
        global $dbConnection;

        $sqlQuery = "SELECT * FROM users WHERE user_email=:email";
        $statement = $dbConnection->prepare($sqlQuery);
        $statement->bindParam(':email', $email);
        if ($statement->execute()) {
            $user = $statement->fetch(PDO::FETCH_ASSOC);
            if($user !== false){
                 return $user;
            }
         }
         return null;
    }

    function findUserByEmailAndPassword($email, $password){
        global $dbConnection;

        $sqlQuery = "SELECT * FROM users WHERE user_email=:email
                         AND user_password=:password";
        $encryptedPassword = md5($password);
        $statement = $dbConnection->prepare($sqlQuery);
        $statement->bindParam(':email', $email);
        $statement->bindParam(':password', $encryptedPassword);

        if ($statement->execute()) {
            $user = $statement->fetch(PDO::FETCH_ASSOC);
            if($user !== false){
                 return $user;
            }
         }
         return null;
    
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


    function storeTaskToFile(array $task, $userId){
        global $dbConnection;

        $sqlQuery = "INSERT INTO `tasks` (`task_title`, `task_description`,`task_status`, `user_id`) 
                        VALUES (:title, :description, :status, :user_id);";

        $statement = $dbConnection->prepare($sqlQuery);
        $statement->bindParam(":title", $task['title']);
        $statement->bindParam(":description", $task['description']);
        $statement->bindParam(":status",$task['status']);
        $statement->bindParam(":user_id", $userId);

        if($statement->execute()){
            return true;
        }else{
            return false;
        }
    }

    function getTasksByUserId($userId){
        global $dbConnection;

        $sqlQuery = "SELECT * FROM `tasks` WHERE `user_id`=:user_id";
        $statement = $dbConnection->prepare($sqlQuery);
        $statement->bindParam(":user_id", $userId);

        if($statement->execute()){
            $tasks = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $tasks;
        }else{
            return [];
        }
    }


    function deleteTaskByTaskId($taskId){
        global $dbConnection;

        $sqlQuery = "DELETE FROM `tasks` WHERE `tasks`.`task_id` =:task_id";
        $statement = $dbConnection->prepare($sqlQuery);
        $statement->bindParam(":task_id", $taskId);

        if($statement->execute()){
            return true;
        }else{
            return false; 
        }

    }

    function updateTaskStatusByTaskId($taskId,$taskStatus){
        $sqlQuery = "UPDATE `tasks` SET task_status=:task_status WHERE task_id=:task_id";
        $statement = $dbConnection->prepare($sqlQuery);
        $statement->bindParam(":task_status", $taskStatus);
        $statement->bindParam(":task_id", $taskId);

        if($statement->execute()){
            return true;
        }else{
            return false; 
        }

        
    }



    ?>


    