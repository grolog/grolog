<?php

require_once ($_SERVER['DOCUMENT_ROOT'].'/inc/functions.php');
 
$loginDiv = checkLoggedIn (Page::LOGIN);
 
?>
 
<html>
   <body>
      <h2>Sign in</h2>
      <form name="login" method="post" action="login.php">
         <input type="hidden" name="action" value="login" />
         <label for="login-username">Username:</label><br />
         <input id="login-username" name="login-username" type="text" /><br />
         <label for="password">Password:</label><br />
         <input name="password" type="password" /><br />
         <label for="login-authcode">Auth Code:</label><br />
         <input name="login-authcode" type="text" /><br />
         <input id="remember" name="remember" type="checkbox" />
         <label for="remember">Remember me</label><br />
         <?php echo $loginDiv ?>
         <input type="submit" value="Login" />
      </form>
      <a href="register.php">REGISTER</a>

      </body>
</html>
