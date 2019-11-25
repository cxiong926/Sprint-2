<?php

require_once('../classes/Template.php');
require_once("../classes/DB.class.php");
session_start();

$db = new DB();

$page = new Template('Search Results'); // Automatically sets title

$page->addHeadElement('<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>');
$page->addHeadElement('<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>');
$page->addHeadElement('<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">');

$page->addHeadElement('<link href="../style/style.css" rel="stylesheet">');
$page->addHeadElement('<script src="../scripts/scripts.js"></script>');

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

if (isset($_POST["search"]) && !empty($_POST["search"])){
	$searchTerm = trim($_POST["search"]);
	$safeSearchTerm = filter_var($searchTerm, FILTER_SANITIZE_STRING);
	$safeSearchTerm = $db->dbEsc($searchTerm);
}
else{
	print '<div class="container wrapper">';
	print '<h1 class="uw">Search Results</h1>';

	print '<table class="table">';
	print '<thead>';
	print '<tr>';
	print '<th scope="col">ID</th>';
	print '<th scope="col">Album Artist</th>';
	print '<th scope="col">Album Title</th>';
	print '<th scope="col">Length</th>';
	print '<th scope="col">buylink</th>';
	print '</tr>';
	print '</thead>';
	print '<tbody>';
	print '</tbody>';
	print '</table>';
	
	print '<h3 class="text-center">Please enter a search term</h3>';
	print '<div class="col text-center">';
	print '<button type="submit" class="btn btn-primary mt-3" onclick="goBack()">New Search</button>';

	print '</div>';
	print '</div>';
	
	exit();
	print $page->getBottomSection(); 
	
}

$db = new DB();

if (!$db->getConnStatus()) {
  print "An error has occurred with connection\n";
  exit;
}
$query = 'SELECT * FROM album WHERE (albumtitle LIKE "'.$safeSearchTerm.'%'.'" OR albumartist LIKE "'.$safeSearchTerm.'%'.'" )';
$result = $db->dbCall($query);


if(!$result){
	print '<div class="container wrapper">';
	print '<h1 class="uw">Search Results</h1>';

	print '<table class="table">';
	print '<thead>';
	print '<tr>';
	print '<th scope="col">ID</th>';
	print '<th scope="col">Album Artist</th>';
	print '<th scope="col">Album Title</th>';
	print '<th scope="col">Buy Now</th>';
	print '</tr>';
	print '</thead>';
	print '<tbody>';
	print '</tbody>';
	print '</table>';
	
	print '<h3 class="text-center">No Results Found for "'.$safeSearchTerm.'"</h3>';
	print '<div class="col text-center">';
	print '<button type="submit" class="btn btn-primary mt-3" onclick="goBack()">New Search</button>';

	print '</div>';
}

else {

	print '<div class="container wrapper">';
	print '<h1 class="uw">Search Results</h1>';

	print '<table class="table table-hover text-center">';
	print '<thead>';
	print '<tr>';
	print '<th scope="col">ID</th>';
	print '<th scope="col">Album Artist</th>';
	print '<th scope="col">Album Title</th>';
	print '<th scope="col">Buy Now</th>';
	print '</tr>';
	print '</thead>';
	print '<tbody>';

		foreach ($result as $returnedvalue){
			print '<tr>';
			print '<td class="align-middle">' . $returnedvalue['id'] . '</td>';
			print '<td class="align-middle">' . $returnedvalue['albumartist'] . '</td>';
			print '<td class="align-middle">' . $returnedvalue['albumtitle'] . '</td>';
			print '<td class="align-middle"><a href="' . $returnedvalue['buylink'] . '" target="_blank" rel="noopener noreferrer" style="border:none;text-decoration:none"><img src="https://www.niftybuttons.com/amazon/amazon-button3.png" alt="Buy Now"></a></td>';
			print '</tr>';  
		}
		
	print '</tbody>';
	print '</table>';
	
	print '<div class="col text-center">';
	print '<h3 class="text-center">'.count($result).' results found for "'.$safeSearchTerm.'"</h3>';
	print '<button type="submit" class="btn btn-primary mt-1" onclick="goBack()">New Search</button>';

	print '</div>';
	
	$result = false;
}

print '</div>';

print $page->getBottomSection(); 

?>