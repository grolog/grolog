<?php
/*
grolog header for everything
*/
// Turn off all error reporting
//error_reporting(0);

checkLoggedIn (Page::INDEX);

 /* start database helper files to get us going for registration */
 $dbFcts = new DatabaseHelpers();
 $dbh = $dbFcts->getDatabaseConnection();

 /* user info grabbing here */
 $userId      = $_COOKIE['GRO']['userID'];
 $userInfo    = $dbFcts->getUserInfoFromId($userId, $dbh);
 $username    = $userInfo["0"]["username"];
 $lastActions = $dbFcts->getLastActions($username, $dbh);
 $apiKey      = $userInfo[0]["apikey"];
 $apiKeyCode  = $userInfo[0]["apikeycode"];
 $userAdmin   = $userInfo[0]["admin"];

 
 $caretakerUserInfo = $dbFcts->getCaretakerNameFromUserId($userId, $dbh);
 $allPlants   = $dbFcts->getAllPlants($dbh);
 $alivePlants = $dbFcts->getAlivePlants($dbh);
 $harvestedPlants = $dbFcts->getHarvestedPlants($dbh);
 $allbreeders = $dbFcts->listBreeders($dbh);
 $allbanks = $dbFcts->getAllSeedBanks($dbh);
 $allstrains = $dbFcts->listStrains($dbh);
 
 
 $caretakerName = $caretakerUserInfo[0]["firstName"] . " " . $caretakerUserInfo[0]["lastName"];
 


?>