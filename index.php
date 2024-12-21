<?php
session_start();

require_once("./functions/con.php");
require_once("./assets/sections.php");
require_once("./assets/style.php");
require_once("./functions/check.php");
require_once("./functions/actions.php");

is_installed();

$is_loged = is_loged();

if (isset($_GET["action"])) {
    switch ($_GET["action"]) {
        case "send_message":
            break;
        case "delete_message":
            break;
        case "publish":
            break;
        case "change_visibilty":
            break;
        case "log_in":
            if($is_loged === FALSE) {
                log_in();
            }
            break;
        case "register":
            if($is_loged === FALSE) {
                register();
            }
            break;
        case "delete_user":
            break;
    }
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