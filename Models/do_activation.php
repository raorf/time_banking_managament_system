<?php
/**
 * Created by PhpStorm.
 * User: aleks
 * Date: 03/11/2018
 * Time: 19:56
 */
include_once "../Controllers/mysql_operations.php";

$mysql_operations = new mysql_operations();

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $successful = $mysql_operations->activateUser($_GET["UserName"], $_GET["UserCaptcha"]);
    if ($successful){
        echo "User ".$_GET["UserName"]." is activated";
        header('Location: ' . "../Views/login.php");
    } else {
        echo "Activation is not successful";
        header('Location: ' . "../Views/index.php");
    }
}