<?php
 
 require_once ($_SERVER['DOCUMENT_ROOT'].'/inc/functions.php');

 /* start database helper files to get us going for registration */
 $dbFcts = new DatabaseHelpers();
 $dbh = $dbFcts->getDatabaseConnection();
 
 
 /*check if username and password was passed, throw error and return if not */
  if(empty($_POST["username"])) {
 	echo "There are issues with the username, password, and/or password chosen, please check the characters and/or try a different name";
	echo "<br/><a href='register.php'>Try Again</a>";
	exit;
  } 

  if(empty($_POST["password"])) {
 	echo "There are issues with the username, password, and/or password chosen, please check the characters and/or try a different name";
	echo "<br/><a href='register.php'>Try Again</a>";
	exit;
  }
  
  if(empty($_POST["email"])) {
 	echo "There are issues with the username, password, and/or password chosen, please check the characters and/or try a different name";
	echo "<br/><a href='register.php'>Try Again</a>";
	exit;
  }
  
  
  
 /* get required functions */
 require_once ($_SERVER['DOCUMENT_ROOT'].'/inc/functions.php');
 
 /* check if we are already logged in */
 $loginDiv = checkLoggedIn (Page::LOGIN);

 /* start database helper files to get us going for registration */
 $dbFcts = new DatabaseHelpers();
 $dbh = $dbFcts->getDatabaseConnection();

 /* Get user info from post */ 
 $username  = $_POST["username"];
 $password  = $_POST["password"];
 $email     = $_POST["email"];

 $userIp    = array_key_exists( 'REMOTE_HOST', $_SERVER) ? $_SERVER['REMOTE_HOST'] : gethostbyaddr($_SERVER["REMOTE_ADDR"]);
 
 /* extra info on user */
 
 $firstName  = $_POST["firstName"];
 $middleName = $_POST["middleName"];
 $lastName   = $_POST["lastName"];
 $house      =  intval(trim($_POST["house"]));
 $road       = $_POST["road"];
 $city       = $_POST["city"];
 $state      = $_POST["state"];
 $country    = $_POST["country"];
 $zip        =  intval(trim($_POST["zip"]));
    

 /* Check and register user */

 $checkUserNew = $dbFcts->checkUserNew($username, $dbh);


 /* if username exists give generalzied message saying we cannot complete request */
 if ($checkUserNew != 0) {
	echo "There are issues with the username and/or password chosen, please check the characters and/or try a different name";
	echo "<br/><a href='register.php'>Try Again</a>";
	exit;
  }
 
 /* encrypt user password */
 $passwordEncrypted = $dbFcts->blowfishCrypt($password, 10);

 /* insert username and password to database and pass success notice */
 $addNewUser = $dbFcts->addNewUser($username, $passwordEncrypted, $email, $dbh);

 /* Add user action to action log */
 $updateActionLog = $dbFcts->updateActionLog($username, $userIp, "register", $dbh);
 
 
 /* let us know if the user was successfully added */
 if ($addNewUser == 1 && $updateActionLog == 1 ){
    /* get userID from database so we can give free highfives to start */
    $userId = $dbFcts->checkUserId($username, $dbh);
    $userId =  intval(trim($userId[0]["id"]));
    $addNewCaretaker = $dbFcts->addNewCaretaker($firstName, $middleName, $lastName, $house, $road, $city, $state, $zip, $country, $userId, $dbh);
    if ($addNewCaretaker == 1) {
        echo $username .", Your account has been Successfully created!";
        echo "<br/> Please <a href='login.php'>login</a> to continue!";
        exit;
    }
    else {
        echo "There was an error adding the caretaker to the caretakerid table! The user was added to the users table.";
        echo "<br/><a href='register.php'>Try Again</a>";
        exit;
        } 
 }
    else {
        echo "There are issues with the username and/or password chosen, please check the characters and/or try a different name";
        echo "<br/><a href='register.php'>Try Again</a>";
        exit;
        }
 
 ?>
 
