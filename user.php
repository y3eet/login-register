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

</head>

<style>
    body,
    h1,
    label,
    a,
    button {
        font-family: Arial, sans-serif;
    }


    .container {
        display: flex;
        height: 80vh;
        width: 95vw;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }

    .input {
        width: 400px;
        height: 30px;
        font-size: 15px;
    }

    .logout-btn {
        background-color: rgb(175, 76, 76);
        border: none;
        color: white;
        padding: 8px 16px;
        text-align: center;
        text-decoration: none;
        font-size: 18px;
        cursor: pointer;
        border-radius: 8px;
        width: 100px;
        height: 50px;
    }
</style>

<body>
    <h1>User Page</h1>

    <div>
        <form class="container" action="user.php" method="POST">
            <h1>Welcome, <?= $user["username"] ?>!</h1>
            <button type="submit" name="logout" value="logout" class="logout-btn">Logout</button>
        </form>
    </div>
</body>

</html>

<?php
if (isset($_POST["logout"])) {
    session_destroy();
    header("Location: login.php");
}
?>