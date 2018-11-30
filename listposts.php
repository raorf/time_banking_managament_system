<?php

include_once "Controllers/mysql_operations.php";
include_once "../Controllers/mysql_operations.php";
include_once "Models/do_cookiemanagement.php";
include_once "../Models/do_cookiemanagement.php";

?>
<html>
<h1>Post list</h1>

<?php
include_once  "navigationbar.php";
?>

<?php
$cm = new do_cookiemanagement();
$msql = new mysql_operations();

$msql->doListUserTasks($cm->getUserNameFromCookies());

?>

</html>
