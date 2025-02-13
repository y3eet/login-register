<?php
include("session.php");
$user = get_session();
if ($user["role"] !== 'user') {
    header("Location: unauthorized.php");
}
?>
<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<style>
    .container {
        display: flex;
        height: 80vh;
        width: 95vw;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }
</style>

<body data-bs-theme="dark" style="margin: 20px">
    <h1>User Page</h1>
    <form action="user.php" method="POST">
        <button type="submit" name="logout" value="logout" class="btn btn-danger">Logout</button>
    </form>
    <div class="container">
        <h1>Welcome, <?= $user["username"] ?>!</h1>
    </div>
</body>

</html>

<?php
if (isset($_POST["logout"])) {
    session_destroy();
    header("Location: login.php");
}
?>