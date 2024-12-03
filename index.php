<?php

// ? SESSION SETTING
$isLoged = false;

$session = $isLoged;


require_once("./assets/sections.php");
require_once("./assets/style.php");
require_once("./functions/con.php");
require_once("./functions/privileges.php");
require_once("./functions/check.php");

is_installed();

$level = get_priv($session);

$theme = get_theme($session);

$menu = menu($level);

$main = main_content();

$footer = footer();


echo <<< END
    <!DOCTYPE html>
    <html lang="pl-PL">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Nordlib 0.0.0:000004</title>
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