<?php

function set_con($level) {
  $db_server = 'localhost';
  $db_name = 'NordLib';

  switch ($level) {
    case 0:
      $db_user = 'anonymous_librarian';
      $db_password = 'secret0';
      break;
    case 1:
      $db_user = 'user_librarian';
      $db_password = 'secret1';
      break;
    case 2:
      $db_user = 'admin_librarian';
      $db_password = 'secret2';
      break;
    case 3:
      $db_user = 'mr_register';
      $db_password = 'secret3';
      break;
    case 4:
      $db_user = 'mr_statistic';
      $db_password = 'secret4';
      break;
    default:
      die('Blad polaczenia z serwerem baz danych. Koniec aplikacji.');
  }

  try {
    return $mdb = new mysqli(
              $db_server, 
              $db_user, 
              $db_password, 
              $db_name
              );
  }
  catch (mysqli_sql_exception $wyj) {
    $wyj_wiadomosc = $wyj->getMessage();
    $wyj_numer     = $wyj->getCode();
    echo "<p>Wyjatek info: $wyj_wiadomosc | numer: $wyj_numer</p>"; 
    die('Blad polaczenia z serwerem baz danych. Koniec aplikacji.');
  }
}

function query_db($level = 0, $q) {
  $db = set_con($level);
  $result = $db->query($q);
  return $result;
}