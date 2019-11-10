<?php
require_once("DB.class.php");

$db = new DB();

if (!$db->getConnStatus()) {
  print "An error has occurred with connection\n";
  exit;
}

$username = trim($_POST["search"]);

$query = 'SELECT userpass FROM user WHERE (username = "'.$username.'")';
$result = $db->dbCall($query);
var_dump($result);

$password = 'testypassword';

foreach($result as $returnedvalue)
{
	$userpassword = $returnedvalue['userpass'];
}
 

if(password_verify($password,$userpassword)){
		echo "Password verified";
	}
	else{
		echo "Wrong Password";
}

?>