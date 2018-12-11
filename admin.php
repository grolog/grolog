<?php

 
require_once ($_SERVER['DOCUMENT_ROOT'].'/inc/functions.php');
 
require_once ($_SERVER['DOCUMENT_ROOT'].'/inc/modules/header.php');


?>
 
<html>
   <body>
	<h1>groLog Admin Panel</h1>
	
				Welcome <b>
				<?php
					echo $caretakerName;
				?></b>!
			<br/>


			
			<table>
			<tr><td>
				Last Actions
				<table border="1">
				<tr>
					<th>Action</th><th>IP</th><th>Date</th>
				</tr>
				<?php
				/* parse through all actions so user sees what has happened */
				$i = 0;
				foreach ($lastActions as $actions){
				?>
				<tr>
						<td>
							<?php
								echo $actions["action"];
						    ?>
						</td>
						<td>
							<?php
								echo $actions["ip"];
							?>
						</td>
						<td>
							<?php
								echo $actions["date"];
							?>
						</td>
					</tr>	
				<?php
					$i++;
					}
				?>
				</table>

				</td>
				</table>

				<br/>

                
       <a href="addbreeder.php">Add Breeder</a>         
  <br/>              
       <a href="addplant.php">Add Plant</a>         
  <br/>     
    <a href="addstrain.php">Add Strain</a>
    <br/>
        <a href="addbank.php">Add Seed Bank</a>
  <br/>
        <a href="addnutrientcompany.php">Add Nutrient Company</a>
