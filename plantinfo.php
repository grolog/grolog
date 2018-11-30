<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/inc/functions.php');
$postPId = intval(trim($_GET["plantId"]));
$postNUpdates = $_GET["updates"];
$postGetItAll = $_GET["getItAll"];

require_once ($_SERVER['DOCUMENT_ROOT'].'/inc/modules/header.php');

?>
 

	<h1>groLog Admin Panel</h1>
	
				Welcome <b>
				<?php
					echo $caretakerName;
				?></b>!
			<br/>

<?php
if ($postPId != NULL && $dbh != NULL && $postNUpdates == NULL && $postGetItAll == NULL){
    $postNUpdates = 10;
    $plantCommentResults = $dbFcts->listLastNActiveSinglePlantUpdates($postPId, $postNUpdates, $dbh);
    $plantImageResults = $dbFcts->getPlantPhoto($postPId, $dbh);
    $howManyUpdates = "The <b>" . strval($postNUpdates) . "</b> Most Recent Updates";
    /*now we will get the info on the plant like the strain info for the listings */
    $plantInfo = $dbFcts->getIndividualPlantInfo($postPId, $dbh);
}
elseif ($postPid != NULL && $dbh != NULL && $postNUpdates != NULL && $postGetItAll == NULL) {
    $plantCommentResults = $dbFcts->listLastNActiveSinglePlantUpdates($postPId, $postNUpdates, $dbh);
    $plantImageResults = $dbFcts->getPlantPhoto($postPId, $dbh);
    $howManyUpdates = "The <b>" . strval($postNUpdates) . "</b> Most Recent Updates";
    /*now we will get the info on the plant like the strain info for the listings */
    $plantInfo = $dbFcts->getIndividualPlantInfo($postPId, $dbh);
    }
elseif ($postPid != NULL && $dbh != NULL && $postGetItAll != NULL) {
    $plantCommentResults = $dbFcts->listAllActiveSinglePlantUpdates($postPId, $dbh);
    /*now we will get the info on the plant like the strain info for the listings */
    $plantInfo = $dbFcts->getIndividualPlantInfo($postPId, $dbh);
    $plantImageResults = $dbFcts->getPlantPhoto($postPId, $dbh);
    $howManyUpdates = "<b>All</b> Updates";
}
else {
    echo "Nothing was Done, try searching again!";
    die;

}
 
?>
			
</br>			











				<?php
				/* parse through all actions so user sees what has happened */
				$i = 0;
				foreach ($plantInfo as $plants){

                    if ($plants["softDeleted"] == "Y") {
                        echo "<h1>PLANT HAS BEEN SOFT DELETED!!!!!!!!</h1>";
                    }
                    if ($plants["harvested"] == "Y") {
                        echo "<h1>PLANT HAS BEEN HARVESTED>>>>>>>></h1>";
                    }
                    if ($plants["harvested"] != "Y") {
                        ?>
                                            <a href="
                                                    <?php 
                                    echo "harvestplant.php?plantId=" . $postPId;?>">Harvest Plant</a>
                                    <?php
                    }
                    ?>

                    
                    
                    
                    
<?php
//var_dump($plantImageResults);
if ($plantImageResults[0]["photoUploaded"] == "Y" && $plantImageResults[0]["fileUploaded"] != NULL) {
    $uploadedImageFile = "/uploads/plants/" . $plantImageResults[0]['fileUploaded'];
    ?>
    <img style="width:100%" src="<?php echo $uploadedImageFile; ?>">
    <?php
}
//}
?>
                
                			<table>
			<tr><td>
				Plant Info
                <table border="1">
				<tr>
					<th>Plant Id</th><th>Strain Id</th><th>Strain Name</th><th>Room Id</th><th>Caretaker Planted</th><th>Caretaker Id</th><th>Where Plant Obtained</th><th>Breeder Info</th><th>When Obtained</th><th>When Planted</th><th>When Sprouted</th><th>Age</th>
				</tr>

				<tr>
						<td>
                            <a href=" 
                                <?php 
                                    echo "plantinfo.php?plantId=" . $plants["id"];
                                ?>
                            ">
                                <?php
                                    echo $plants["id"];
                                ?>
                            </a>
						</td>
						<td>
                            <a href=" 
                                <?php 
                                    echo "straininfo.php?strainId=" . $plants["strainId"];
                                ?>
                            ">
                                <?php
                                    echo $plants["strainId"];
                                ?>
                            </a>
						</td>
						<td>
                             <a href=" 
                                <?php
                                    echo "straininfo.php?strainId=" . $plants["strainId"];
                                ?>
                             ">
                               <?php 
                                    $strainName = $dbFcts->getStrainNameFromId($plants["strainId"], $dbh);
                                    echo $strainName[0]["strainName"];
                               ?>
                            </a>
						</td>
						<td>
							<?php
								echo $plants["roomId"];
							?>
						</td>
						<td>
							<?php
                                $caretaker = $dbFcts->getCaretakerNameFromId($plants["caretakerId"], $dbh);
								echo $caretaker[0]["firstName"] . " " . $caretaker[0]["lastName"];
							?>
						</td>
                        <td>
                            <?php
                                echo $plants["caretakerId"];
                            ?>
                        </td>
						<td>
							<?php
                                /*Finds the seedbank or person or place you obtained the seeds or clones */
                                $bankObtained = $dbFcts->getBankObtainedPlants($plants["whereObtainedId"], $dbh);
                                echo $bankObtained[0]["bankName"];
							?>
						</td>                        

						<td>
                        <?php
                        //var_dump($strainName);
                                $breeder = $dbFcts->getBreederFromPlantId($strainName[0]["breederId"], $dbh);
								echo $breeder[0]["breederName"] . "/" . $breeder[0]["breederLocation"];							?>
						</td>                        

						<td>
							<?php
								echo $plants["whenObtained"];
							?>
						</td>                        
 						<td>
							<?php
								echo $plants["whenPlanted"];
							?>
						</td>
                        <td>
                            <?php
                                echo $plants["whenSprouted"];
                            ?>
                        </td>
                        <td>
                            <?php
                                #$dateNow = new DateTime('NOW');
                                #$dateNowTime = $dateNow->format('Y-m-d H:i:s');
                                $datetime1 = new DateTime();
                                $datetime2 = new DateTime($plants["whenSprouted"]);
                                $interval = $datetime1->diff($datetime2);
                                $elapsed = $interval->format('%y years %m months %a days %h hours %i minutes %s seconds');
                                $elapsedDays = $interval->format('%a days');
                                #echo $elapsed;
                                echo $elapsedDays;
                                #echo strtotime($plants["whenPlanted"])->diff($dateNowTime)->days;
                            ?>
                        </td>

                    </tr>	
				<?php
					$i++;
					}
				?>
				</table>



