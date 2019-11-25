<?php

require_once("../classes/DB.class.php");
session_start();

$db = new DB();

/*  Step 1:  Receive Data */
// takes json from input page and puts it into $rawData

$rawData= file_get_contents("php://input");
/* $data = ""; */

/*  Step 2: Check if data is there */ 
// Checks if there's anything in $rawData
if (is_null($rawData) || empty($rawData)) {
	print "No input detected";
	exit;
	}

/*  Step 3:  Execute json_decode()  */
// decodes json into an array called $input
$input = json_decode($rawData);
//$input = $rawData;

/*  Step 4:  Check for property.   */
// checks $input array for username and password values.
if (!property_exists($input,"name") || !property_exists($input,"pw")) {
  print json_encode(array("result" => array("ErrorMessage" => "Incorrect username or password")));
  exit;
}

/*  Step 5:  Retrieve data. */
// validate/sanitize data
$userName = $input->name;;
$safeUserName = $db->dbEsc($userName);
$safeUserName = filter_var($safeUserName, FILTER_SANITIZE_STRING);

$password = $input->pw;;
$safePassword = $db->dbEsc($password);
$safePassword = filter_var($safePassword, FILTER_SANITIZE_STRING);



/*  Step 6:  Create output.  
	use empty()?
	query to authenticate credentials and get username/role
	sets username/role if verified, sets $loginError to true if not verified.*/
if(isset($safeUserName) && isset($safePassword)){
	
	if (!$db->getConnStatus()) {
		print json_encode(array("result" => array("ErrorMessage" => "An error occured with the connection")));
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

		$data = array("name" => $realName, "role" => $userRole);
		
		print json_encode($data);
		
		}
		else{
			$error = array("ErrorMessage" => "Incorrect username or password");
			print json_encode($error);

	} 
	
}




