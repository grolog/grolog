<?php
include('/home/lasdvgt/intersango/htdocs/inc/config.php');
include('/home/lasdvgt/intersango/htdocs/inc/classes/databasehelpers.php');
include('/home/lasdvgt/intersango/htdocs/inc/functions.php');
				/* start database helper files to get us going for registration */
				$dbFcts = new DatabaseHelpers();
				$dbh = $dbFcts->getDatabaseConnection();


        $stmt = $dbh->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
        $stmt->execute(array("4"));
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $userEmail = $results[0]['email'];
        $username  = $results[0]["username"];

//var_dump($results);
//echo $userEmail;

$dbFcts->sendEmailLoginSuccess("4", "anaddress", $dbh);
