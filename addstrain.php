<?php
 
require_once ($_SERVER['DOCUMENT_ROOT'].'/inc/functions.php');

$postbreeder = $_GET["sbreed"];
$postuid = $_GET["uid"];
//$postcount = $_GET["bname"];
$poststrain = $_GET["sname"];
$posttype = $_GET["stype"];
$postssativa = $_GET["ssativa"];
$postsindica = $_GET["sindica"];
$postsruderalis = $_GET["srudy"];
$postswebsite = $_GET["swebsite"];
$postdescription = $_GET["sdescription"];
$postsbank = $_GET["sbank"]; 
 
require_once ($_SERVER['DOCUMENT_ROOT'].'/inc/modules/header.php');

if ($postbreeder != NULL && $poststrain != NULL && $posttype != NULL && $postssativa != NULL && $postsindica != NULL && $postsruderalis != NULL && $postswebsite != NULL && $postdescription != NULL && $postsbank != NULL && $dbh != NULL){
$input = $postswebsite;
// in case scheme relative URI is passed, e.g., //www.google.com/
$input = trim($input, '/');
// If scheme not included, prepend it
if (!preg_match('#^http(s)?://#', $input)) {
    $input = 'http://' . $input;
}
$urlParts = parse_url($input);
// remove www
$domain = preg_replace('/^www\./', '', $urlParts['host']);
$postswebsite = $domain;    
    
    $dbFcts->addStrain($postbreeder, $poststrain, $posttype, $postssativa, $postsindica, $postsruderalis, $postswebsite, $postdescription, $postsbank, $dbh);
    echo "Added Strain!";
}
else {
    echo "Nothing was Added";

}
?>
 
<html>
   <body>
	<h1>groLog Admin Panel</h1>
	
				Welcome <b>
				<?php
					echo $caretakerName;
				?></b>!
			<br/>
        <B>Add Strain</B>
        <br/>
                        <form action="addstrain.php">
Strain Name: <input type="text" name="sname"><br>
Strain Type: <select name="stype">
	<option value="2">Autoflower - Feminized</option>
	<option value="4">Autoflower - Regular</option>
	<option value="1">Photoperiod - Feminized</option>
  	<option value="3">Photoperiod - Regular</option>
	<option value="5">Ruderalis - All</option>
	<option value="6">Other</option>
</select>
<br/>
Sativa Percentage: <input type="number" name="ssativa" min="0" max="100">
<br/>
Indica Percentage: <input type="number" name="sindica" min="0" max="100">
<br/>
Ruderalis Percentage: <input type="number" name="srudy" min="0" max="100">
<input type="text" name="uid" value="<?php echo $userId;?>" hidden>
<br/>
Seed Bank Plant Obtained:
<select name="sbank">
				<?php
				/* parse through all actions so user sees what has happened */
				$i = 0;
				foreach ($allbanks as $bank){
				?>
							<?php
                                /*Finds the seedbank or person or place you obtained the seeds or clones */
                                    if ($bank["softDeleted"] == "N") {


?>
	<option value="<?php echo $bank["id"]; ?>"><?php echo $bank["bankName"];?></option>
<?php 
                                    }
                }
?>
</select></br>
Breeder: 
<select name="sbreed">
				<?php
				/* parse through all actions so user sees what has happened */
				$i = 0;
				foreach ($allbreeders as $breeder){
                                                                                    if ($breeder["softDeleted"] == "N") { 

                
				?>


	<option value="<?php echo $breeder["id"]; ?>"><?php echo $breeder["breederName"];?></option>
<?php 
                                    }
                                                                                    }
                                    
?>
</select>
</br>
Strain Website: <input type="text" name="swebsite">
</br>
Strain Description: <input type="text" name="sdescription" rows="12" cols="50" id="">
</br>


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
