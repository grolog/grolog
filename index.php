<?php
 
require_once ($_SERVER['DOCUMENT_ROOT'].'/inc/functions.php');
require_once ($_SERVER['DOCUMENT_ROOT'].'/inc/modules/header.php');

?>
  
<html>
   <body>
	<h1>Welcome to groLog!</h1>
	
				Welcome Back <b>
				<?php
					echo $caretakerName;
				?></b>!
			<br/>
			
			<table>
			<tr><td>
				Alive Plants (Plants you are caretaker of)
				<table border="1">
				<tr>
					<th>Plant Id</th><th>Strain Id</th><th>Strain Name</th><th>Room Id</th><th>When Planted</th><th>When Sprouted</th><th>Age</th>
				</tr>
				<?php
				/* parse through all actions so user sees what has happened */
				$i = 0;
				foreach ($allPlants as $plants){
                    if ( $plants["harvested"] == "N" && $plants["softDeleted"] == "N" && $plants["caretakerId"] == $userId ) {

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
            




				<br/>				
      <form name="logout" method="post" action="login.php">
         <input type="hidden" name="action" value="logout" />
         <input type="submit" value="Logout" />
      </form>

	  

  </body>
</html>
