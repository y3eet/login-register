<?php
include("session.php");
include("database.php");
$user = get_session();
if ($user["role"] !== 'admin') {
    header("Location: unauthorized.php");
}
?>
<?php

function get_all_users($conn)
{
    $sql = "SELECT * FROM users";
    try {
        $res = mysqli_query($conn, $sql);
        if (mysqli_num_rows($res) > 0) {
            $rows = [];
            while ($row = mysqli_fetch_assoc($res)) {
                $rows[] = $row;
            }
            return $rows;
        }
    } catch (mysqli_sql_exception $e) {
        return $e;
    }
    return [];
}

$users = get_all_users($conn);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<style>
    body,
    h1,
    label,
    a,
    button {
        font-family: Arial, sans-serif;
    }

    table {
        border-collapse: collapse;
        width: 100%;
        margin-top: 10px;
    }

    td,
    th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #dddddd;
    }

    .edit-btn {
        background-color: #4CAF50;
        border: none;
        color: white;
        padding: 8px 16px;
        text-align: center;
        text-decoration: none;
        font-size: 14px;
        cursor: pointer;
        border-radius: 8px;
    }

    .logout-btn {
        background-color: rgb(175, 76, 76);
        border: none;
        color: white;
        padding: 8px 16px;
        text-align: center;
        text-decoration: none;
        font-size: 14px;
        cursor: pointer;
        border-radius: 8px;
    }

    .top-nav {
        display: flex;
        align-items: center;
        justify-content: space-between;

    }

    .input {
        width: 400px;
        height: 30px;
        font-size: 15px;
    }

    .error {
        color: red;
        font-size: 14px;
    }
</style>

<body>
    <div class="top-nav">
        <h1>Admin Page</h1>
        <div>
            <form action="user.php" method="POST">
                <button type="submit" name="logout" value="logout" class="logout-btn">Logout</button>
            </form>
        </div>
    </div>
    <button class="load">
        Load
    </button>
    <table id="tableBody">
        <!-- table will be rendered by ajax call fn:loadTable() -->
    </table>
    <div id="editModal" style="display: none; position: fixed; top: 20%; left: 50%; transform: translateX(-50%); background: white; padding: 20px; border: 1px solid black;">
        <h3>Edit User</h3>
        <form id="editForm">
            <label>Username:</label>
            <input required class="input" type="text" id="editUsername" name="username">
            <br><br>
            <input type="hidden" id="userId" name="id">
            <label>Role:</label>
            <select required class="input" id="editRole" name="role">
                <option value="admin">admin</option>
                <option value="user">user</option>
            </select>
            <div id="error" class="error"></div>
            <br>
            <input type="hidden" name="function" value="update-user">
            <button type="submit" id="updateUser">Save</button>
            <button type="button" id="closeModal">Cancel</button>
        </form>
    </div>
    <script>
        $(document).ready(function() {
            // renders new updated table
            function loadTable() {
                $.ajax({
                    url: "ajax/views/users_table.php",
                    type: "GET",
                    success: function(response) {
                        $("#tableBody").html(response);
                    }
                });
                $("#user-7").prop("disabled", true);
            }
            loadTable();

            // open modal
            $(document).on("click", ".edit-btn", function() {
                let userId = $(this).data("id");
                let username = $(this).data("username");
                let role = $(this).data("role");

                $("#editModal").show();
                $("#userId").val(userId);
                $("#editUsername").val(username);
                $("#editRole").val(role);
            });

            // close modal
            $(document).on("click", "#closeModal", function() {
                $("#editModal").hide();
            });

            // updates a user by ajax call
            $("#editForm").submit(function(event) {
                event.preventDefault();
                $.ajax({
                    url: 'ajax/user.php',
                    type: "POST",
                    data: $("#editForm").serialize(),
                }).done((response) => {
                    if (response.success) {
                        $("#editModal").hide();
                        loadTable();
                    } else {
                        $("#error").html(`<strong>${response.message}</strong>`);
                    }
                }).fail((jqXHR, textStatus, errorThrown) => {
                    console.error("AJAX call failed:", textStatus, errorThrown);
                    $("#error").html(`<strong>AJAX call failed: ${textStatus}</strong>`);
                });
            });

        });
    </script>


</body>

</html>
<?php
if (isset($_POST["logout"])) {
    session_destroy();
    header("Location: login.php");
}
?>