<?php

include_once "../Controllers/mysql_operations.php";
include_once "Controllers/mysql_operations.php";
session_start();


$upload_image=$_FILES["myimage"]["name"];
$extension = explode ( "." , $upload_image)[1];

$upload_image = hash('sha256', $upload_image . strval(time())).".".$extension;

$folder=getcwd()."/../images/";

echo "Image name: ".$upload_image." Folder: ".$folder;

move_uploaded_file($_FILES["myimage"]["tmp_name"], "$folder".$upload_image);

$mysqlops = new mysql_operations();
$mysqlops->doInsertTaskImage($_SESSION['CurrentTaskID'], $upload_image);

header('Location: '."../uploadimage.php");

?>
