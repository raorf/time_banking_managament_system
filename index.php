<?php

include_once "Controllers/mysql_init.php";
include_once "Models/do_cookiemanagement.php";
include_once "../Controllers/mysql_init.php";
include_once "../Models/do_cookiemanagement.php";
session_start();

$cm = new do_cookiemanagement();
echo "<h1>Welcome to member zone, ".$cm -> getUserNameFromCookies()."</h1>";

?>

<?php
include_once  "navigationbar.php";
?>

