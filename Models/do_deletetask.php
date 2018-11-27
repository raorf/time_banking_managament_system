<?php
/**
 * Created by PhpStorm.
 * User: aleksandrsk
 * Date: 11/25/18
 * Time: 10:21 PM
 */

include_once "do_checkloggedinstatus.php";
include_once "../Controllers/mysql_operations.php";
include_once "Controllers/mysql_operations.php";

$mysql_operations = new mysql_operations();

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $successful = $mysql_operations->doDeleteTask($_GET["TaskID"]);
    if ($successful){
        header('Location: ' . "../listposts.php");
    } else {
        echo "Deletion is not successful";
    }
}