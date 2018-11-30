<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/inc/functions.php');
/*
if ($_GET["obtained"] != NULL && $_GET[" bid"] != NULL && $_GET["uid"] != NULL && $_GET["bloc"] != NULL && $_GET["strain"] != NULL && $GET["pdate"] != NULL && $_GET["sdate"] != NULL){
*/

$postbreeder = $_GET["bid"];
$postuid = $_GET["uid"];
$poststrain = $_GET["strain"];
$postplantdate = $_GET["pdate"];

if ($_GET["checksdate"] != "notsprouted") {
$postsproutdate = $_GET["sdate"];
}
if ($_GET["checksdate"] == "notsprouted") {
$postsproutdate = 0;
}

$postwhenobtained = $_GET["odate"]; 
$roomId = 1;
$postwhereobtained = $_GET["wobtained"];
$obtaindate = strtotime($postwhenobtained);
$obtaindate = date('Y-m-d H:i:s', $obtaindate);
$plantday = strtotime($postplantdate);
$plantday = date('Y-m-d H:i:s', $plantday); 
$day1 = strtotime($postsproutdate);
$day1 = date('Y-m-d H:i:s', $day1); 


require_once ($_SERVER['DOCUMENT_ROOT'].'/inc/modules/header.php');

if ($poststrain != NULL && $postuid != NULL && $poststrain != NULL && $obtaindate != NULL && $poststrain != NULL && $plantday != NULL && $poststrain != NULL && $roomId  != NULL && $poststrain != NULL && $postwhereobtained != NULL && $postbreeder != NULL){
    if ($postsproutdate == 0) {
    $dbFcts->addPlantNotSprouted($poststrain, $postuid, $obtaindate, $plantday, $roomId, $postwhereobtained, $postbreeder, $dbh);
    echo "Added Plant!";
    }
    else {
    $dbFcts->addPlant($poststrain, $postuid, $obtaindate, $plantday, $day1, $roomId, $postwhereobtained, $postbreeder, $dbh);
    echo "Added Plant!";
    }
    }
else {
    echo "Nothing was Added";
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
        <B>Add A Plant</B>
        <br/>
                        <form action="addplant.php">
Breeder Name: <select name=" bid">
<?php
foreach($dbFcts->listBreeders($dbh) as $breeder) {
    echo '<option value="'.$breeder['id'].'">'.$breeder['breederName'].'</option>';
}

?>
</select>
<br/>

Seed Bank: <select name="wobtained">
<?php
foreach($dbFcts->getAllApprovedSeedBanks($dbh) as $banks) {
    echo '<option value="'.$banks['id'].'">'.$banks['bankName'].'</option>';
}

?>
</select>
<input type="text" name="uid" value="<?php echo $userId;?>" hidden>
<?php
/*
</br>
Strain: <input type="text" name="strain" value="">
</br>
*/
?>
</br>
Strain: <select name="strain">
<?php
foreach($dbFcts->listStrains($dbh) as $strain) {
    echo '<option value="'.$strain['id'].'">'.$strain['strainName'].'</option>';
}

?>
</select>
</br>

Plant Date: <input type="text" class="datepicker" id="datepicker" name="pdate">
</br>
Sprout Date: <input type="text" class="datepicker" id="datepicker2" name="sdate">

  <input type="checkbox" name="checksdate" value="notsprouted"> Not Yet Sprouted<br>



</br>
Obtained Date: <input type="text" class="datepicker" id="datepicker3" name="odate">
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
