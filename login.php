<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
        <form action="login.php" method="POST" class="border">
            <h1>Login</h1>
            <label for="username">Username</label>
            <input required class="input" type="text" name="username">
            <label for="password">Password</label>
            <input required class="input" type="password" name="password">
            <button class="button" type="submit" name="login">
                Login
            </button>
            <?php
            include("database.php");
            include("session.php");
            function redirectByRole(string $role)
            {
                header("Location: {$role}.php");
            }
            if (isset($_POST["login"])) {
                $username = $_POST["username"] ?? null;
                $password = $_POST["password"] ?? null;
                if (!$username || !$password) {
                    echo "Invalid email/password";
                    return;
                } else {
                    $sql = "SELECT * FROM users WHERE username='$username'";
                    $res = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($res) > 0) {
                        $row = mysqli_fetch_assoc($res);
                        $db_pass = $row["password"];
                        $role = $row["role"];
                        $vefify_pass = password_verify($password, $db_pass);
                        if (!$vefify_pass) {
                            echo "Invalid Password";
                            return;
                        } else {
                            create_session($username, $role);
                            header("Location: {$role}.php");
                        }
                    } else {
                        echo "Username does not exist";
                    }
                }
            }
            ?>

            <a href="register.php">Don't have an account?</a>
        </form>
    </div>
</body>

</html>