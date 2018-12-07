<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/inc/functions.php');
$postPId = trim($_GET["plantId"]);
$postWetUntrimmed = trim($_GET["wetUntrimmed"]);
$postWetTrimmed = trim($_GET["wetTrimmed"]);
$postUId = trim($_GET["uid"]);
$postHarvestPlant = trim($_GET["harvestPlant"]);
$postWetUseless = trim($_GET["wetUseless"]);
$postWetSugar = trim($_GET["wetSugar"]);
$postToProcess = trim($_GET["toProcess"]);
$postProcessType = trim($_GET["processType"]);
$now = date('Y-m-d H:i:s');

//var_dump($_GET);


require_once ($_SERVER['DOCUMENT_ROOT'].'/inc/modules/header.php');


if ($postPId != NULL && $postUId != NULL && $postHarvestPlant != NULL) {
        $dbFcts->harvestPlantWet($postPId, $postUId, $postWetUntrimmed, $postWetTrimmed, $postWetUseless, $postWetSugar, $postToProcess, $postProcessType, $dbh);
        $dbFcts->setHarvestPlantsTable($postPId, $postUId, $dbh);
        echo "Plant Harvested!";
        
}    
else {
    echo "Nothing was Harvested";
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
        <H2>Harvest Plant</H2>
        <br/>
       
                        <form action="harvestplant.php" type="GET">
<b>Wet Weights
</b>
</br>
Wet Weight Untrimmed (Whole Plant) (Grams)<input type="text" name="wetUntrimmed">
<br/>
Wet Weight Buds Trimmed (Grams): <input type="text" name="wetTrimmed">
<input type="text" name="uid" value="<?php echo $userId;?>" hidden>
<input type="text" name="plantId" value="<?php echo $postPId;?>" hidden>
<input type="text" name="harvestPlant" value="Y" hidden>

</br>
Wet Weight Unusable Trim AND Stems (Grams) <input type="text" name="wetUseless">
</br>
Wet Weight Sugar/Usable Trim (Grams) <input type="text" name="wetSugar">
</br>

Will It Be Processed: <select name="toProcess">
    <option value="Y">Yes</option>
    <option value="N">No</option>
</select>
</br>
Process Type: <select name="processType">
<option value="0">No Processing</option>
<option value="1">Bubble Hash/Hash</option>
<option value="2">Shift</option>
<option value="3">Oil (Unspecified)</option>
<option value="4">Budder</option>
<option value="5">Suger</option>
<option value="6">Wax</option>
<option value="7">Honey</option>
<option value="8">Other</option>


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
