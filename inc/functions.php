<?php

 // Turn off all error reporting
//error_reporting(0);
 /* Configure the following */



 /***************************
 * STOP! DO NOT EDIT BELOW! *
 ***************************/
 
 
 
 
require_once ($_SERVER['DOCUMENT_ROOT'].'/inc/classes/databasehelpers.php');
require_once ($_SERVER['DOCUMENT_ROOT'].'/inc/classes/users.php');
require_once ('functions.php');
require_once ('pages.php');
require_once ('config.php');
 
function isSecuredPage($page)
{
   // Return true if the given page should only be accessible to validation users
   return $page == Page::INDEX;
   return $page == Page::TRADE;
}
 
function checkLoggedIn($page)
{
   $loginDiv = '';
   $action = '';
   if (isset($_POST['action']))
   {
      $action = stripslashes ($_POST['action']);
   }
 
   session_start ();
 
   // Check if we're already logged in, and check session information against cookies
   // credentials to protect against session hijacking
				$dbFcts = new DatabaseHelpers();
				$dbh = $dbFcts->getDatabaseConnection();
   $ip = $dbFcts->get_client_ip();

   if (isset ($_COOKIE['GRO']['userID']) &&
       crypt($ip . $_SERVER['HTTP_USER_AGENT'],
             $_COOKIE['GRO']['secondDigest']) ==
       $_COOKIE['GRO']['secondDigest'] &&
       (!isset ($_COOKIE['GRO']['username']) ||
        (isset ($_COOKIE['GRO']['username']) &&
         Users::checkCredentials($_COOKIE['GRO']['username'],
                                 $_COOKIE['GRO']['digest']))))
   {
      // Regenerate the ID to prevent session fixation
      session_regenerate_id ();
 
      // Restore the session variables, if they don't exist
      if (!isset ($_SESSION['GRO']['userID']))
      {
         $_SESSION['GRO']['userID'] = $_COOKIE['GRO']['userID'];
      }
 
      // Only redirect us if we're not already on a secured page and are not
      // receiving a logout request
      if (!isSecuredPage ($page) &&
          $action != 'logout')
      {
         header ('Location: ./');
 
         exit;
      }
   }
   else
   {
      // If we're not already the login page, redirect us to the login page
      if ($page != Page::LOGIN)
      {
         header ('Location: login.php');
 
         exit;
      }
   }
 
   // If we're not already logged in, check if we're trying to login or logout
   if ($page == Page::LOGIN && $action != '')
   {
      switch ($action)
      {
         case 'login':
         {
            $userData = Users::checkCredentials (stripslashes ($_POST['login-username']),
                                                 stripslashes ($_POST['password']),
												 stripslashes ($_POST['login-authcode']));
            if ($userData[0] != 0)
            {
												$ip = $dbFcts->get_client_ip();

               $_SESSION['GRO']['userID'] = $userData[0];
               $_SESSION['GRO']['ip'] = $ip;
               $_SESSION['GRO']['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
			   
			   
			   
			   /* log actionlog login */
			   
				/* start database helper files to get us going for registration */
				$dbFcts = new DatabaseHelpers();
				$dbh = $dbFcts->getDatabaseConnection();

               // if (empty($_POST['login-authcode'])) {
					// $updateActionLog = $dbFcts->updateActionLog($_POST['login-username'], $_SESSION['GRO']['ip'], "login auth request", $dbh);
					// $dbFcts = new DatabaseHelpers();
					// $dbh = $dbFcts->getDatabaseConnection();
					// $emailLoginAuth = $dbFcts->sendEmailLoginAuth($userData[0], $_SESSION['GRO']['ip'], $dbh);
					// $loginDiv = '<div id="login-box" class="error">The auth code ' .
											// 'you entered is incorrect. A new code has been sent. A new one has been sent. <br/><a href="index.php">Go Home</a></div>';
					// echo $loginDiv;
					// exit;
				// }
				
						
									 $dbFcts = new DatabaseHelpers();
									 $dbh = $dbFcts->getDatabaseConnection();
									 $ip = $dbFcts->get_client_ip();


				 $updateActionLog = $dbFcts->updateActionLog($_POST['login-username'], $_SESSION['GRO']['ip'], "login", $dbh);

				// /* EMAIL LOGIN TO USER */
		   
			   // $dbFcts->sendEmailInvalidateEmailAuthCode($_SESSION['GRO']['userID'] , $_POST['login-authcode'], $dbh) ;

			   // $emailLoginSuccess = $dbFcts->sendEmailLoginSuccess($userData[0], $_SESSION['GRO']['ip'], $dbh);
		   
			   
// /			   
			   
			   
			   
               if (isset ($_POST['remember']))
               {
			   									$ip = $dbFcts->get_client_ip();

                  // We set a cookie if the user wants to remain logged in after the
                  // browser is closed
                  // This will leave the user logged in for 1 hour
                  setcookie('GRO[userID]', $userData[0], time () + (3600));
                  setcookie('GRO[username]',
                  $userData[1], time () + (3600));
                  setcookie('GRO[digest]', $userData[2], time () + (3600));
                  setcookie('GRO[secondDigest]',
                  DatabaseHelpers::blowfishCrypt($ip .
                                                 $_SERVER['HTTP_USER_AGENT'], 10), time () + (3600));
               }
               else
               {
                  setcookie('GRO[userID]', $userData[0], false);
                  setcookie('GRO[username]', '', false);
                  setcookie('GRO[digest]', '', false);
                  setcookie('GRO[secondDigest]',
                  DatabaseHelpers::blowfishCrypt($ip .
                                                 $_SERVER['HTTP_USER_AGENT'], 10), time () + (3600));
               }
 
								header ('Location: ./');

/* begin new code */
			   /* begin auth confirmation */
			
		/*	
			
				if ($authConfirmed == 1){

				$emailLoginSuccess = $dbFcts->sendEmailLoginSuccess($_POST['login-username'], $_SESSION['GRO']['ip'], $dbh);
				
					if (isset ($_POST['remember']))
					{
						// We set a cookie if the user wants to remain logged in after the
						// browser is closed
						// This will leave the user logged in for 1 hour
						setcookie('GRO[userID]', $userData[0], time () + (3600));
						setcookie('GRO[username]',
											   	 $userData[1], time () + (3600));
						setcookie('GRO[digest]', $userData[2], time () + (3600));
						setcookie('GRO[secondDigest]',
						DatabaseHelpers::blowfishCrypt($ip .
                                                 $_SERVER['HTTP_USER_AGENT'], 10), time () + (3600));
				}
				else
				{
					setcookie('GRO[userID]', $userData[0], false);
					setcookie('GRO[username]', '', false);
					setcookie('GRO[digest]', '', false);
					setcookie('GRO[secondDigest]',
					DatabaseHelpers::blowfishCrypt($ip .
                                                 $_SERVER['HTTP_USER_AGENT'], 10), time () + (3600));
				}
			   
					header ('Location: ./');
				}
				/* end auth confirmation */

/* end new code */
 /*
				header ('Location: ./');
*/
				exit;
            }
            else
            {
			
			
			   
				/* start database helper files to get us going for registration */
				$dbFcts = new DatabaseHelpers();
				$dbh = $dbFcts->getDatabaseConnection();
													$ip = $dbFcts->get_client_ip();

			    $updateActionLog = $dbFcts->updateActionLog($_POST['login-username'], $ip, "failed login", $dbh);
				
				$emailLoginFail = $dbFcts->sendEmailLoginFail($_POST['login-username'], $ip, $dbh);
               $loginDiv = '<div id="login-box" class="error">The username or password ' .
                           'you entered is incorrect.</div>';
            }
            break;
         }
         // Destroy the session if we received a logout or don't know the action received
         case 'logout':
         default:
         {
		 
   
            // Destroy all session and cookie variables
            $_SESSION = array ();
            setcookie('GRO[userID]', '', time () - (3600));
            setcookie('GRO[username]', '', time () - (3600));
            setcookie('GRO[digest]', '', time () - (3600));
            setcookie('GRO[secondDigest]', '', time () - (3600));
 
            // Destory the session
            session_destroy ();
 
            $loginDiv = '<div id="login-box" class="info">Thank you. Come again!</div>';
 
            break;
         }
      }
   }
 
   return $loginDiv;
}

 
 
 ?>
