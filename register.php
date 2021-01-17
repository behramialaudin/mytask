<?php
session_start();

?>
<html lang="en">

<head>

    <title>My Task | Register</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

</head>

<body>

    <center>

        <form onsubmit="return register();">
            <h1> Register</h1>
            <label>Name: </label> <br>
            <input id="register_name" type="text" name="name" required> <br>
            <label>Email: </label> <br>
            <input id="register_email" type="email" name="email" required> <br>
            <label>Password: </label> <br>
            <input id="register_password" type="password" name="password"> <br> <br>
            <input type="submit" value="Register">
        </form>

        <a href="/mytask/login.php">Log in now </a>
    </center>

</body>

<script>
    function register() {

        const name = $("#register_name").val();
        const email = $("#register_email").val();
        const password = $("#register_password").val();

        const apiEndpoint = "http://localhost/mytask/register_api.php";

        $.post(apiEndpoint, {
            'name': name,
            'email': email,
            'password': password
        }, function(response) {

            if (response.success == false) {
                alert(response.message);
            } else {
                window.location.replace("http://localhost/mytask/login.php");
            }
        });

        return false;
    }
</script>

</html>