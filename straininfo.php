<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/inc/functions.php');
$postSId = intval(trim($_GET["strainId"]));
require_once ($_SERVER['DOCUMENT_ROOT'].'/inc/modules/header.php');

?>
 

	<h1>groLog Admin Panel</h1>
	
				Welcome <b>
				<?php
					echo $caretakerName;
				?></b>!
			<br/>

<?php
if ($postSId != NULL && $dbh != NULL){
    $strainAllInfo = $dbFcts->getStrainAllInfo($postSId, $dbh);
}
else {
    echo "Nothing was found (or there was an error that caused no results), try searching again!";
    die;

}
 
?>
			
</br>			











				<?php
				/* parse through all actions so user sees what has happened */
				$i = 0;
				foreach ($strainAllInfo as $strain){
				?>


                <?php
                    if ($strain["softDeleted"] == "Y") {
                        echo "<h1>Strain HAS BEEN SOFT DELETED!!!!!!!!</h1>";
                    }
                    ?>

                
                			<table>
			<tr><td>
				Strain Info
                <table border="1">
				<tr>
					<th>Strain Id</th><th>Breeder Id</th><th>Strain Name</th><th>Strain Type</th><th>Strain Sex</th><th>Sativa</th><th>Indica</th><th>Ruderalis</th><th>Strain Website</th><th>Strain Description</th><th>Where Obtained</th>
				</tr>

				<tr>
						<td>
                            <a href=" 
                                <?php 
                                    echo "straininfo.php?strainId=" . $strain["id"];
                                ?>
                            ">
                                <?php
                                    echo $strain["id"];
                                ?>
                            </a>
						</td>
						<td>
                            <a href=" 
                                <?php 
                                    echo "breederinfo.php?breederId=" . $strain["breederId"];
                                ?>
                            ">
                                <?php
                                    echo $strain["breederId"];
                                ?>
                            </a>
						</td>
						<td>
                             <a href=" 
                                <?php
                                    echo "straininfo.php?strainId=" . $strain["strainId"];
                                ?>
                             ">
                               <?php 
                                    echo $strain["strainName"];
                               ?>
                            </a>
						</td>
   						<td>
                               <?php 
                               if ($strain["strainType"] == 1) {
                                   echo "Photoperiod";
                               }
                               if ($strain["strainType"] == 2) {
                                   echo "Autoflower";
                               }
                               if ($strain["strainType"] == 3) {
                                   echo "Photoperiod";
                               }
                               if ($strain["strainType"] == 4) {
                                   echo "Autoflower";
                               }
                               if ($strain["strainType"] == 5) {
                                   echo "Ruderalis";
                               }
                               if ($strain["strainType"] == 6) {
                                   echo "Other";
                               }
                               ?>
                        </td>
   						<td>
                               <?php 
                               if ($strain["strainType"] == 1) {
                                   echo "Feminized";
                               }
                               if ($strain["strainType"] == 2) {
                                   echo "Feminized";
                               }
                               if ($strain["strainType"] == 3) {
                                   echo "Regular";
                               }
                               if ($strain["strainType"] == 4) {
                                   echo "Regular";
                               }
                               if ($strain["strainType"] == 5) {
                                   echo "Regular";
                               }
                               if ($strain["strainType"] == 6) {
                                   echo "Other";
                               }
                               ?>
                        </td>
                        <td>
<?php
echo $strain["strainSativa"];
?>
                        </td>
						<td>
<?php
                        echo $strain["strainIndica"];
                        ?>
						</td>                        
						<td>
<?php
                        echo $strain["strainRuderalis"];
                        ?>
						</td>                        

						<td>
                        <a href="
<?php
                        echo $strain["strainWebsite"];
                        ?>					
                        " target="_blank" ><?php echo $strain["strainWebsite"];?>
                        </a>
                        </td>                        
 						<td>
<?php
                        echo $strain["strainDescription"];
                        ?>						</td>

                        <td>
<?php
                        $strainBankInfo = $dbFcts->getBankObtainedPlants($strain["whereObtained"], $dbh);
                        ?>
                        <a href="http://<?php echo $strainBankInfo[0]["bankWebsite"]; ?>" target="_blank""><?php echo $strainBankInfo[0]["bankName"]; ?></a>
                        </td>

                    </tr>	
				<?php
					$i++;
					}
				?>
				</table>




</br></br>
<form action="/deletestrainsoft.php">
  <input type="text" name="strainId" value="<?php echo $postSId; ?>" hidden>
  <input type="submit" value="I CONFIRM I WANT TO SOFT DELETE THIS STRAIN ">
</form>

</br></br>





</br>
      <form name="logout" method="post" action="login.php">
         <input type="hidden" name="action" value="logout" />
         <input type="submit" value="Logout" />
      </form>

	  

  </body>
</html>
