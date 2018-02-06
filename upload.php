<?php
$ds          = DIRECTORY_SEPARATOR;  //1
require_once("./include/php/sql.php");


$storeFolder = 'uploads';   //2

if (!empty($_FILES)) {
    
    $tempFile = $_FILES['file']['tmp_name'];          //3
    
    $targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds;  //4
    
    $fileName = $_POST['projectID']."_".ISDB::getRand()."_".$_FILES['file']['name'];
    
    $targetFile =  $targetPath.$fileName;  //5
    
    move_uploaded_file($tempFile,$targetFile); //6
    
    ISDB::addFileToProject($_POST['projectID'], $fileName);
    
    
}
?>   