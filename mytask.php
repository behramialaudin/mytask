<?php
session_start();

$config['sess_expire_on_close'] = true;




require_once "functions.php";

if (!isUserLoggedIn()) {
    header("Location: /mytask/login.php");
    die();
}
?>
<html lang="en">

<head>
    <title>My Task </title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>

<body>
<center>
    <label>Title: </label> <br>
    <input type="text"> <br>
    <label>Description: </label> <br>
    <input type="tex"> <br> <br>
    <input type="submit" value="submit">

    <a href="#" id="signout">Sign out!</a>

</body>

<script>
    $("#signout").click(function() {
        const apiEndpoint = "http://localhost/mytask/signout.php";
        $.get(apiEndpoint, function(response) {
            location.reload();
        })

    })
</script>

</html>