<?php

require_once('../classes/Template.php');
require_once("../classes/DB.class.php");
session_start();

$db = new DB();
$loginError = false;

if(isset($_POST["userName"]) && isset($_POST["userName"])){
	$userName = trim($_POST["userName"]);
	$safeUserName = $db->dbEsc($userName);
	$safeUserName = filter_var($safeUserName, FILTER_SANITIZE_STRING);
	
	$password = trim($_POST["password"]);
	$safePassword = $db->dbEsc($password);
	$safePassword = filter_var($safePassword, FILTER_SANITIZE_STRING);

	if (!$db->getConnStatus()) {
		print "An error has occurred with connection\n";
	exit;
	}

	$query = 'SELECT realname, userpass, rolename FROM user, user2role, role WHERE user.id = user2role.userid AND user2role.roleid = role.id AND (username = "'.$safeUserName.'")';
	
	$result = $db->dbCall($query);
	
	$userRole = "";
	$userPassword = "";
	
	foreach($result as $returnedValue)
	{
		$realName = $returnedValue['realname'];
		$userPassword = $returnedValue['userpass'];
        if ($userRole != "admin")
        {
            $userRole = $returnedValue['rolename'];
        }
	}

	if(password_verify($safePassword,$userPassword)){
			$_SESSION['name'] = $realName;
			$_SESSION['userType'] = $userRole;
		}
		else{
			$loginError = true;
	} 
}

$page = new Template('Home'); // Automatically sets title

$page->addHeadElement('<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>');
$page->addHeadElement('<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>');
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

if($loginError == false){

	if(isset($_SESSION['name'])){
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
}
else{
	
	print '</nav>';
	print '<div class="container wrapper">';
	print '<h1 class="uw">Login</h1><hr>';

	print '<div class="border rounded col-md-10 mx-auto px-4 pb-3">';
	print '<h2 class="mt-3 text-center">Incorrect username or password</h2>';
	print '<h3 class="mt-3 text-center">Please try again</h3>';
	print '<div class="col text-center">';
	print '<button type="submit" class="btn btn-primary mt-3" onclick="goBack()">Back</button>';

	print '</div>';
	print '</div>';


	print '</div>';
}


print $page->getBottomSection(); // closes the html

?>