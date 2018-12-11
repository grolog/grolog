<?php
 
require_once ($_SERVER['DOCUMENT_ROOT'].'/inc/functions.php');

$postcompany = $_GET["ncomp"];
$postuid = $_GET["uid"];
$postname = $_GET["nname"];
$postn = $_GET["nn"];
$postp = $_GET["np"];
$postk = $_GET["nk"];
$postca = $_GET["nca"];
$postmg = $_GET["nmg"];
$posts = $_GET["ns"];
$postfe = $_GET["nfe"];
$postmn = $_GET["nmn"];
$postmo = $_GET["nmo"];
$postaz = $_GET["naz"];
$postmy = $_GET["nmy"];
$postconsistency = $_GET["ncon"];
$nuteadd = $_GET["nadd"];
 
 
 var_dump($_GET);
 
require_once ($_SERVER['DOCUMENT_ROOT'].'/inc/modules/header.php');

if ($postcompany != NULL && $postuid != NULL && $postname != NULL && $postn != NULL && $postp != NULL && $postk != NULL && $postca != NULL && $postmg != NULL && $posts != NULL && $postfe != NULL && $postmn != NULL && $postmo != NULL && $postaz != NULL && $postmy != NULL && $postconsistency != NULL && $dbh != NULL){
   
    
    $dbFcts->addNewNutrient($postcompany, $postname, $postn, $postp, $postk, $postca, $postmg, $posts, $postfe, $postmn, $postmo, $postaz, $postmy, $postconsistency, $nuteadd, $postuid, $dbh);
    echo "Added nutrient!";
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
        <B>Add Nutrient</B>
        <br/>
                        <form action="addnutrient.php">
<input type="text" name="uid" value="<?php echo $userId;?>" hidden>

Nutrient Name: <input type="text" name="nname"><br>
<br/>
Nutrient Company: 
<select name="ncomp">
				<?php
				/* parse through all actions so user sees what has happened */
				$i = 0;
				foreach ($allnutrientcompanies as $nutrientcompanies){
                                                                                    if ($nutrientcompanies["softDeleted"] == "N") { 

                
				?>


	<option value="<?php echo $nutrientcompanies["id"]; ?>"><?php echo $nutrientcompanies["companyName"];?></option>
<?php 
                                    }
                                                                                    }
                                    
?>
</select>
<br/>

Nitrogen Percentage (N): <input type="number" name="nn" min="0" max="100" step="0.00001">
<br/>
Phosphorus Percentage (P): <input type="number" name="np" min="0" max="100" step="0.00001">
<br/>
Potassium Percentage (K): <input type="number" name="nk" min="0" max="100" step="0.00001">
<br/>
Calcium Percentage (Ca): <input type="number" name="nca" min="0" max="100" step="0.00001">
<br/>
Magnesium Percentage (Mg): <input type="number" name="nmg" min="0" max="100" step="0.00001">
<br/>
Sulfur Percentage (S): <input type="number" name="ns" min="0" max="100" step="0.00001">
<br/>
Iron Percentage (Fe): <input type="number" name="nfe" min="0" max="100" step="0.00001">
<br/>
Manganese Percentage (Mn): <input type="number" name="nmn" min="0" max="100" step="0.00001">
<br/>
Molybdenum Percentage (Mo): <input type="number" name="nmo" min="0" max="100" step="0.00001">
<br/>
Azomite Percentage: <input type="number" name="naz" min="0" max="100" step="0.00001">
<br/>
Mycorrhizae Percentage: <input type="number" name="nmy" min="0" max="100" step="0.00001">
<br/>
</br>
Nutrient Consistency: <select name="ncon">
	<option value="L">Liquid</option>
	<option value="S">Solid</option>
	<option value="O">Other</option>
</select>
<br/>
Additional Notes: <input type="text" name="nadd">
<br/>
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
