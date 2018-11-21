<?php
/**
 * Created by PhpStorm.
 * User: aleksandrsk
 * Date: 11/21/18
 * Time: 9:13 PM
 */


session_start();

if ($_SESSION['UserLoggedIn'] == true){

} else {
    header('Location: ' . "login.php");
}