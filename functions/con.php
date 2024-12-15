<?php

function set_con($level)
{
  $db_server = 'localhost';

  switch ($level) {
    case 0:
      //! User for anonymous actions
      $db_name = 'NordLib';
      $db_user = 'anonymous_librarian';
      $db_password = 'secret0';
      break;
    case 1:
      //! User for users actions
      $db_name = 'NordLib';
      $db_user = 'user_librarian';
      $db_password = 'secret1';
      break;
    case 2:
      //! User for admin actions
      $db_name = 'NordLib';
      $db_user = 'admin_librarian';
      $db_password = 'secret2';
      break;
    case 3:
      //! User for registration and loging
      $db_name = 'NordLib';
      $db_user = 'mr_register';
      $db_password = 'secret3';
      break;
    case 4:
      //! User for stats
      $db_name = 'NordLib';
      $db_user = 'mr_statistic';
      $db_password = 'secret4';
      break;
    case 5:
      //! User for checking is database installed
      $db_name = '';
      $db_user = 'root';
      $db_password = '';
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
  } catch (mysqli_sql_exception $wyj) {
    $wyj_wiadomosc = $wyj->getMessage();
    $wyj_numer = $wyj->getCode();
    echo "<p>Wyjatek info: $wyj_wiadomosc | numer: $wyj_numer</p>";
    die('Blad polaczenia z serwerem baz danych. Koniec aplikacji.');
  }
}

function query_db($q, $level = 0)
{
  $db = set_con($level);
  $result = $db->query($q);
  return $result;
}