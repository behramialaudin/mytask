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
    <script src="/mytask.js"></script>
</head>

<body>



    <h1>My Task</h1>
    <button id="add_new_button">Add New</button>

    <button href="#" id="signout">Sign out!</button>
    <form onsubmit="return addTask();" id="new_menu_item_form" style="display: none;">
        <label>Title:</label><br>
        <input id="new_menu_item_form_title" type="text" /><br>
        <label>Description:</label><br>
        <textarea id="new_menu_item_form_description"></textarea> <br>
        <select id="select_dropdown">
            <option value="to_do"> To Do</option>
            <option value="in_progress">In Progress</option>
            <option value="done" selected>Done</option>


        </select><br>

        <button id="new_menu_item_close_button" type="button" value="Close">Close</button>
        <button id="new_menu_item_add_button" type="submit" value="Add">Add</button>
    </form>
    <br><br>
    <center>
        <table id="menu_items_table">
        </table>
    </center>


</body>

<script>
    $("#signout").click(function() {
        const apiEndpoint = "http://localhost/mytask/signout.php";
        $.get(apiEndpoint, function(response) {
            location.reload();
        })

    })

    function addTask() {
        const title = $("#new_menu_item_form_title").val();
        const description = $("#new_menu_item_form_description").val();
        const status = $("#select_dropdown").val();

        const apiEndpoint = "http://localhost/mytask/mytask_api.php";

        $.post(apiEndpoint, {
            'title': title,
            'description': description,
            'status': status
        }, function(response) {
            if (response.success == false) {
                alert(response.message);

            } else {
                location.reload();


            }
        });

        return false;
    }

    $(document).ready(function() {
        loadTasks();
    });

    let allTasksTemplate = "";

    const noTaskTemplate = '<div>' +
        'You dont have any tasks.' +
        '</div>';
    const taskTemplate = '<tr>' +
        '<td>' +
        '<span id="tasktitle">{{task_title}}</span><br>' +
        '<span>{{task_description}}</span>' +
        '</td>' +
        '<td>' +
        '<select>' +
        '<option value="to_do" {{status_to_do}}> To Do</option>' +
        '<option value="in_progress" {{status_in_progress}}>In Progress</option>' +
        '<option value="done" {{status_done}}>Done</option>' +
        '</select>' +
        '</td>' +
        '<td>' +
        '<button onclick="deleteTask({{task_idx}})">DELETE</button>' +
        '</td>' +
        '"</tr>';


    function loadTasks() {
        const apiEndpoint = "http://localhost/mytask/task_api.php";
        $.get(apiEndpoint, function(response) {
            if (response.success == false || response.data.length == 0) {
                $("#menu_items_table").html(noTaskTemplate);
            } else {

                let allTasksTemplate = "";
                for (let i = 0; i < response.data.length; i++) {
                    const currentTask = response.data[i];
                    let statusi = currentTask.task_status;
                    allTasksTemplate += taskTemplate.replace("{{task_title}}", escapeHtml(currentTask.task_title))
                        .replace("{{task_description}}", escapeHtml(currentTask.task_description))
                        .replace("{{status_" + statusi + "}}", "selected")
                        .replace("{{task_idx}}", currentTask.task_id);
                }
                $("#menu_items_table").append(allTasksTemplate);
            }
        });
    }

    function deleteTask(idx) {
        const apiEndpoint = "http://localhost/mytask/task_delete_api.php";

        let message = confirm("Are you sure u want to delete this task with id=" +idx);

        if (message == true) {
            $.post(apiEndpoint, {
                'task_id': idx
            }, function(response) {
                if (response.success == false) {

                } else {
                    location.reload();
                }
            });

        } 
    }



    function escapeHtml(str) {
        var map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return str.replace(/[&<>"']/g, function(m) {
            return map[m];
        });
    }



    $("#add_new_button").click(function() {
        $("#new_menu_item_form").css("display", "block");
    });

    $("#new_menu_item_close_button").click(function() {
        $("#new_menu_item_form").css("display", "none");
    });
</script>

</html>