<br/>
        <a href="addnutrient.php">Add Nutrient</a>
        
        <br/>
  <br/>
                			<table>
			<tr><td>
				Alive Plants
                <table border="1">
				<tr>
					<th>Plant Id</th><th>Strain Id</th><th>Strain Name</th><th>Room Id</th><th>Caretaker Planted</th><th>Caretaker Id</th><th>Where Plant Obtained</th><th>Breeder Info</th><th>When Obtained</th><th>When Planted</th><th>When Sprouted</th><th>Age</th>
				</tr>
				<?php
				/* parse through all actions so user sees what has happened */
				$i = 0;
                $alivePlantsByName = $dbFcts->getAlivePlantsOrderByNameAZ($dbh);
				foreach ($alivePlantsByName as $plants){
                     if ( $plants["harvested"] == "N" && $plants["softDeleted"] == "N") {
				?>
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
                                    echo "plantinfo.php?plantId=" . $plants["id"];
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
                }
				?>
				</table>

				</td>
				</table>
                

                			<table>
			<tr><td>
            
            
            
            
				All Breeders
                <table border="1">
				<tr>
					<th>Breeder Id</th><th>Breeder Name</th><th>Breeder Website</th><th>Location</th><th>Who Added</>
				</tr>
				<?php
				/* parse through all actions so user sees what has happened */
				$i = 0;
				foreach ($allbreeders as $breeder){
				?>
				<tr>
						<td>
							<?php
								echo $breeder["id"];
						    ?>
						</td>
						<td>
							<?php
								echo $breeder["breederName"];
							?>
						</td>
						<td>
							<?php
                                echo $breeder["breederWebsite"];
                                ?>
						</td>
                        <td>
                            <?php
                                echo $breeder["breederLocation"];
                                ?>
                        </td>
						<td>
							<?php
                                $caretaker = $dbFcts->getCaretakerNameFromId($breeder["userAdded"], $dbh);
								echo $caretaker[0]["firstName"] . " " . $caretaker[0]["lastName"];
							?>
                            <?php
                                echo ("(" . $breeder["userAdded"] . ")");
                            ?>
                        </td>

                    </tr>	
				<?php
					$i++;
					}
				?>
				</table>

				</td>
				</table>
                 			<table>
			<tr><td>
            
				All Strains
                <table border="1">
				<tr>
					<th>Strain Id</th><th>Strain Name</th><th>Breeder</th><th>Sativa</th><th>Indica</th><th>Ruderalis</th><th>Who Added</th>
				</tr>
				<?php
				/* parse through all actions so user sees what has happened */
				$i = 0;
				foreach ($allstrains as $strain){
                    //var_dump($strain);
                                                                                    $strainBreeder = $dbFcts->getBreederInfoFromId($strain["breederId"], $dbh);
				?>
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
                                    echo "straininfo.php?strainId=" . $strain["id"];
                                ?>
                            ">
                        <?php echo $strain["strainName"]; ?>
                            </a>
                        </td>
						<td>
							<?php
                            //var_dump($strainBreeder);
								echo $strainBreeder[0]["breederName"] . "/" . $strainBreeder[0]["breederLocation"];
                                echo "(" . $strainBreeder[0]["id"] . ")";

                                ?>
						</td>
						<td>                                

							<?php
                            //var_dump($strain);
                                echo $strain["strainSativa"];
                                ?>
						</td>
                        <td>
                        <?php
                            echo $strain["strainIndica"];
							?>
                        </td>
                        <td>
                            <?php echo $strain["strainRuderalis"];
                            ?>
                        </td>
						<td>
                        
							<?php
                                $caretaker = $dbFcts->getCaretakerNameFromId($breeder["userAdded"], $dbh);
								echo $caretaker[0]["firstName"] . " " . $caretaker[0]["lastName"];
							?>
                            <?php
                                echo ("(" . $breeder["userAdded"] . ")");
                            ?>
                        </td>

                    </tr>	
				<?php
					$i++;
					}
				?>
				</table>

				</td>
				</table>

			<table>
			<tr><td>
				All Plants
				<table border="1">
				<tr>
					<th>Plant Id</th><th>Strain Id</th><th>Strain Name</th><th>Room Id</th><th>Caretaker Planted</th><th>Caretaker Id</th><th>Where Plant Obtained</th><th>When Obtained</th><th>When Planted</th><th>When Sprouted</th><th>Harvested</th><th>When Harvested</th>
				</tr>
				<?php
				/* parse through all actions so user sees what has happened */
				$i = 0;
				foreach ($allPlants as $plants){
				?>
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
                                    echo "plantinfo.php?plantId=" . $plants["id"];
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
                            <?php
                                $datetime1 = new DateTime();
                                $datetime2 = new DateTime($plants["whenPlanted"]);
                                $interval = $datetime1->diff($datetime2);
                                $elapsed = $interval->format('%y years %m months %a days %h hours %i minutes %s seconds');
                                $elapsedDays = $interval->format('%a days');
                                #echo $elapsed;
                                #echo $elapsedDays;
                                #echo strtotime($plants["whenPlanted"])->diff($dateNowTime)->days;
                            ?>
                        </td>
						<td>
							<?php
								echo $plants["harvested"];
							?>
						</td>
						<td>
							<?php
								echo $plants["whenHarvested"];
							?>
						</td>
                    </tr>	
				<?php
					$i++;
					}
				?>
				</table>

				</td>
                
                
                
                
                
                
                		<tr><td>
            
            
            
            
				All Nutrient Companies
                <table border="1">
				<tr>
					<th>Company Id</th><th>Company Name</th><th>Company Website</th><th>Location</th><th>Who Added</>
				</tr>
				<?php
				/* parse through all actions so user sees what has happened */
				$i = 0;
				foreach ($allnutrientcompanies as $nutrientcompany){
				?>
				<tr>
						<td>
							<?php
								echo $nutrientcompany["id"];
						    ?>
						</td>
						<td>
							<?php
								echo $nutrientcompany["companyName"];
							?>
						</td>
						<td>
							<?php
                                echo $nutrientcompany["companyWebsite"];
                                ?>
						</td>
                        <td>
                            <?php
                                echo $nutrientcompany["companyLocation"];
                                ?>
                        </td>
						<td>
							<?php
                                $caretaker = $dbFcts->getCaretakerNameFromId($nutrientcompany["userAdded"], $dbh);
								echo $caretaker[0]["firstName"] . " " . $caretaker[0]["lastName"];
							?>
                            <?php
                                echo ("(" . $nutrientcompany["userAdded"] . ")");
                            ?>
                        </td>

                    </tr>	
				<?php
					$i++;
					}
				?>
				</table>

				</td>
                
                
                
                
                
                		<tr><td>
            
            
            
            
				All Nutrients
                <table border="1">
				<tr>
					<th>Producer</th>Company Website</th><th>Nutrient Name</th><th>Who Added</th><th>N</th><th>P</th><th>K</th><th>Ca</th><th>Mg</th><th>S</th><th>Fe</th><th>Mn</th><th>Mo</th><th>Azomite</th><th>Mycorrhizae</th><th>Consistency</th><th>Additional Info</th>
				</tr>
				<?php
				/* parse through all actions so user sees what has happened */
				$i = 0;
				foreach ($allnutrients as $nutrients){
				?>
				<tr>

						<td>
							<?php
                             $nutrientcompanyinfo = $dbFcts->getNutrientCompanyInfo($nutrients["nuteCompany"], $dbh);

								echo $nutrientcompanyinfo[0]["companyName"];
							?>
						</td>
						<td>
							<?php
                                echo $nutrients["nuteName"];
                                ?>
						</td>
						<td>
							<?php
                                $caretaker = $dbFcts->getCaretakerNameFromId($nutrients["userId"], $dbh);
								echo $caretaker[0]["firstName"] . " " . $caretaker[0]["lastName"];
							?>
                            <?php
                                echo ("(" . $nutrientcompany["userAdded"] . ")");
                            ?>
                        </td>
                        <td>
							<?php
                                echo $nutrients["nuteN"];
                                ?>                        
                        </td>

                        <td>
							<?php
                                echo $nutrients["nuteP"];
                                ?>
                        
                        </td>

                        <td>
							<?php
                                echo $nutrients["nuteK"];
                                ?>
                        
                        </td>

                        <td>
                        
							<?php
                                echo $nutrients["nuteCa"];
                                ?>
                        </td>

                        <td>
                        
							<?php
                                echo $nutrients["nuteMg"];
                                ?>                        
                                </td>

                        <td>
                        
							<?php
                                echo $nutrients["nuteS"];
                                ?>
                        </td>

                        <td>
							<?php
                                echo $nutrients["nuteFe"];
                                ?>
                        
                        </td>

                        <td>
							<?php
                                echo $nutrients["nuteMn"];
                                ?>
                        
                        </td>

                        <td>
                        
							<?php
                                echo $nutrients["nuteMo"];
                                ?>
                        </td>

                        <td>
							<?php
                                echo $nutrients["nuteAzomite"];
                                ?>
                        
                        </td>

                        <td>
							<?php
                                echo $nutrients["nuteMycorrhizae"];
                                ?>
                        
                        </td>

                        <td>
							<?php
                                $nuteCon = $nutrients["nuteConsistency"];
                                if ($nuteCon == "S") {
                                    echo "Solid";
                                }
                                if ($nuteCon == "L") {
                                    echo "Liquid";
                                }
                                if ($nuteCon == "O") {
                                    echo "Other";
                                }
                                    
                                ?>
                        
                        </td>

                        <td>
							<?php
                                echo $nutrients["nuteAdditional"];
                                ?>                        
                        </td>

                    </tr>	
				<?php
					$i++;
					}
				?>
				</table>

				</td>               
                
                
                
				</table>



				<br/>				
      <form name="logout" method="post" action="login.php">
         <input type="hidden" name="action" value="logout" />
         <input type="submit" value="Logout" />
      </form>

	  

  </body>
</html>
