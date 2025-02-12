<?php

session_start();

function create_session(string $username, ?string $role = "user")
{
    $_SESSION["username"] = $username;
    $_SESSION["role"] = $role;
}

function get_session()
{
    $session = [
        "username" => $_SESSION["username"] ?? null,
        "role" => $_SESSION["role"] ?? null,
    ];

    return $session;
}
