<?php

require_once('../classes/Template.php');
require_once("../classes/DB.class.php");
session_start();



$page = new Template('Find an Album'); // Automatically sets title

$page->addHeadElement('<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>');
$page->addHeadElement('<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>');
$page->addHeadElement('<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">');

$page->addHeadElement('<link href="../style/style.css" rel="stylesheet">');
$page->addHeadElement('<script src="../scripts/scripts.js"></script>');

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
print '<li class="nav-item">';
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
print '</ul>';				
print '</div>';

if(isset($_SESSION['userType'])){
	unset($_SESSION['userType']);
	unset($_SESSION['name']);
	session_destroy();
	
	if(!isset($_SESSION['userType'])){
		print '<div>';
		print '<a class="nav-link" href="login.php">Login<span class="sr-only">(current)</span></a>';
		print '</div>';

		print '</nav>';
		
		print '<div class="container wrapper">';
		print '<h1 class="uw">Logout</h1><hr>';
		

		print '<div class="py-4 border rounded col-md-6 mx-auto px-4" action="home.php">';
		print '<h3 class="text-center">Logged Out</h3>';
		print '<p class="text-center">You have been successfully logged out!</p>';
		print '<div class="col text-center">';
		print '<a href="index.php" >Home</a>';
		print '</div>';
		print '</div>';

		print '</div>';
	}else{
		print '<div>';
		print '<a class="nav-link" href="login.php">Login<span class="sr-only">(current)</span></a>';
		print '</div>';
		print '</nav>';
		
		print '<div class="container wrapper">';
		print '<h1 class="uw">Oops! Something went wrong!</h1><hr>';
		print '<p class="text-center">Please try again!</p>';

		print '<form class=" border rounded col-md-6 mx-auto px-4" method="POST" action="logout.php">';
		
		print '<form action="logout.php">';
		print '<button type="submit" name="submit" class="mt-2 btn btn-primary mx-auto">Try again</button>';
		print '</form>';
	}
}else{
	print '<div>';
		print '<a class="nav-link" href="login.php">Login<span class="sr-only">(current)</span></a>';
		print '</div>';
		print '</nav>';
		
		print '<div class="container wrapper">';
		print '<h1 class="uw">Oops! Something went wrong!</h1><hr>';
		print "<p class='text-center'>Can't log out if you aren't logged in!</p>";

		print '<div class="text-center"><a href="index.php">Home</a></div>';
		print '</div>';
}

	

print $page->getBottomSection(); // closes the html

?>