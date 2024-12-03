<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instalator</title>
</head>
<body>
    <?php
        require_once("./assets.php");

        $param = (
            isset($_GET["installation"]) and 
            isset($_POST["host"]) and 
            isset($_POST["login"]) and 
            isset($_POST["password"])
            ) ? [
                [
                    $_GET["installation"]
                ]
                ,
                [
                    $_POST["host"],
                    $_POST["login"],
                    $_POST["password"]
                ]
            ] : FALSE;
            
        wizard($param);
    ?>
</body>
</html>

