<?php



session_start();
$_SESSION['UserLoggedIn'] = false;

header('Location: ' . "../index.php");