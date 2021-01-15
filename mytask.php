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
    <link rel="stylesheet" type="text/css" href="mytask.css">
</head>

<body>



        <h1>My Task</h1>
        <button id="add_new_button">Add New</button>

    <button href="#" id="signout">Sign out!</button>
<form id="new_menu_item_form" style="display: none;">
        <label>Title:</label><br>
        <input id="new_menu_item_form_title" type="text" /><br>
        <label>Description:</label><br>
        <textarea id="new_menu_item_form_description"></textarea> <br>
        <select name="" id="select_dropdown">
            <option value="to_do"> To Do</option>
            <option value="in_progress">In Progress</option>
            <option value="done" selected>Done</option>


        </select><br>

        <button id="new_menu_item_close_button" type="button" value="Close">Close</button>
        <button id="new_menu_item_add_button" type="button" value="Add">Add</button>

    </form>



</body>

<script>
    $("#signout").click(function() {
        const apiEndpoint = "http://localhost/mytask/signout.php";
        $.get(apiEndpoint, function(response) {
            location.reload();
        })

    })

    $("#add_new_button").click(function(){
    $("#new_menu_item_form").css("display", "block");
});

$("#new_menu_item_close_button").click(function () {
    $("#new_menu_item_form").css("display", "none");
});

</script>



</html>