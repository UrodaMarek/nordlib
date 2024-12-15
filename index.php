<?php

require_once("./assets/sections.php");
require_once("./assets/style.php");
require_once("./functions/con.php");
require_once("./functions/check.php");

is_installed();

session_start();

$is_loged = false;
if (isset($_SESSION["login"]) && isset($_SESSION["password"])) {
    $is_loged = check_user($login, $password);
}

$option = (isset($_GET["option"])) ? $_GET["option"] : false;

$theme = get_theme($is_loged);

$menu = menu($is_loged, $option);

$main = main_content($is_loged, $option);

$footer = footer();

echo <<<END
    <!DOCTYPE html>
    <html lang="pl-PL">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Nordlib 0.0.0:0001</title>
            <link rel="stylesheet" href="./assets/style/main.css">
            <style>
                $theme
            </style>
        <head>
        <body>
            $menu
            <main>
                $main
            </main>
            $footer
        </body>
    </html>
END;