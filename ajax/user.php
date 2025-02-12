<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include("../database.php");
$current_user = get_session();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["function"])) {
    $action = $_POST["function"];
    // update user api
    if ($action === "update-user") {

        // ensure only admin can execute this api
        if ($current_user["role"] !== 'admin') {
            header("Location: ../unauthorized.php");
            exit;
        }

        // api can also be reused if user wants to update their own profile
        // ensure only current user can update their own profile (No UI Yet)
        if (isset($_POST["username"]) && $current_user["username"] !== $_POST["username"]) {
            header("Location: ../unauthorized.php");
            exit;
        }


        if (isset($_POST["username"]) && isset($_POST["role"]) && isset($_POST["id"])) {
            $username = $_POST["username"];
            $role = $_POST["role"];
            $id = $_POST["id"];
            $result = $conn->query("UPDATE users 
            SET username = '$username', role = '$role'
            WHERE id = '$id'");
            if ($result) {
                echo json_encode(["success" => true, "message" => "Success User Update"]);
            } else {
                echo json_encode(["success" => false, "message" => "Error Updating User"]);
            }
        } else {
            echo json_encode(["success" => false, "message" => "Invalid Data"]);
        }
    }
}
