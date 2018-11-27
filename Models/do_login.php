<?php
/**
 * Created by PhpStorm.
 * User: aleks
 * Date: 04/11/2018
 * Time: 00:53
 */

include_once "Controllers/mysql_operations.php";
include_once "Models/do_cookiemanagement.php";
include_once "../Controllers/mysql_operations.php";
include_once "../Models/do_cookiemanagement.php";
session_start();

//Variable initialisation
$UserName = $UserPassword = $UserCaptcha = "";
$UserNameErr = $UserPasswordErr = $UserCaptchaErr = "";
$formValid = true;
$_SESSION['UserLoggedIn'] = false;

//Validation bit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Storing all the var's in a session in order to recover the fields if validation fails.
    $_SESSION['UserName'] = $_POST["UserName"];
    $_SESSION['UserPassword'] = $_POST["UserPassword"];


    if (empty($_POST["UserName"])) {
        $UserNameErr = "Name is required";
        $formValid = false;
    } else {
        $UserName = test_input($_POST["UserName"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z]*$/",$UserName)) {
            $UserNameErr = "Only letters are allowed";
            $formValid = false;
        }
    }

    if (empty($_POST["UserPassword"])) {
        $UserPasswordErr = "Password is required";
        $formValid = false;
    } else {
        $UserPassword = test_input($_POST["UserPassword"]);
        // check if URL address syntax is valid (this regular expression also allows dashes in the URL)
        if (!preg_match("^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$^",$UserPassword)) {
            $UserPasswordErr = "Password has to be at least 8 characters long. Must contain at least one lowercase letter, one uppercase letter and one number.";
            $formValid = false;
        }
    }

    if (empty($_POST["UserCaptcha"])) {
        $UserCaptchaErr = "Captcha is required";
        $formValid = false;
    } else {
        $UserCaptcha = test_input($_POST["UserCaptcha"]);
        // check if URL address syntax is valid (this regular expression also allows dashes in the URL)
        $GeneratedCaptcha = $_SESSION['GeneratedCaptcha'];
        if ($UserCaptcha != $GeneratedCaptcha) {
            $UserCaptchaErr = "Captcha does not match..";
            $formValid = false;
        }
    }

    if ($formValid){
        $mysqlOps = new mysql_operations();
        $login_success = $mysqlOps->doLogin(
            $_POST['UserName'],
            $_POST['UserPassword']
        );

        if ($login_success) {
            $account_activated = $mysqlOps->checkAccountActivation($_POST['UserName']);

            if (!$account_activated){
                $UserNameErr = "Account is not activated";
                $formValid = false;
            } else {
                $cm = new do_cookiemanagement();
                $cm->setUserNameToCookies($_POST['UserName']);
                $_SESSION['UserLoggedIn'] = true;
                echo "Succefully logged in ".$_POST['UserName'];
                sleep(1);
                header('Location: ' . "index.php");
            }
        } else{
            $UserNameErr = "Username or password is incorrect";
            $formValid = false;
        }

    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}