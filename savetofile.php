<?php

require_once ($_SERVER['DOCUMENT_ROOT'].'/inc/functions.php');
$postPId = intval(trim(strip_tags($_POST["plantId"])));
$postCaretakerId = intval(trim(strip_tags($_POST["userId"])));

//echo($_POST["plantId"]);


require_once ($_SERVER['DOCUMENT_ROOT'].'/inc/modules/loganddb.php');




if (isset($_FILES['myFile']) && $postPId != NULL && $postCaretakerId != NULL) {
    $target_file = $postPId . "_" . $_FILES['myFile']['name'];
    move_uploaded_file($_FILES['myFile']['tmp_name'], "uploads/plants/" . $postPId . "_" . $_FILES['myFile']['name']);
    $plantCommentPhotoResults = $dbFcts->addNewPlantPhoto($postPId, $postCaretakerId, $target_file, $dbh);
    echo "The file ". $target_file . " has been uploaded.";
    
}
?>