<form action="/sproutedtoday.php">
  <input type="text" name="plantId" value="<?php echo $postPId; ?>" hidden>
  <input type="text" name="userId" value="<?php echo $userId; ?>" hidden>
  <input type="submit" value="I confirm the seed sprouted today">
</form>

</br></br>
<form action="/deleteplantsoft.php">
  <input type="text" name="plantId" value="<?php echo $postPId; ?>" hidden>
  <input type="submit" value="I CONFIRM I WANT TO SOFT DELETE THIS PLANT ">
</form>

</br></br>






                <?php echo $howManyUpdates; ?>
                <table border="1">
				<tr>
					<th>Id</th><th>Submission Time</th><th>Who Commented</th><th>Comment</th>
				</tr>
				<?php
				/* parse through all actions so user sees what has happened */
				$i = 0;
				foreach ($plantCommentResults as $plantComment){
				?>
				<tr>
						<td>
							<?php
								echo $plantComment["id"];
						    ?>
						</td>
						<td>
							<?php
								echo $plantComment["submissionTime"];
							?>
						</td>
						<td>
							<?php
                                $caretakerName = $dbFcts->getCaretakerNameFromUserId($plantComment["userId"], $dbh);
                                echo $caretakerName[0]["firstName"] . " " . $caretakerName[0]["lastName"];
                                echo " (" . $plantComment["userId"] . ")";
                                ?>
						</td>
                        <td>
                            <?php
                                echo $plantComment["comment"];
                            ?>
                            </br>
<form action="/deletecommentsoft.php">
  <input type="text" name="plantId" value="<?php echo $postPId; ?>" hidden>
  <input type="text" name="commentId" value="<?php echo $plantComment["id"]; ?>" hidden>
  <input type="submit" value="I CONFIRM I WANT TO SOFT DELETE THIS COMMENT ">
</form>

</br>
                        </td>


                    </tr>	
				<?php
					$i++;
					}
				?>
				</table>


                </br>
                <b>Add Comment<b>
                <form action="addplantcomment.php" method="post">
                <input type="text" name="caretakerId" value="<?php echo $userId;?>" hidden>
<input type="text" name="plantId" value="<?php echo $postPId;?>" hidden>
<input type="text" name="comment"><br>
</br>
<input type="submit" value="Submit">

</form>
</br>


</br></br>


</br></br>
  <form id="form1" enctype="multipart/form-data" method="post" action="Upload.aspx">
 
    <div>
 
      <label for="fileToUpload">Take or select photo(s)</label><br />
 
      <input type="file" name="fileToUpload" id="fileToUpload" onchange="fileSelected();" accept="image/*" capture="camera" />
 
    </div>
 
    <div id="details"></div>
 
    <div>
      <input type="text" name="userId" value="<?php echo $userId;?>" hidden>
      </div>
      <div>
      <input type="text" name="plantId" value="<?php echo $postPId;?>" hidden>
      </div>
 <div>
 
 
      <input type="button" onclick="uploadFile()" value="Upload" />
 
    </div>
 
    <div id="progress"></div>
 
  </form>


</br></br>




</br>
      <form name="logout" method="post" action="login.php">
         <input type="hidden" name="action" value="logout" />
         <input type="submit" value="Logout" />
      </form>

	  

  </body>
</html>
