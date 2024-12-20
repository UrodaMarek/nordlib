<?php

function is_installed()
{
    $result = query_db("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = 'NordLib'", 5);
    if (mysqli_num_rows($result) == 0) {
        header("Location: ./installer/");
    }
}

function is_loged() {
    $is_loged = false;
    if (isset($_SESSION["login"]) && isset($_SESSION["password"])) {
        $is_loged = check_user($_SESSION["login"], $_SESSION["password"]);
    }
    return $is_loged;
}

function check_user($username, $password)
{
    $q = "SELECT `id` FROM Users WHERE `username`=$username OR `email`=$username AND `pass`=$password;";
    $result = query_db($q, 3);
    if (mysqli_num_rows($result) == 0) {
        return false;
    }
    $result->close();
    return true;
}