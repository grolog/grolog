<?php
/*include configuration options */
include($_SERVER['DOCUMENT_ROOT']."/inc/config.php");

/* configure read+write database */
define ('DB_HOST',  $config['mysql']['rw']['host']);
define ('DB_NAME', $config['mysql']['rw']['db']);
define ('DB_USERNAME', $config['mysql']['rw']['user']);
define ('DB_PASSWORD', $config['mysql']['rw']['pass']);
 
/* Sanitizes input through PDO and uses random (mt_rand) blowfish */
class DatabaseHelpers
{
   function blowfishCrypt($password, $length)
   {
      $chars = './ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
      $salt = sprintf ('$2a$%02d$', $length);
      for ($i=0; $i < 22; $i++)
      {
         $salt .= $chars[mt_rand (0,63)];
      }
 
      return crypt ($password, $salt);
   }
 
   public function getDatabaseConnection()
   {
      $dbh = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD);
 
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
      return $dbh;
   }
   

   
function get_client_ip() {
     $ipaddress = '';
     if ($_SERVER['HTTP_CLIENT_IP'])
         $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
     else if($_SERVER['HTTP_X_FORWARDED_FOR'])
         $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
     else if($_SERVER['HTTP_X_FORWARDED'])
         $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
     else if($_SERVER['HTTP_FORWARDED_FOR'])
         $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
     else if($_SERVER['HTTP_FORWARDED'])
         $ipaddress = $_SERVER['HTTP_FORWARDED'];
     else if($_SERVER['REMOTE_ADDR'])
         $ipaddress = $_SERVER['REMOTE_ADDR'];
     else
         $ipaddress = 'UNKNOWN';

     return $ipaddress; 
}
   
   
      function checkUserNew($username, $dbh)
   {
	    $stmt = $dbh->prepare("SELECT username FROM users WHERE username = ?");
		$stmt->execute(array($username));
		$row_count = $stmt->rowCount();
		return $row_count;
   }
      function selectUserNew($username, $dbh)
   {
	    $stmt = $dbh->prepare("SELECT * FROM users WHERE username = ?");
		$stmt->execute(array($username));
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $results;
   }
   
         function addNewUser($username, $password, $email, $dbh)
   {
		$stmt = $dbh->prepare("INSERT INTO users (username, password, email, admin) VALUES (?, ?, ?, 'Y')");
	    $stmt->execute(array($username, $password, $email));
		$rows = $stmt->rowCount();
		return $rows;
   }
         function addNewCaretaker($firstName, $middleName, $lastName, $addressHouseNumber, $addressRoadName, $addressCity, $addressState, $addressZip, $addressCountry, $userId, $dbh)
   {
		$stmt = $dbh->prepare("INSERT INTO caretakerid (firstName, middleName, lastName, dateAddedToDb, addressHouseNumber, addressRoadName, addressCity, addressState, addressZip, addressCountry, userId) VALUES (?, ?, ?, NOW(), ?, ?, ?, ?, ?, ?, ?)");
	    $stmt->execute(array($firstName, $middleName, $lastName, $addressHouseNumber, $addressRoadName, $addressCity, $addressState, $addressZip, $addressCountry, $userId));
		$rows = $stmt->rowCount();
		return $rows;
   }
   function checkUserId($username, $dbh)
   {
	    $stmt = $dbh->prepare("SELECT id FROM users WHERE username = ?");
		$stmt->execute(array($username));
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $results;
   }   
   
            function updateActionLog($username, $userIp, $action, $dbh)
   {
		$stmt = $dbh->prepare("INSERT INTO actionlog (username, ip, action) VALUES (?, ?, ?)");
	    $stmt->execute(array($username, $userIp, $action));
		$rows = $stmt->rowCount();
		return $rows;
   }
   
               function getUserInfoFromId($userId, $dbh)
   {
	    $stmt = $dbh->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
		$stmt->execute(array($userId));
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $results;
   }
   

   
                  function getLastActions($username, $dbh)
   {
	    $stmt = $dbh->prepare("SELECT * FROM actionlog WHERE username = ? ORDER BY id DESC LIMIT 10");
		$stmt->execute(array($username));
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $results;
   }

   /* Start email authentication Functions */ 
    function sendEmailLoginAuth($userId, $ip, $dbh)
 {
    include($_SERVER['DOCUMENT_ROOT']."/inc/config.php");
	$stmt = $dbh->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
	$stmt->execute(array($userId));
	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$userEmail = $results[0]['email'];
	$username  = $results[0]['username'];
	$time = gmdate("D M j G:i:s T Y");

	$subject   = "Login Authentication (".$ip.") ".$time; 
	
	/* mail headers */
	$headers   = array();
	$headers[] = "MIME-Version: 1.0";
	$headers[] = "Content-type: text/plain; charset=iso-8859-1";
	$headers[] = "From: Login Authentication ".$config['main']['config']['siteShortName']." <".$config['main']['email']['auth'].">";
	$headers[] = "Bcc: BCC ".$config['main']['config']['siteShortName']." <".$config['main']['email']['bcc'].">";
	$headers[] = "Reply-To: No Reply ".$config['main']['config']['siteShortName']."  <".$config['main']['email']['noreply'].">";
	//$headers[] = "X-Mailer: PHP/".phpversion();
	$headers[] = "Subject: {$subject}";	
	
	
	/* start login auth random number generator 16 digits
	*
    * Source: https://gist.github.com/raveren/5555297
    *
    */
		$length = 16;
		$type = 'alnum'; 
		switch ( $type ) {
		case 'alnum':
			$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			break;
		case 'alpha':
			$pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			break;
		case 'hexdec':
			$pool = '0123456789abcdef';
			break;
		case 'numeric':
			$pool = '0123456789';
			break;
		case 'nozero':
			$pool = '123456789';
			break;
		case 'distinct':
			$pool = '2345679ACDEFHJKLMNPRSTUVWXYZ';
			break;
		default:
			$pool = (string) $type;
			break;
	}

	$crypto_rand_secure = function ( $min, $max ) {
		$range = $max - $min;
		if ( $range < 0 ) return $min; // not so random...
		$log    = log( $range, 2 );
		$bytes  = (int) ( $log / 8 ) + 1; // length in bytes
		$bits   = (int) $log + 1; // length in bits
		$filter = (int) ( 1 << $bits ) - 1; // set all lower bits to 1
		do {
			$rnd = hexdec( bin2hex( openssl_random_pseudo_bytes( $bytes ) ) );
			$rnd = $rnd & $filter; // discard irrelevant bits
		} while ( $rnd >= $range );
		return $min + $rnd;
	};
 
	$authCode = "";
	$max   = strlen( $pool );
	for ( $i = 0; $i < $length; $i++ ) {
		$authCode .= $pool[$crypto_rand_secure( 0, $max )];
	}
	/* end login auth random number generator */
	
	/* enter number in to authentication table */
	
	$stmt = $dbh->prepare("INSERT INTO emailauth (userId, authCode, ip) VALUES(?, ?, ?)");
	$stmt->execute(array($userId, $authCode, $ip));
	$rows = $stmt->rowCount();
	
	if ($rows == 1) {
	
	/* begin construction of email for authentication of login */
	$message = "
	Hello ".$username.", 
	
	A Login Authentication was requested from ".$ip."
	
	At: ".$time."
	
	
	
	Authentication Code: ". $authCode ."
	";
	
	mail($userEmail, $subject, $message, implode("\r\n", $headers));	
	return 1;
	} else {
	return 0;
	}
 }


 function sendEmailLoginSuccess($userId, $ip, $dbh)
 {
    include($_SERVER['DOCUMENT_ROOT']."/inc/config.php");
	$stmt = $dbh->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
	$stmt->execute(array($userId));
	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$userEmail = $results[0]['email'];
	$username  = $results[0]['username'];
	$time = gmdate("D M j G:i:s T Y");

	$subject   = "Login Alert (".$ip.") ".$time; 
	
	/* mail headers */
	$headers   = array();
	$headers[] = "MIME-Version: 1.0";
	$headers[] = "Content-type: text/plain; charset=iso-8859-1";
	$headers[] = "From: Login Alerts ".$config['main']['config']['siteShortName']." <".$config['main']['email']['alerts'].">";
	$headers[] = "Bcc: BCC ".$config['main']['config']['siteShortName']." <".$config['main']['email']['bcc'].">";
	$headers[] = "Reply-To: No Reply ".$config['main']['config']['siteShortName']."  <".$config['main']['email']['noreply'].">";
	//$headers[] = "X-Mailer: PHP/".phpversion();
	$headers[] = "Subject: {$subject}";	
	
	$message = "
	Hello ".$username.", 
	
	A successful login detected from ".$ip."
	
	At:".$time."
	";
	
	mail($userEmail, $subject, $message, implode("\r\n", $headers));
	return 1;
 }   
   
    function sendEmailLoginFail($username, $ip, $dbh)
 {
    include($_SERVER['DOCUMENT_ROOT']."/inc/config.php");
	$stmt = $dbh->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
	$stmt->execute(array($username));
	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$userEmail = $results[0]['email'];
	$time = gmdate("D M j G:i:s T Y");

	$subject   = "Login FAILED Alert (".$ip.") ".$time; 
	
	/* mail headers */
	$headers   = array();
	$headers[] = "MIME-Version: 1.0";
	$headers[] = "Content-type: text/plain; charset=iso-8859-1";
	$headers[] = "From: Login Alerts ".$config['main']['config']['siteShortName']." <".$config['main']['email']['alerts'].">";
	$headers[] = "Bcc: BCC ".$config['main']['config']['siteShortName']." <".$config['main']['email']['bcc'].">";
	$headers[] = "Reply-To: No Reply ".$config['main']['config']['siteShortName']."  <".$config['main']['email']['noreply'].">";
	//$headers[] = "X-Mailer: PHP/".phpversion();
	$headers[] = "Subject: {$subject}";	
	
	$message = "
	Hello ".$username.", 
	
	A FAILED login detected from ".$ip."
	
	At: ".$time."
	";
	
	mail($userEmail, $subject, $message, implode("\r\n", $headers));
	return 1;
 } 
 
  function checkLoginAuth($userId, $authCode, $dbh) {
   
   	$stmt = $dbh->prepare("select * from emailauth WHERE userId = ? AND authcode = ? AND used = 'N'");
	$stmt->execute(array($userId, $authCode));
	$rows = $stmt->rowCount();
	if ($rows == 1) {
		return 1;
	} else {
		return 0;
		}
	}
  /* grolog specific coding here */

               function getAllPlants($dbh)
   {
        //order simply by plant id ascending from 0 to infinity by uncommenting the following line then the line after with the LEFT JOIN should be commented. or keep it how it is to left join.
        //$stmt = $dbh->prepare("SELECT * FROM plants order by id ASC");
        //to order by the name of the strain from A to Z and not by the plant ID you do the following line. this is system usage heavy
        $stmt = $dbh->prepare("SELECT plants.*, strain.strainName FROM plants LEFT JOIN strain ON strain.id = plants.strainId ORDER BY strain.strainName");
		$stmt->execute();
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $results;
   }  

  
               function getAlivePlants($dbh)
   {
	    $stmt = $dbh->prepare("SELECT * FROM plants WHERE harvested = 'N' AND softDeleted = 'N' ORDER BY id ASC");
		$stmt->execute(
        );
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $results;
   } 
  
               function getAlivePlantsOrderByNameAZ($dbh)
   {
        //order simply by plant id ascending from 0 to infinity by uncommenting the following line then the line after with the LEFT JOIN should be commented. or keep it how it is to left join.
        //$stmt = $dbh->prepare(SELECT * FROM plants WHERE harvested = 'N' AND softDeleted = 'N' ORDER BY id ASC");
        //to order by the name of the strain from A to Z and not by the plant ID you do the following line. this is system usage heavy
        $stmt = $dbh->prepare("SELECT plants.*, strain.strainName FROM plants LEFT JOIN strain ON strain.id = plants.strainId WHERE harvested = 'N' AND plants.softDeleted = 'N' ORDER BY strain.strainName");
		$stmt->execute(
        );
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $results;
   } 
               function getHarvestedPlants($dbh)
   {
	    $stmt = $dbh->prepare("SELECT * FROM plants WHERE harvested = 'Y' ORDER BY id ASC");
		$stmt->execute();
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $results;
   } 
               function getAllSeedBanks($dbh)
   {
        //order by bank insert id (oldest being first inserted banks)
	    //$stmt = $dbh->prepare("SELECT * FROM banks ORDER BY id ASC");
        //order by name a to z and more friendly but slower
        $stmt = $dbh->prepare("SELECT * FROM banks ORDER BY bankName");
		$stmt->execute();
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $results;
   }
               function getAllApprovedSeedBanks($dbh)
   {
        //order by bank insert id (oldest being first inserted banks)
	    //$stmt = $dbh->prepare("SELECT * FROM banks ORDER BY id ASC");
        //order by name a to z and more friendly but slower
        $stmt = $dbh->prepare("SELECT * FROM banks WHERE softDeleted = 'N' ORDER BY bankName");
		$stmt->execute();
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $results;
   }

   
               function getBreederInfoFromId($breederId, $dbh)
   {
	    $stmt = $dbh->prepare("SELECT * FROM breeder WHERE id = ? LIMIT 1");
		$stmt->execute(array($breederId));
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $results;
   } 
   
               function getBankObtainedPlants($bankId, $dbh)
   {
	    $stmt = $dbh->prepare("SELECT * FROM banks WHERE id = ? LIMIT 1");
		$stmt->execute(array($bankId));
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $results;
   } 
   
               function getCaretakerNameFromId($caretakerId, $dbh)
   {
	    $stmt = $dbh->prepare("SELECT * FROM caretakerid WHERE userId = ? LIMIT 1");
		$stmt->execute(array($caretakerId));
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $results;
   } 

               function getCaretakerNameFromUserId($userId, $dbh)
   {
	    $stmt = $dbh->prepare("SELECT * FROM caretakerid WHERE userId = ? LIMIT 1");
		$stmt->execute(array($userId));
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $results;
   } 
   
   
               function getstrainNameFromId($strainId, $dbh)
   {
	    $stmt = $dbh->prepare("SELECT * FROM strain WHERE id = ? LIMIT 1");
		$stmt->execute(array($strainId));
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $results;
   } 
               function getBreederFromPlantId($breederId, $dbh)
   {
	    $stmt = $dbh->prepare("SELECT * FROM breeder WHERE id = ? LIMIT 1");
		$stmt->execute(array($breederId));
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $results;
   }
          function addBreeder($userId, $breederName, $country,$website, $dbh)
   {
		$stmt = $dbh->prepare("INSERT INTO breeder (breederName, breederLocation, userAdded, breederWebsite) VALUES (?, ?, ?, ?)");
	    $stmt->execute(array($breederName, $country, $userId, $website));
		$rows = $stmt->rowCount();
		return $rows;;
   }
          function addSeedBank($userId, $bankName, $country, $website, $dbh)
   {
		$stmt = $dbh->prepare("INSERT INTO banks (bankName, bankLocation, userAdded, bankWebsite) VALUES (?, ?, ?, ?)");
	    $stmt->execute(array($bankName, $country, $userId, $website));
		$rows = $stmt->rowCount();
		return $rows;
   }
   
   
   function addPlant($strainId, $caretakerId, $whenObtained, $whenPlanted, $day1, $roomId, $whereObtainedId, $breeder, $dbh)
   {
		$stmt = $dbh->prepare("INSERT INTO plants (strainId, caretakerId, whenObtained, whenPlanted, whenSprouted, roomId, whereObtainedId, breeder) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
	    $stmt->execute(array($strainId, $caretakerId, $whenObtained, $whenPlanted, $day1, $roomId, $whereObtainedId, $breeder));
		$rows = $stmt->rowCount();
		return $rows;
   }

   function addPlantNotSprouted($strainId, $caretakerId, $whenObtained, $whenPlanted, $roomId, $whereObtainedId, $breeder, $dbh)
   {
		$stmt = $dbh->prepare("INSERT INTO plants (strainId, caretakerId, whenObtained, whenPlanted, roomId, whereObtainedId, breeder) VALUES (?, ?, ?, ?, ?, ?, ?)");
	    $stmt->execute(array($strainId, $caretakerId, $whenObtained, $whenPlanted, $roomId, $whereObtainedId, $breeder));
		$rows = $stmt->rowCount();
		return $rows;
   }
    
   
   
        function listBreeders($dbh)
        {
            $stmt = $dbh->prepare("SELECT * FROM breeder ORDER BY breederName");
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
   
  }
        function listStrains($dbh)
        {
            $stmt = $dbh->prepare("SELECT * FROM strain ORDER BY strainName");
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
   
  }
  
     function addStrain($breederId, $strainName, $strainType, $strainSativa, $strainIndica, $strainRuderalis, $strainWebsite, $strainDescription, $whereObtained, $dbh)
   {
		$stmt = $dbh->prepare("INSERT INTO strain (breederId, strainName, strainType, strainSativa, strainIndica, strainRuderalis, strainWebsite, strainDescription, whereObtained) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
	    $stmt->execute(array($breederId, $strainName, $strainType, $strainSativa, $strainIndica, $strainRuderalis, $strainWebsite, $strainDescription, $whereObtained));
		$rows = $stmt->rowCount();
		return $rows;
   }

     function addPlantUpdatesComment($plantId, $comment, $dbh)
   {
		$stmt = $dbh->prepare("INSERT INTO plantupdates (plantId, comment) VALUES (?, ?)");
	    $stmt->execute(array($plantId, $comment));
		$rows = $stmt->rowCount();
		return $rows;
   }
   
     function listAllPlantUpdates($plantId, $dbh)
   {
        $stmt = $dbh->prepare("SELECT * FROM plantupdates WHERE plantId = ?");
		$stmt->execute(array($plantId));
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $results;
   }
     function listLastNSinglePlantUpdates($plantId, $maxRows, $dbh)
   {
        $stmt = $dbh->prepare("SELECT * FROM plantupdates WHERE plantId = ? ORDER BY id DESC LIMIT {$maxRows}");
		$stmt->execute(array($plantId));
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $results;
   }
     function listAllSinglePlantUpdates($plantId, $dbh)
   {
        $stmt = $dbh->prepare("SELECT * FROM plantupdates WHERE plantId = ? ORDER BY id DESC");
  		$stmt->execute(array($plantId));
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $results;
   }   
     function listAllAllPlantUpdates($dbh)
  {
        $stmt = $dbh->prepare("SELECT * FROM plantupdates ORDER BY id DESC");
        #you could write it to not order by id but ORDER BY submissionTime DESC LIMIT ?
		$stmt->execute(array($maxRows));
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $results;
  }

     function listAllActivePlantUpdates($plantId, $dbh)
   {
        $stmt = $dbh->prepare("SELECT * FROM plantupdates WHERE plantId = ? AND softDeleted = 'N'");
		$stmt->execute(array($plantId));
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $results;
   }
     function listLastNActiveSinglePlantUpdates($plantId, $maxRows, $dbh)
   {
        $stmt = $dbh->prepare("SELECT * FROM plantupdates WHERE plantId = ? AND softDeleted = 'N' ORDER BY id DESC LIMIT {$maxRows}"); // this statement needs to be rewritten for security nd $maxRows shouldnt be in there. the issue was timing. this line should be fixed
		$stmt->execute(array($plantId));
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $results;
   }
     function listAllActiveSinglePlantUpdates($plantId, $dbh)
   {
        $stmt = $dbh->prepare("SELECT * FROM plantupdates WHERE plantId = ? AND softDeleted = 'N' ORDER BY id DESC");
  		$stmt->execute(array($plantId));
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $results;
   }   
     function listAllActiveAllPlantUpdates($dbh)
  {
        $stmt = $dbh->prepare("SELECT * FROM plantupdates WHERE softDeleted = 'N' ORDER BY id DESC");
        #you could write it to not order by id but ORDER BY submissionTime DESC LIMIT ?
		$stmt->execute(array($maxRows));
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $results;
  }
  
   function softDeletePlantComment($commentId, $plantId, $dbh)
    {
        $stmt = $dbh->prepare("UPDATE plantupdates SET softDeleted = 'Y' WHERE id = ? AND plantId = ?");
        $stmt->execute(array($commentId, $plantId));
        $results = $stmt->rowCount();
        return $results;
    }
    
   function addNewPlantComment($plantId, $userId, $comment, $dbh)
   {
		$stmt = $dbh->prepare("INSERT INTO plantupdates (plantId, userId, comment) VALUES (?, ?, ?)");
	    $stmt->execute(array($plantId, $userId, $comment));
		$rows = $stmt->rowCount();
		return $rows;
   }

   function addNewPlantPhoto($plantId, $userId, $photoName, $dbh)
   {
		$stmt = $dbh->prepare("INSERT INTO plantupdates (plantId, userId, comment, photoUploaded, fileUploaded) VALUES (?, ?, ?, ?, ?)");
	    $stmt->execute(array($plantId, $userId, 'Photo Uploaded', 'Y', $photoName));
		$rows = $stmt->rowCount();
		return $rows;
   }
   function addNewPlantCommentFeeding($plantId, $userId, $feedingId, $dbh)
   {
		$stmt = $dbh->prepare("INSERT INTO plantupdates (plantId, userId, nutrientUpdate, nutrientAssociatedUpdate) VALUES (?, ?, ?, ?)");
	    $stmt->execute(array($plantId, $userId, 'Y', $feedingId));
		$rows = $stmt->rowCount();
		return $rows;
   }
   
    function getIndividualPlantInfo($plantId, $dbh)
   {
	    $stmt = $dbh->prepare("SELECT * FROM plants WHERE id = ? LIMIT 1");
		$stmt->execute(array($plantId));
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $results;
   } 
    function setSproutedToday($plantId, $dbh)
   {
	    $stmt = $dbh->prepare("UPDATE plants SET whenSprouted = NOW() WHERE id = ? AND whenSprouted IS NULL");
		$stmt->execute(array($plantId));
		$results = $stmt->rowCount();
		return $results;
   } 
    function setSproutedTodayAutoComment($plantId, $userId, $dbh)
   {
		$stmt = $dbh->prepare("INSERT INTO plantupdates (plantId, userId, comment) VALUES (?, ?, ?)");
	    $stmt->execute(array($plantId, $userId, "Seed Sprouted"));
		$rows = $stmt->rowCount();
		return $rows;
   } 
   function softDeletePlant($plantId, $dbh)
    {
        $stmt = $dbh->prepare("UPDATE plants SET softDeleted = 'Y' WHERE id = ?");
        $stmt->execute(array($plantId));
        $results = $stmt->rowCount();
        return $results;
    }
    function softDeleteStrain($strainId, $dbh)
    {
        $stmt = $dbh->prepare("UPDATE strain SET softDeleted = 'Y' WHERE id = ?");
        $stmt->execute(array($strainId));
        $results = $stmt->rowCount();
        return $results;
    }
    function getStrainAllInfo($strainId, $dbh)
    {
            $stmt = $dbh->prepare("SELECT * FROM strain WHERE id = ? LIMIT 1");
            $stmt->execute(array($strainId));
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
    }
    function softDeleteBank($bankId, $dbh)
    {
        $stmt = $dbh->prepare("UPDATE banks SET softDeleted = 'Y' WHERE id = ? LIMIT 1");
        $stmt->execute(array($bankId));
        $results = $stmt->rowCount();
        return $results;
    }
    function getPlantPhoto($plantId, $dbh)
    {
       $stmt = $dbh->prepare("SELECT * FROM plantupdates WHERE plantId = ? AND photoUploaded = 'Y' ORDER BY id DESC LIMIT 1");
       $stmt->execute(array($plantId));
       $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
       return $results;
       
}
    function harvestPlantWet($plantId, $userIdHarvest, $wetWeightUntrimmedGrams, $wetWeightTrimmedGrams, $wetWeightUnusableTrimGrams, $wetWeightSugarTrimGrams, $willBeProcessed, $processedType, $dbh)
    {
		$stmt = $dbh->prepare("INSERT INTO finalweight (plantId, userIdWet, wetWeightObtainedDate, wetWeightUntrimmedGrams, wetWeightTrimmedGrams, wetWeightUnusableTrimGrams, wetWeightSugarTrimGrams, willBeProcessed, processedType) VALUES (?, ?, NOW(), ?, ?, ?, ?, ?, ?)");
	    $stmt->execute(array($plantId, $userIdHarvest, $wetWeightUntrimmedGrams, $wetWeightTrimmedGrams, $wetWeightUnusableTrimGrams, $wetWeightSugarTrimGrams, $willBeProcessed, $processedType));
		$rows = $stmt->rowCount();
		return $rows;
}
    function harvestPlantDry($plantId, $userIdDry, $dryWeightUntrimmedGrams, $dryWeightTrimmedGrams, $dryWeightUnusableTrimGrams, $dryWeightSugarTrimGrams, $processedWeight, $dbh)
    {
		$stmt = $dbh->prepare("UPDATE finalweight SET userIdDry = ?, dryWeightObtainedDate = NOW(), dryWeightUntrimmedGrams = ?, dryWeightTrimmedGrams = ?, dryWeightUnusableTrimGrams = ?, dryWeightSugarTrimGrams = ?, processedWeight = ? WHERE plantId = ? LIMIT 1");
	    $stmt->execute(array($userIdDry, $dryWeightUntrimmedGrams, $dryWeightTrimmedGrams, $dryWeightUnusableTrimGrams, $dryWeightSugarTrimGrams, $processedWeight, $plantId));
		$rows = $stmt->rowCount();
		return $rows;
}
    function setHarvestPlantsTable($plantId, $userId, $dbh)
    {
        $stmt = $dbh->prepare("UPDATE plants SET harvested = 'Y', userIdHarvested = ?, whenHarvested = NOW() WHERE id = ? LIMIT 1");
        $stmt->execute(array($userId, $plantId));
        $results = $stmt->rowCount();
        return $results;
    }

    function setDryPlantsTable($plantId, $dbh)
    {
        $stmt = $dbh->prepare("UPDATE plants SET finalDryWeightObtained = 'Y' WHERE id = ? LIMIT 1");
        $stmt->execute(array($plantId));
        $results = $stmt->rowCount();
        return $results;
    }    
    
    function plantWasteRemoval($plantId, $userId, $wasteType, $wasteCenterId, $wasteWeight, $wasteVolume, $wasteMethod, $dbh)
    {
		$stmt = $dbh->prepare("INSERT INTO wasteremoval (plantId, userId, wasteType, wasteCenterId, wasteWeight, wasteVolume, wasteMethod) VALUES (?, ?, ?, ?, ?, ?, ?)");
	    $stmt->execute(array($plantId, $userId, $wasteType, $wasteCenterId, $wasteWeight, $wasteVolume, $wasteMethod));
		$rows = $stmt->rowCount();
		return $rows;
}
    function getPlantHarvestWetInfoOnePlant($plantId, $dbh)
    {
       $stmt = $dbh->prepare("SELECT plantId, userIdWet, wetWeightObtainedDate, wetWeightUntrimmedGrams, wetWeightTrimmedGrams, wetWeightUnusableTrimGrams, wetWeightSugarTrimGrams FROM finalweight WHERE plantId = ? LIMIT 1");
       $stmt->execute(array($plantId));
       $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
       return $results;
}
    function getPlantHarvestAllInfoOnePlant($plantId, $dbh)
    {
       $stmt = $dbh->prepare("SELECT * FROM finalweight WHERE plantId = ? LIMIT 1");
       $stmt->execute(array($plantId));
       $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
       return $results;
}
}
?>
