<?php
/**
 * Created by PhpStorm.
 * User: aleksandrsk
 * Date: 11/21/18
 * Time: 9:37 PM
 */


session_start();
$_SESSION['UserLoggedIn'] = false;

header('Location: ' . "../index.php");