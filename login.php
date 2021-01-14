<?php
session_start();

require_once "functions.php";

if (isUserLoggedIn()) {
    header("Location: /mytask/mytask.php");
    die();
}

?>
<html lang="en">

<head>

    <title>My task | Log in</title>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

</head>

<body>

    <center>

        <h1> LOG IN </h1>
        <form onsubmit="return login();">
            <label>Email: </label> <br>
            <input id="login_email" type="email">  <br>
            <label>Password: </label> <br>
            <input id="login_password" type="password"> <br> <br>
            <input type="submit" value="Log in">
        </form>

        <a href="/mytask/register.php">Create account</a>


    </center>

</body>


<script>
    function login() {

        
        const email = $("#login_email").val();
        const password = $("#login_password").val();

        const apiEndpoint = "http://localhost/mytask/login_api.php";



        
        $.post(apiEndpoint, {
            'email': email,
            'password': password
        }, function(response) {
            if (response.success == false) {
                alert(response.message);
            
            } else {
                location.reload();
            }
        });

        return false;
    }
</script>

</html>