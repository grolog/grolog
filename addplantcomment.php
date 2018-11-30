<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/inc/functions.php');
$postPId = intval(trim($_POST["plantId"]));
$postCaretakerId = intval(trim($_POST["caretakerId"]));
if (!empty($_POST["comment"])) {
    $postComment = trim($_POST["comment"]);
} 
if (empty($_POST["comment"])) {
    $postComment = NULL;
}
$fileUploadSet = 0;


if (!empty(basename($_FILES["fileToUpload"]["name"]))){
    $postFileToUpload = $_FILES["fileToUpload"]["name"];
    $fileUploadSet = 1;
    $postFileNameToUpload = basename($_FILES["fileToUpload"]["name"]);
}
//var_dump($postPId);
//var_dump($postCaretakerId);
//var_dump(basename($_FILES["fileToUpload"]["name"]));
//var_dump($fileUploadSet);
//var_dump($postFileNameToUpload);

require_once ($_SERVER['DOCUMENT_ROOT'].'/inc/modules/header.php');

?>
 

	<h1>groLog Admin Panel</h1>
	
				Welcome <b>
				<?php
					echo $caretakerName;
				?></b>!
			<br/>

<?php
if ($postPId != NULL && $dbh != NULL && $postCaretakerId != NULL && $postComment != NULL && $fileUploadSet == 0){
    $plantCommentResults = $dbFcts->addNewPlantComment($postPId, $postCaretakerId, $postComment, $dbh);
    echo "The comment was submitted successfully!</br>";
    echo "<a href='plantinfo.php?plantId=" . $postPId . "'> Click here to go back</a>";
    
    
}
if ($postPId != NULL && $dbh != NULL && $postCaretakerId != NULL && $fileUploadSet == 1 && $postComment == NULL){

$target_dir = "uploads/plants/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image. trying anyway";
        $uploadOk = 1;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $plantCommentPhotoResults = $dbFcts->addNewPlantPhoto($postPId, $postCaretakerId, $target_file, $dbh);
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}


    
    
    echo "The comment was submitted successfully!</br>";
    echo "<a href='plantinfo.php?plantId=" . $postPId . "'> Click here to go back</a>";
    
    
}

else {
    echo "Nothing was Done, Either nothing was added or nothing was said OR no photo was posted!";
}
 
?>
			
</br>			






</br>
      <form name="logout" method="post" action="login.php">
         <input type="hidden" name="action" value="logout" />
         <input type="submit" value="Logout" />
      </form>

	  

  </body>
</html>
