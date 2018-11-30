<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/inc/functions.php');
$postPId = intval(trim($_GET["plantId"]));
$postCId = intval(trim($_GET["commentId"]));
require_once ($_SERVER['DOCUMENT_ROOT'].'/inc/modules/header.php');

?>
 

	<h1>groLog Admin Panel</h1>
	
				Welcome <b>
				<?php
					echo $caretakerName;
				?></b>!
			<br/>

<?php
if ($postPId != NULL && $dbh != NULL){
    $deleted = $dbFcts->softDeleteplantComment($postCId, $postPId, $dbh);
    if ($deleted == 1) {
        echo "The soft delete comment was set successfully!</br>";
    }
    if ($deleted == 0) {
        echo "The soft delete comment was already set so it was not changed. NOT UPDATED! FAILURE!";
    }
    
    
}
else {
    echo "Nothing was Done, Either nothing was entered or nothing was soft deleted!";
}
     echo "</br><a href='plantinfo.php?plantId=" . $postPId . "'> Click here to go back</a>";

?>
			










</br>
      <form name="logout" method="post" action="login.php">
         <input type="hidden" name="action" value="logout" />
         <input type="submit" value="Logout" />
      </form>

	  

  </body>
</html>
