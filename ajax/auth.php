<?php
include("../database.php");
include("../session.php");

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["function"])) {
    $action = $_POST["function"];
    // login api
    if ($action === "login") {
        if (isset($_POST["username"]) && isset($_POST["password"])) {
            $username = trim($_POST["username"]);
            $password = trim($_POST["password"]);

            $sql = "SELECT * FROM users WHERE username='$username'";
            $res = mysqli_query($conn, $sql);

            if (mysqli_num_rows($res) > 0) {
                $row = mysqli_fetch_assoc($res);
                $db_pass = $row["password"];
                $role = $row["role"];
                if (password_verify($password, $db_pass)) {
                    create_session($username, $role);
                    echo json_encode([
                        "success" => true,
                        "message" => "Logged In Successfully",
                        "redirect" => "{$role}.php"
                    ]);
                } else {
                    echo json_encode(["success" => false, "message" => "Invalid Password", "field" => "password"]);
                }
                mysqli_close($conn);
            } else {
                echo json_encode(["success" => false, "message" => "Username does not exist", "field" => "username"]);
            }
        } else {
            echo json_encode(["success" => false, "message" => "Missing username or password"]);
        }
    }
    // register api
    if ($action === "register") {
        function hasDuplicateUsername(string $username, $conn)
        {
            $sql = "SELECT * FROM users WHERE username='$username'";
            $res = mysqli_query($conn, $sql);
            return mysqli_num_rows($res) > 0;
        }
        if (isset($_POST["username"]) && isset($_POST["password"])) {
            $username = $_POST["username"];
            $password = $_POST["password"];
            if (hasDuplicateUsername($username, $conn)) {
                echo json_encode(["success" => false, "message" => "Username already exist", "field" => "username"]);
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";
                $role = "user";
                // auto login
                create_session($username, $role);
                mysqli_query($conn, $sql);
                echo json_encode([
                    "success" => true,
                    "message" => "Registered In Successfully",
                    "redirect" => "{$role}.php"
                ]);

                mysqli_close($conn);
            }
        } else {
            echo json_encode(["success" => false, "message" => "Missing username or password"]);
        }
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
}
