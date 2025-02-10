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

<body>
    <h1>User Page</h1>
    <?php

    echo $user["username"];
    ?>
    <form action="user.php" method="POST">
        <button type="submit" name="logout" value="logout">Logout</button>
    </form>
</body>

</html>

<?php
if (isset($_POST["logout"])) {
    session_destroy();
    header("Location: login.php");
}
?>