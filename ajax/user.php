<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include("../database.php");
include("../session.php");
$current_user = get_session();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["function"])) {
    $action = $_POST["function"];
    // update user api
    if ($action === "update-user") {

        // ensure only admin can execute this api
        if ($current_user["role"] !== 'admin') {
            echo json_encode(["success" => false, "message" => "Invalid Access"]);
            return;
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
