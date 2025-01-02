<?php
function register()
{
    if (
        isset($_POST["nick"]) and
        isset($_POST["email"]) and
        isset($_POST["name"]) and
        isset($_POST["surname"]) and
        isset($_POST["password"]) and
        isset($_POST["password2"]) and
        $_POST["password"] == $_POST["password2"] and
        isset($_POST["sure"]) and
        $_POST["sure"] == "on"
    ) {
        $nick = "'".$_POST["nick"]."'";
        $email = "'".$_POST["email"]."'";
        $password = "'".(hash_pass($_POST["password"]))."'"; //TODO: validate it !!!!
        $name = "'".$_POST["name"]."'";
        $name2 = (!($_POST["name2"]=="")) ? "'".$_POST["name2"]."'" : "NULL";
        $name3 = (!($_POST["name3"]=="")) ? "'".$_POST["name3"]."'" : "NULL";
        $surname = "'".$_POST["surname"]."'";
        $tel = (!($_POST["tel"]=="")) ? "'".$_POST["tel"]."'" : "NULL";
        $country = (!($_POST["country"]=="")) ? $_POST["country"] : "NULL";
        $sex = (!($_POST["sex"]=="")) ? $_POST["sex"] : "NULL";
        $interesting = (!($_POST["interesting"]=="")) ? "'".$_POST["interesting"]."'" : "NULL";
        //TODO: Validation of input

        $q = "SELECT `Users`.`id` FROM `Users` WHERE `username`=$nick OR `email`=$email";
        $result = query_db($q, 3);

        if ($result -> num_rows == 0) {
            $q = "INSERT INTO `Personal_information` (`first_name`, `second_name`, `third_name`, `surname`, `sex_id`, `telephone`, `country_id`, `interested_in`) VALUES ($name, $name2, $name3, $surname, $sex, $tel, $country, $interesting)";
            $result = query_db($q, 3, true);

            $personal_information_id = $result -> insert_id;
            $personal_id = gen_personal_id();
            

            $q = "INSERT INTO Human (`personal_id`, `personal_information_id`) VALUES ('$personal_id', $personal_information_id);";

            $result = query_db($q, 3, true);

            $human_id = $result -> insert_id;

            $q = "INSERT INTO Users (`username`, `pass`, `email`, `role_id`, `human_id`, `reset`) VALUES ($nick, $password, $email, 2, $human_id, FALSE);";

            $result = query_db($q, 3);
            //$result -> close();

            $_SESSION["login"] = $nick;
            $_SESSION["password"] = $password;

            header('Location: ./index.php');
        } else {
            header('Location: ./index.php?option=register');
        }
    } else {
        header('Location: ./index.php?option=register');
    }
}

function gen_personal_id() {
    $id = rand (1, 999999999999999);
    $id = str_pad($id, 15, "0", STR_PAD_LEFT);
    $q = "SELECT `Human`.`id` FROM `Human` WHERE `Human`.`personal_id`='$id'";
    $result = query_db($q, 3);
    $count = $result -> num_rows;
    $result -> close();
    if ($count == 0) {
        return $id;
    } else {
        return gen_personal_id();
    }
}

function log_in()
{
    if (
        isset($_POST["login"]) and
        isset($_POST["password"]) and
        $_POST["login"] != "" and
        $_POST["password"] != ""
    ) {
        $username = "'".$_POST["login"]."'";
        $password = "'".(hash_pass($_POST["password"]))."'";
        $q = "SELECT `Users`.`username`, `Users`.`pass` FROM `Users` WHERE `username`=$username OR `email`=$username AND `pass`=$password";
        $result = query_db($q, 3);
        if ($result -> num_rows == 1) {
            $row = $result -> fetch_row();
            $_SESSION['login'] = "'".$row[0]."'";
            $_SESSION['password'] = "'".$row[1]."'";
            header('Location: ./index.php');
        } else {
            header('Location: ./index.php?option=login');
        }
    } else {
        header('Location: ./index.php?option=login');
    }
}

function hash_pass($password) {
    $salt = "4c42ad5dcec81f9f14086478f9b1b4f9719b4ee0f8709b060c0562ed4a2866ec19195ced78944c67ea05158a310757dd86b5506324f0e8afd83d2e08c61c7ce3";
    return $hash = hash('sha512', $salt . $password);
}

function send_message()
{
}

function delete_message()
{
}

function delete_user()
{
}

function publish()
{
}

function change_visibilty()
{
}