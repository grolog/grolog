<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/inc/functions.php');
$postPId = intval(trim($_GET["plantId"]));
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
    $sprouted = $dbFcts->softDeletePlant($postPId, $dbh);
    if ($sprouted == 1) {
        echo "The soft delete date was set successfully!</br>";
    }
    if ($sprouted == 0) {
        echo "The soft delete date was already set so it was not changed. NOT UPDATED! FAILURE!";
    }
    echo "</br><a href='plantinfo.php?plantId=" . $postPId . "'> Click here to go back</a>";
    
    
}
else {
    echo "Nothing was Done, Either nothing was entered or nothing was soft deleted!";
}
 
?>
			










</br>
      <form name="logout" method="post" action="login.php">
         <input type="hidden" name="action" value="logout" />
         <input type="submit" value="Logout" />
      </form>

	  

  </body>
</html>
