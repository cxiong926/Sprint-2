<?php

require_once('../classes/Template.php');
require_once("../classes/DB.class.php");
session_start();



$page = new Template('Search Results'); // Automatically sets title

$page->addHeadElement('<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>');
$page->addHeadElement('<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>');
$page->addHeadElement('<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>');

$page->addHeadElement('<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">');


$page->addHeadElement('<link href="../style/style.css" rel="stylesheet">');
$page->addHeadElement('<link rel="icon" type="image/png" href="../images/me.png">');
$page->finalizeTopSection(); // Closes head section
$page->finalizeBottomSection(); // 




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
if(isset($_SESSION['admin'])){
	print '<li class="nav-item active">';
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

	$db = new DB();

	if (!$db->getConnStatus()) {
		print "An error has occurred with connection\n";
		exit;
	}

	$query = 'SELECT * FROM survey';
	$result = $db->dbCall($query);

	if(!$result){
		print '<div class="container wrapper">';
		print '<h1 class="uw">Survey Results</h1>';

		print '<h3 class="text-center">Something went wrong.  Please try again.</h3>';
		print '<div class="col text-center">';
		print '<button type="submit" class="btn btn-primary mt-3" onclick="goBack()">Back</button>';

		print '</div>';
	}

	else {

		print '<div class="container wrapper">';
		print '<h1 class="uw">Survey Results</h1>';

		print '<table class="table table-hover">';
		print '<thead>';
		print '<tr>';
		print '<th scope="col">ID</th>';
		//print '<th scope="col">Email</th>';
		print '<th scope="col">Major</th>';
		print '<th scope="col">Expected Grade</th>';
		print '<th scope="col">Favorite Topping</th>';
		print '<th scope="col">User IP Address</th>';
		print '<th scope="col">Time Submitted</th>';
		print '</tr>';
		print '</thead>';
		print '<tbody>';

			foreach ($result as $returnedvalue){
				print '<tr>';
				print '<td>' . $returnedvalue['id'] . '</td>';
				print '<td>' . $returnedvalue['major'] . '</td>';
				print '<td>' . $returnedvalue['expectedgrade'] . '</td>';
				print '<td>' . $returnedvalue['favetopping'] . '</td>';
				print '<td>' . $returnedvalue['userip'] . '</td>';
				print '<td>' . $returnedvalue['submittime'] . '</td>';
				print '</tr>';  
			}
			
		print '</tbody>';
		print '</table>';
		
		print '<div class="col text-center">';
		print '<button type="submit" class="btn btn-primary mt-1" onclick="goBack()">New Search</button>';

		print '</div>';
		
		$result = false;
	}

	print '</div>';
}
else{
	print '<a class="nav-link" href="login.php">Login<span class="sr-only">(current)</span></a>';
	print '</nav>';
	
	print '<div class="container wrapper">';
		
		print '<h1 class="uw">Survey Results</h1><hr>';
		print '<h3 class="text-center">Access Denied</h3>';
		print "<h5 class='text-center'>You don't have permissions to view this page</h5>";
		print '<div class="pt-3 col text-center">';
		print '<a href="index.php" >Home</a>';
		print '</div>';
		print '</div>';
}

print $page->getBottomSection(); 

?>