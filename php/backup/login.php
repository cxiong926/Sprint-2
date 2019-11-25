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
print '<li class="nav-item active">';
print '<a class="nav-link" href="search.php">Find an Album<span class="sr-only">(current)</span></a>';
print '</li>';
print '<li class="nav-item">';
print '<a class="nav-link" href="privacy.php">Privacy Policy<span class="sr-only">(current)</span></a>';
print '</li>';

// User is already logged in
if(isset($_SESSION['name'])){
	print '<li class="nav-item">';
	print '<a class="nav-link" href="surveyData.php">Survey Data<span class="sr-only">(current)</span></a>';
	print '</li>';
	print '</ul>';		
	
	
	print '<div>';
	print '<a class="nav-link" href="logout.php">Logout<span class="sr-only">(current)</span></a>';
	print '</div>';
	
	print '</div>';
	print '</nav>';
	
	print '<div class="container wrapper">';
	print '<h1 class="uw">Login</h1><hr>';
	

	print '<form class="py-4 border rounded col-md-6 mx-auto px-4" action="index.php">';
	print "<h3 class='text-center'>You're already logged in!</h3>";
	print '<p class="text-center">Please visit another page</p>';
	print '<div class="col text-center">';
	print '<button type="submit" name="submit" class="mt-2 btn btn-primary">Home</button>';
	print '</div>';
	print '</form>';

	print '</div>';
}
else{
	print '</ul>';
	print '</div>';
	print '</nav>';	
	
	print '<div class="container wrapper">';
	print '<h1 class="uw">Login</h1><hr>';
	print '<p class="text-center">Please enter your username and password</p>';

	print '<form name="loginForm" onsubmit="return loginValidate()" class="border rounded col-md-6 mx-auto px-4" method="POST" action="index.php">';
	print '<img src="../images/profile.png" class="pro mt-3 py-3 mx-auto d-block" alt="Profile Picture">';
	print '<div class="mx-auto col-10 form-group row mt-0 mb-0">';
	print '<label class="col-sm-4 col-form-label">Username</label>';


	print '<input type="text" name="userName" id="username" class="form-control">';
	print '<p id="userNameError" class="mx-auto mb-0"></p>';
	print '</div>';
	

	print '<div class="mx-auto col-10 form-group row mt-0 mb-0">';
	print '<label class="col-sm-4 col-form-label">Password</label>';


	print '<input type="password" name="password" id="password" class="form-control">';
	print '<p id="passwordError" class="mx-auto mb-0"></p>';

	
	
	print '</div>';

	print '<div class="my-2 mx-auto text-center">';

	print '<button type="submit" name="submit" class="mx-auto my-2 btn btn-primary">Login</button>';
	print '</div>';
	print '</form>';
	print '</div>';
}

print $page->getBottomSection(); // closes the html

?>