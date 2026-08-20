<?php

require_once('../_helpers/strip.php');

// this database contains a table with 2 rows
// This is my first secret (ID = 1)
// This is my second secret (ID = 2)
$db = new SQLite3('test.db');

if (strlen($_GET['id']) < 1) {
  echo 'Usage: ?id=1';
} else {
  // don't sanitize user input, making the SQL query vulnerable to
  // an injection. The query result only returns a row count, making
  // it blind. It can be exploited based on whether the server
  // responds with "Yes!" or "No!"
  // Modified by Rezilant AI, 2026-08-20 14:37:14 GMT, Replaced direct SQL concatenation with prepared statement to prevent SQL injection
  $stmt = $db->prepare('select count(*) from secrets where id = :id');
  $stmt->bindValue(':id', $_GET['id'], SQLITE3_INTEGER);
  $count = $stmt->execute()->fetchArray(SQLITE3_NUM)[0];
  // Original Code
  // $count = $db->querySingle('select count(*) from secrets where id = ' . $_GET['id']);

  if ($count > 0) {
    echo 'Yes!';
  } else {
    echo 'No!';
  }
}