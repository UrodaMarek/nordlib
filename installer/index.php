<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instalator</title>
    <link rel="stylesheet" href="../assets/style/main.css">
</head>
<body>
    <main>
        <?php
            require_once("./assets.php");

            $param = (
                isset($_GET["installation"]) and 
                isset($_POST["host"]) and 
                isset($_POST["db_login"]) and 
                isset($_POST["db_password"]) and
                isset($_POST["nick"]) and 
                isset($_POST["email"]) and 
                isset($_POST["name"]) and 
                isset($_POST["surname"]) and
                isset($_POST["password"]) and 
                isset($_POST["password2"]) and
                $_POST["password"] == $_POST["password2"] and
                isset($_POST["sure"]) and 
                $_POST["sure"] == "on"
                ) ? [
                    [
                        $_GET["installation"]
                    ]
                    ,
                    [
                        $_POST["host"],
                        $_POST["db_login"],
                        $_POST["db_password"]
                    ]
                    ,
                    [
                        //TODO: Make it smarter.
                        //! Must be the same like in con.php
                        $password_for_anonymous_librarian = "secret0",
                        $password_for_user_librarian = "secret1",
                        $password_for_admin_librarian = "secret2",
                        $password_for_mr_register = "secret3",
                        $password_for_mr_statistic = "secret4"
                    ]
                    ,
                    [
                        $_POST["nick"],
                        $_POST["email"],
                        $_POST["name"],
                        $name2 = (!($_POST["name2"]=="")) ? $_POST["name2"] : "NULL",
                        $name3 = (!($_POST["name3"]=="")) ? $_POST["name3"] : "NULL",
                        $_POST["surname"],
                        $tel = (!($_POST["tel"]=="")) ? $_POST["tel"] : "NULL",
                        $country = (!($_POST["country"]=="")) ? $_POST["country"] : "NULL",
                        $sex = (!($_POST["sex"]=="")) ? $_POST["sex"] : "NULL",
                        $_POST["password"],
                        $interesting = (!($_POST["interesting"]=="")) ? $_POST["interesting"] : "NULL"
                    ]
                ] : FALSE;
                
            wizard($param);
        ?>
    </main>
</body>
</html>

