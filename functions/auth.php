<?php

function hash_pass($password)
{
    $salt = "4c42ad5dcec81f9f14086478f9b1b4f9719b4ee0f8709b060c0562ed4a2866ec19195ced78944c67ea05158a310757dd86b5506324f0e8afd83d2e08c61c7ce3";
    $password = hash('sha512', $salt . $password);
    return $password;
}