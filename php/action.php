<?php

require_once('../classes/Template.php');
require_once("../classes/DB.class.php");
session_start();

$db = new DB();

// Error message if anything is invalid
$errorMsg = "";

//Regular and safe vars.  $tempMajor is used for sanitizing in the foreach loop
$id = "";
$ip = "";

$safeId = "";
$safeIp = "";

$email = "";
$major = "";
$expectedgrade = "";
$favetopping = "";

$safeEmail = "";
$safeMajor = "";
$tempMajor = "";
$safeGrade = "";
$safeTopping = "";

$page = new Template('Student Survey'); // Automatically sets title

$page->addHeadElement('<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>');
$page->addHeadElement('<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>');
$page->addHeadElement('<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>');

$page->addHeadElement('<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">');

$page->addHeadElement('<script src="../scripts/scripts.js"></script>');
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
if(isset($_SESSION['userType']) && $_SESSION['userType'] == "admin"){
	print '<li class="nav-item">';
	print '<a class="nav-link" href="surveyData.php">Survey Data<span class="sr-only">(current)</span></a>';
	print '</li>';
}
print '</ul>';				
print '</div>';
if(isset($_SESSION['userType'])){
	print '<div>Welcome, ' . $_SESSION['name'] . '!</div>';
	print '<div>';
	print '<a class="nav-link" href="logout.php">Logout<span class="sr-only">(current)</span></a>';
	print '</div>';
	print '</nav>';
}
else{
	print '<div>';
	print '<a class="nav-link" href="login.php">Login<span class="sr-only">(current)</span></a>';
	print '</div>';
	print '</nav>';
}

// Email logic.  Checks isset/!empty.  Trims/real_escape_strings/sanitizes/validates.  Creates an error if nothing entered or invalid selection
if (isset($_POST["email"]) && !empty($_POST["email"])){
	$email = trim($_POST['email']);

	$safeEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
	$safeEmail = filter_var($safeEmail, FILTER_VALIDATE_EMAIL);
	$safeEmail = $db->dbEsc($safeEmail);
	if(empty($safeEmail)){
		$errorMsg .= '<li class = "text-center list-group-item border-0">Please enter a valid email Address</li>';
		}
}
else{
	$errorMsg .= '<li class = "text-center list-group-item border-0">Email not entered</li>';
}

if (isset($_POST["major"]) && !empty($_POST["major"])){
	
	$major = $_POST['major'];
		foreach ($major as $name){ 
				$tempMajor = trim($name);
				$safeMajor .= filter_var($tempMajor, FILTER_SANITIZE_STRING) . " ";
				$safeMajor = $db->dbEsc($safeMajor);
		}
		if(empty($safeMajor)){
		$errorMsg .= '<li class = "text-center list-group-item border-0">Please select a valid topping</li>';
		}
}
else{
	$errorMsg .= '<li class = "text-center list-group-item border-0">Major(s) not selected</li>';
}

// Grade logic.  Checks isset/!empty.  Trims/real_escape_strings/sanitizes.  Creates an error if nothing selected or invalid selection
if (isset($_POST["grade"]) && !empty($_POST["grade"])){
	$expectedgrade = trim($_POST["grade"]);
	$safeGrade = filter_var($expectedgrade, FILTER_SANITIZE_STRING);
	$safeGrade = $db->dbEsc($safeGrade);
	if(empty($safeGrade)){
		$errorMsg .= '<li class = "text-center list-group-item border-0">Please select a valid expected grade</li>';
	}
}
else{
	$errorMsg .= '<li class = "text-center list-group-item border-0">Expected grade not selected</li>';
}

// Topping logic.  Checks isset/!empty.  Trims/real_escape_strings/sanitizes.  Creates an error if nothing selected or invalid selection
if (isset($_POST["topping"]) && !empty($_POST["topping"])){
	$favetopping = trim($_POST["topping"]);
	$safeTopping = filter_var($favetopping, FILTER_SANITIZE_STRING);
	$safeTopping = $db->dbEsc($safeTopping);
	if(empty($safeTopping)){
		$errorMsg .= '<li class = "text-center list-group-item border-0">Please select a valid topping</li>';
	}
}
else{
	$errorMsg .= '<li class = "text-center list-group-item border-0">Favorite topping not selected</li>';
}

if(!empty($_SERVER['HTTP_CLIENT_IP']))
{
	$ip = $_SERVER['HTTP_CLIENT_IP'];
}
else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
{
	$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
}
else
{
	$ip = $_SERVER['REMOTE_ADDR'];
}

if (isset($ip) && !empty($ip)){
	$ip = trim($ip);
	$safeIp = filter_var($ip, FILTER_SANITIZE_STRING);
	$safeIp = $db->dbEsc($safeIp);
	if(empty($safeIp)){
		$safeIp = "NA";
		$errorMsg .= '<li class = "text-center list-group-item border-0">There was an error with your IP address</li>';
	}
}
else{
	$errorMsg .= '<li class = "text-center list-group-item border-0">There was an error with your IP address</li>';
}
$safeId = "NA";

// Displays a message if $errorMsg is > 0
if (strlen($errorMsg) > 0){
	print '<div class="container wrapper">';
	print '<h1 class="uw">Student Survey</h1><hr>';

	print '<div class="border rounded col-md-10 mx-auto px-4 pb-3">';
	print '<h2 class="mt-3 text-center">The following errors were found</h2>';
	print '<ul class="list-group list-group-flush">';
	print $errorMsg;
	print '</ul>';
	print '<div class="col text-center">';
	print '<button type="submit" class="btn btn-primary mt-3" onclick="goBack()">Back</button>';

	print '</div>';
	print '</div>';


	print '</div>';
}
else{
print '<div class="container wrapper">';
print '<h1 class="uw">Student Survey</h1><hr>';
print '<h2 class="text-center mt-4">Thank you for participating!</h2><br>';
print '<div class="text-center"><a href="survey.php">Take another survey</a></div>';

print '</div>';

$db = new DB();

if (!$db->getConnStatus()) {
  print "An error has occurred with connection\n";
  exit;
}

$query = 'INSERT INTO survey VALUES (0, now(), "'.$safeMajor.'", "'.$safeGrade.'", "'.$safeTopping.'", "'.$safeIp.'", "'.$safeId.'" )';
$db->dbCall($query);

}




print $page->getBottomSection(); // closes the html

?>