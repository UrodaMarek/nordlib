<?php

function is_installed() {
    $result = query_db("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = 'NordLib'", 5);
    if (mysqli_num_rows($result) == 0) {
        header("Location: ./installer/");
    }
}