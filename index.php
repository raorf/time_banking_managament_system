<?php
/**
 * Created by PhpStorm.
 * Date: 28/10/2018
 * Time: 23:10
 */
include_once "Controllers/mysql_init.php";
session_start();

if ($_SESSION['UserLoggedIn'] == true){
    echo "Welcome back.";
    echo "<p><a href=\"Models/do_logout.php\">Log out</a></p>";
} else {
    echo "<p><a href=\"login.php\">Log in</a></p>";
    echo "<p><a href=\"registration.php\">Register</a></p>";
}
?>
<html>




</html>
