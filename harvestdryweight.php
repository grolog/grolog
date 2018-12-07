<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/inc/functions.php');
$postPId = trim($_GET["plantId"]);
$postDryUntrimmed = trim($_GET["dryUntrimmed"]);
$postdryTrimmed = trim($_GET["dryTrimmed"]);
$postUId = trim($_GET["uid"]);
$postdryUseless = trim($_GET["dryUseless"]);
$postDrySugar = trim($_GET["drySugar"]);
$postProcessWeight = trim($_GET["processWeight"]);
$postUpdateDry = trim($_GET["updateDry"]);

$now = date('Y-m-d H:i:s');

//var_dump($_GET);


require_once ($_SERVER['DOCUMENT_ROOT'].'/inc/modules/header.php');


if ($postPId != NULL && $postUId != NULL && $postUpdateDry == "Y") {
        $dbFcts->harvestPlantDry($postPId, $postUId, $postDryUntrimmed, $postdryTrimmed, $postdryUseless, $postDrySugar, $postProcessWeight, $dbh);
        $dbFcts->setDryPlantsTable($postPId, $dbh);
        echo "Plant dry weights added!";
        
}    
else {
    echo "Noweights added";
}
/*
}
*/
?>
 
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( ".datepicker" ).datepicker();
    $( ".datepicker2" ).datepicker();
    $( ".datepicker3" ).datepicker();
  } );
  </script>
</head>
   <body>
	<h1>groLog Admin Panel</h1>
	
				Welcome <b>
				<?php
					echo $caretakerName;
				?></b>!
			<br/>
        <H2>Enter Dry Weights for Plant</H2>
        <br/>
       
                        <form action="harvestdryweight.php" type="GET">
<b>Wet Weights
</b>
</br>
Dry Weight Untrimmed (Whole Plant) (Grams)<input type="text" name="dryUntrimmed">
<br/>
Dry Weight Buds Trimmed (Grams): <input type="text" name="dryTrimmed">
<input type="text" name="uid" value="<?php echo $userId;?>" hidden>
<input type="text" name="plantId" value="<?php echo $postPId;?>" hidden>
<input type="text" name="updateDry" value="Y" hidden>
</br>
Dry Weight Unusable Trim AND Stems (Grams) <input type="text" name="dryUseless">
</br>
Dry Weight Sugar/Usable Trim (Grams) <input type="text" name="drySugar">
</br>
Dry Weight Sugar/Usable Trim (Grams) <input type="text" name="drySugar">
</br>
Dry Weight Processed (Grams) <input type="text" name="processWeight">
</br>

</select>
</br>
  <input type="submit" value="Submit">

</form>
                
                </br>

			
<br/>
      <form name="logout" method="post" action="login.php">
         <input type="hidden" name="action" value="logout" />
         <input type="submit" value="Logout" />
      </form>

	  

  </body>
</html>
