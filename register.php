<?php

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>

<style>
    .container {
        display: flex;
        height: 90vh;
        width: 100vw;
        align-items: center;
        justify-content: center;
    }

    .border {
        display: flex;
        flex-direction: column;
        border: 1px, solid;
        margin: 10px;
        padding: 50px;
        gap: 10px;
        border-radius: 10px;
    }

    .input {
        width: 400px;
        height: 30px;
        font-size: 15px;
    }

    .button {
        width: 400px;
        height: 30px;
    }
</style>


<body>
    <div class="container">
        <form action="register.php" method="POST" class="border">
            <h1>Register</h1>
            <label for="username">Username</label>
            <input required class="input" type="text" name="username">
            <label for="password">Password</label>
            <input required class="input" type="password" name="password">
            <button class="button" type="submit" name="register">
                Register
            </button>

            <?php
            include("database.php");
            function hasDuplicateUsername(string $username, $conn)
            {
                $sql = "SELECT * FROM users WHERE username='$username'";
                try {
                    $res = mysqli_query($conn, $sql);
                    return mysqli_num_rows($res) > 0;
                } catch (mysqli_sql_exception) {
                    echo "Server Error";
                }
            }
            if (isset($_POST["register"])) {
                $username = $_POST["username"] ?? null;
                $password = $_POST["password"] ?? null;
                if (!$username || !$password) {
                    echo "Invalid email/password";
                    return;
                } elseif (hasDuplicateUsername($username, $conn)) {
                    echo "Username Already Exist";
                } else {
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";
                    try {
                        mysqli_query($conn, $sql);
                        header("Location: login.php");
                    } catch (mysqli_sql_exception) {
                        echo "Register Error";
                    }
                    mysqli_close($conn);
                }
            }

            ?>
            <a href="login.php">Already have an account</a>
        </form>
    </div>
</body>

</html>