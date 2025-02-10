<?php
include("session.php");
$user = get_session();
$role = $user["role"];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unauthorized</title>
</head>

<body>
    <h1>Unauthorized Access</h1>
    <p>You're not authorized to acccess this page!</p>
    <?php
    if ($role === 'admin') {
        echo "<a href=\"admin.php\">Go Back to Admin Page</a>";
    } elseif ($role === 'user') {
        echo "<a href=\"user.php\">Go Back to User Page</a>";
    } else {
        echo "<a href=\"login.php\">Go Back</a>";
    }
    ?>
</body>

</html>