<?php
/*
//Password for Testy McTesterson
$pass1 = "testypassword";

$pass1hash = password_hash($pass1, PASSWORD_BCRYPT);

PRINT "Hash for 'testypassword':  \r\n";
PRINT $pass1hash . PHP_EOL;

//Password for Dade Murphy
$pass2 = "dadepassword";

$pass2hash = password_hash($pass2, PASSWORD_BCRYPT);

PRINT "Hash for 'dadepassword':  \r\n";
PRINT $pass2hash . PHP_EOL;

//Password for David Lightman
$pass3 = "davidpassword";

$pass3hash = password_hash($pass3, PASSWORD_BCRYPT);

PRINT "Hash for 'davidpassword':  \r\n";
PRINT $pass3hash . PHP_EOL;

//Password for Martin Bishop
$pass4 = "martinpassword";

$pass4hash = password_hash($pass4, PASSWORD_BCRYPT);

PRINT "Hash for 'martinpassword':  \r\n";
PRINT $pass4hash . PHP_EOL;
*/

require_once("DB.class.php");

$db = new DB();

if (!$db->getConnStatus()) {
  print "An error has occurred with connection\n";
  exit;
}

$username = 'Testy@example.com';

$query = 'SELECT userpass FROM user WHERE (username = "'.$username.'")';
$result = $db->dbCall($query);
var_dump($result);


?>