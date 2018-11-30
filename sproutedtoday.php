<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/inc/functions.php');
$postPId = intval(trim($_GET["plantId"]));
$postUId = intval(trim($_GET["userId"]));
require_once ($_SERVER['DOCUMENT_ROOT'].'/inc/modules/header.php');
var_dump($postUId);
?>
 

	<h1>groLog Admin Panel</h1>
	
				Welcome <b>
				<?php
					echo $caretakerName;
				?></b>!
			<br/>

<?php
if ($postPId != NULL && $postUId != NULL && $dbh != NULL){
    $sprouted = $dbFcts->setSproutedToday($postPId, $dbh);
    $sproutedComment = $dbFcts->setSproutedTodayAutoComment($postPId, $postUId, $dbh);
    if ($sprouted == 1 && $sproutedComment == 1) {
        echo "The sprout date and sprout comment set successfully!</br>";
    }
    if ($sprouted == 1 && $sproutedComment == 0) {
        echo "ERROR! The sprout date was set but not the comment.";
    }
    if ($sprouted == 0 && $sproutedComment == 1) {
        echo "ERROR! The sprout comment was made but the sprout date was not set.";
    }    
    if ($sprouted == 0 && $sproutedComment == 0) {
        echo "The Sprout date was already set so it was not changed. NOT UPDATED! FAILURE!";
    }
    echo "</br><a href='plantinfo.php?plantId=" . $postPId . "'> Click here to go back</a>";
    
    
}
else {
    echo "Nothing was Done, Either nothing was entered or nothing was sprouted!";
}
 
?>
			










</br>
      <form name="logout" method="post" action="login.php">
         <input type="hidden" name="action" value="logout" />
         <input type="submit" value="Logout" />
      </form>

	  

  </body>
</html>
