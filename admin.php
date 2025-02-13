<?php
include("session.php");
include("database.php");
$user = get_session();
if ($user["role"] !== 'admin') {
    header("Location: unauthorized.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<style>
    .top-nav {
        display: flex;
        align-items: center;
        justify-content: space-between;

    }
</style>

<body data-bs-theme="dark" style="margin: 20px">
    <div class="top-nav">
        <h1>Admin Page</h1>
        <div>
            <form action="user.php" method="POST">
                <button type="submit" name="logout" value="logout" class="btn btn-danger">Logout</button>
            </form>
        </div>
    </div>
    <button id="refresh" class="btn btn-info" style="margin-top: 50px;">
        Refresh
    </button>
    <table class="table table-striped" id="tableBody">
        <!-- table will be rendered by ajax call fn:loadTable() -->
    </table>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit User:</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editForm" method="POST">
                    <input type="hidden" id="userId" name="id">
                    <div class="modal-body form-select-lg m-2">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">Username</span>
                            <input class="form-control" required type="text" id="editUsername" name="username">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">Role</span>
                            <select required id="editRole" name="role" class="form-select">
                                <option value="admin">admin</option>
                                <option value="user">user</option>
                            </select>
                        </div>
                        <div id="error" class="error"></div>
                        <input type="hidden" name="function" value="update-user">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
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
            }
            loadTable();
            $(document).on("click", "#refresh", function() {
                loadTable();
            });

            // open modal
            $(document).on("click", "#editBtn", function() {
                let userId = $(this).data("id");
                let username = $(this).data("username");
                let role = $(this).data("role");

                $("#exampleModalLabel").text(`User ID: ${userId}`)
                $("#editModal").show();
                $("#userId").val(userId);
                $("#editUsername").val(username);
                $("#editRole").val(role);
            });


            // updates a user by ajax call
            $("#editForm").submit(function(event) {
                event.preventDefault();
                $.ajax({
                        url: 'ajax/user.php',
                        type: "POST",
                        data: $("#editForm").serialize(),
                    })
                    .done((response) => {
                        if (response.success) {
                            $("#editUserModal").hide();
                            loadTable();
                        } else {
                            $("#error").html(`<strong>${response.message}</strong>`);
                        }
                    }).fail((jqXHR, textStatus, errorThrown) => {
                       //TODO: use toast
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