<?php

include_once "Models/do_checkloggedinstatus.php";
include_once "../Models/do_checkloggedinstatus.php";

include_once "Controllers/mysql_operations.php";
include_once "../Controllers/mysql_operations.php";
$msql = new mysql_operations();

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $_SESSION['UserName'] = $_GET["UserName"];
}
?>
<h1>User details</h1>

<?php
include_once  "navigationbar.php";

$msql->doGetUserDetails($_SESSION['UserName']);

?>