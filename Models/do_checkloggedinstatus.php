<?php

session_start();

if ($_SESSION['UserLoggedIn'] == true){

} else {
    header('Location: ' . "login.php");
}