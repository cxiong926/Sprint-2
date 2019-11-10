<?php

require_once('../classes/Template.php');
require_once("../classes/DB.class.php");
session_start();


// do stuff here

$db = new DB();


// Need a usertype return from query
/*
if(isset($_POST["username"]) && isset($_POST["username"])){
	$username = trim($_POST["username"]);
	$safeusername = $db->dbEsc($username);
	$safeusername = filter_var($safeusername, FILTER_SANITIZE_STRING);
	
	$password = trim($_POST["password"]);
	$safePassword = $db->dbEsc($password);
	$safePassword = filter_var($safePassword, FILTER_SANITIZE_STRING);

	if (!$db->getConnStatus()) {
		print "An error has occurred with connection\n";
	exit;
	}

	$query = 'SELECT userpass FROM user WHERE (username = "'.$username.'")';
	$result = $db->dbCall($query);

	$password = trim($_POST["password"]);

	foreach($result as $returnedvalue)
	{
		$userpassword = $returnedvalue['userpass'];
		// Need return value here for user or admin
	}
	 

	if(password_verify($password,$userpassword)){
			echo "Password verified";
			$_SESSION['name'] = $safeusername;
			// Need return value here for user or admin
			//$_SESSION['usertype'] = $;
		}
		else{
			print '<p>Incorrect Username or Password</p>';
	} 
	//$_SESSION['admin'] = "admin";
	//$_SESSION['name'] = $username;
}*/







// This lets anyone log in without a pw to be an admin.  FOR TESTING ONLY.  DELETE THIS BEFORE FINAL SUBMISSION.
if(isset($_POST["username"])){
	$username = trim($_POST["username"]);
	/* $password = trim($_POST["password"]);

	$query = 'SELECT userpass FROM user WHERE (username = "'.$username.'")';
	$result = $db->dbCall($query);

	$password = trim($_POST["password"]);

	foreach($result as $returnedvalue)
	{
		$userpassword = $returnedvalue['userpass'];
	}
	 

	if(password_verify($password,$userpassword)){
			echo "Password verified";
		}
		else{
			echo "Wrong Password";
	} */
	$_SESSION['admin'] = "admin";
	$_SESSION['name'] = $username;
}







$page = new Template('Home'); // Automatically sets title

$page->addHeadElement('<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>');
$page->addHeadElement('<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>');
$page->addHeadElement('<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>');

$page->addHeadElement('<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">');

$page->addHeadElement('<link href="../style/style.css" rel="stylesheet">');

$page->addHeadElement('<link rel="icon" type="image/png" href="../images/me.png">');
$page->finalizeTopSection(); // Closes head section
$page->finalizeBottomSection();

print $page->getTopSection();
print '<nav class="navbar navbar-expand-lg navbar-light bg-light mb-5">';
print '<span class="navbar-brand mb-0 h1">Sprint 2</span>';
print '<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">';
print '<span class="navbar-toggler-icon"></span>';
print '</button>';
print '<div class="collapse navbar-collapse" id="navbarSupportedContent">';
print '<ul class="navbar-nav mr-auto">';
print '<li class="nav-item active">';
print '<a class="nav-link" href="index.php">Home</a>';
print '</li>';
print '<li class="nav-item">';
print '<a class="nav-link" href="survey.php">Survey</a>';
print '</li>';
print '<li class="nav-item">';
print '<a class="nav-link" href="search.php">Find an Album<span class="sr-only">(current)</span></a>';
print '</li>';
print '<li class="nav-item">';
print '<a class="nav-link" href="privacy.php">Privacy Policy<span class="sr-only">(current)</span></a>';
print '</li>';
if(isset($_SESSION['admin'])){
	print '<li class="nav-item">';
	print '<a class="nav-link" href="surveyData.php">Survey Data<span class="sr-only">(current)</span></a>';
	print '</li>';
}
print '</ul>';
print '</div>';



if(isset($_SESSION['admin'])){
	print '<div>Welcome, ' . $_SESSION['name'] . '!</div>';
	print '<div>';
	print '<a class="nav-link" href="logout.php">Logout<span class="sr-only">(current)</span></a>';
	print '</div>';
	print '</nav>';
	
	print '<div class="container mb-5">';

	print '<h1 class="uw">Home</h1><hr>';
	print '<h2><a class="p-0" href="surveyData.php">User Survey Data (Admin)</a></h2>';
	print '<p>View survey data from users</p><hr>';
	
	print '<h2><a class="p-0" href="search.php">Search Albums</a></h2>';
	print '<p>Use our album search tool to find and purchase your favorite albums.</p><hr>';
	
	print '<h2><a class="p-0" href="survey.php">User Survey</a></h2>';
	print '<p>Participate in our survey so we can learn more about users like you.</p><hr>';
	
	print '</div>';

}
else{
	print '<div>';
	print '<a class="nav-link" href="login.php">Login<span class="sr-only">(current)</span></a>';
	print '</div>';
	print '</nav>';
	
	print '<div class="container mb-5">';
	
	print '<h1 class="uw">Home</h1><hr>';
	print '<h2><a class="p-0" href="search.php">Search Albums</a></h2>';
	print '<p>Use our album search tool to find and purchase your favorite albums.</p><hr>';
	
	print '<h2><a class="p-0" href="survey.php">User Survey</a></h2>';
	print '<p>Participate in our survey so we can learn more about users like you.</p><hr>';
	
	print '</div>';
}



print $page->getBottomSection(); // closes the html

?>