<?php
 
require_once ($_SERVER['DOCUMENT_ROOT'].'/inc/classes/databasehelpers.php');
require_once ($_SERVER['DOCUMENT_ROOT'].'/inc/classes/userdata.php');
 
class Users
{
   public function checkCredentials($username, $password)
   {
      // A UserID of 0 from the database indicates that the username/password pair
      // could not be found in the database
      $userID = 0;
      $digest = '';
 
      try
      {
         $dbh = DatabaseHelpers::getDatabaseConnection();
 
         // Build a prepared statement that looks for a row containing the given
         // username/password pair
         $stmt = $dbh->prepare('SELECT id, password FROM users WHERE ' .
                               'username=:username ' .
                               'LIMIT 1');
 
         $stmt->bindParam(':username', $username, PDO::PARAM_STR);
 
         $success = $stmt->execute();
 
         // If results were returned from executing the MySQL command, we
         // have found the user
         if ($success)
         {
            // Ensure provided password matches stored hash
            $userData = $stmt->fetch();
            $digest = $userData['password'];
            if (crypt ($password, $digest) == $digest)
            {
               $userID = $userData['id'];
            }
         }
 
         $dbh = null;
      }
      catch (PDOException $e)
      {
         $userID = 0;
         $digest = '';
      }
 
      return array ($userID, $username, $digest);
   }
}
 
?>
