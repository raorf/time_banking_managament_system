<?php


include_once "Controllers/mysql_operations.php";
include_once  "Models/do_email.php";

session_start();

//Variable initialisation
$UserName = $UserEmail = $UserPassword = $UserSkills = $UserCaptcha = "";
$UserNameErr = $UserEmailErr = $UserPasswordErr = $UserSkillsErr = $UserCaptchaErr = "";
$GeneratedCaptcha = $_SESSION['GeneratedCaptcha'];
$formValid = true;

//Validation bit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Storing all the var's in a session in order to recover the fields if validation fails.
    $_SESSION['UserName'] = $_POST["UserName"];
    $_SESSION['UserEmail'] = $_POST["UserEmail"];
    $_SESSION['UserPassword'] = $_POST["UserPassword"];
    $_SESSION['UserSkills'] = $_POST["UserSkills"];
    $_SESSION['UserCaptcha'] = $_POST["UserCaptcha"];

    if (empty($_POST["UserName"])) {
        $UserNameErr = "Name is required";
        $formValid = false;
    } else {
        $UserName = test_input($_POST["UserName"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[0-9a-zA-Z]*$/",$UserName)) {
            $UserNameErr = "Only letters and numbers are allowed";
            $formValid = false;
        }

    }


    $mysqlOps = new mysql_operations();

    if ($mysqlOps -> userNameExists($_SESSION['UserName'])) {
        $formValid = false;
        $UserNameErr = "Username already exists, please select a different one.";
    }

    if (empty($_POST["UserEmail"])) {
        $UserEmailErr = "Email is required";
        $formValid = false;
    } else {
        $UserEmail = test_input($_POST["UserEmail"]);
        // check if e-mail address is well-formed
        if (!filter_var($UserEmail, FILTER_VALIDATE_EMAIL)) {
            $UserEmailErr = "Invalid email format";
            $formValid = false;
        }
    }

    if (empty($_POST["UserSkills"])) {
        $UserSkillsErr = "Name is required";
        $formValid = false;
    } else {
        $UserName = test_input($_POST["UserSkills"]);
        if (!preg_match("/^[0-9a-zA-Z ,;]*$/",$UserSkills)) {
            $UserSkillsErr = "Only letters and numbers are allowed";
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
        if ($UserCaptcha != $GeneratedCaptcha) {
            $UserCaptchaErr = "Captcha does not match..";
            $formValid = false;
        }
    }

    if ($formValid){
        $mysqlOps = new mysql_operations();

        $mysqlOps->doRegisterUserInactive(
            $_SESSION['UserName'],
            $_SESSION['UserEmail'],
            $_SESSION['UserPassword'],
            $_SESSION['UserCaptcha'],
            $_SESSION['UserSkills']
        );

        $reg = new do_email();
        $activation_link = $reg->constructActivationLink($_SESSION['UserCaptcha'], $_SESSION['UserName']);
        $reg->sendActivationEmail($_SESSION['UserEmail'], $activation_link, $_SESSION['UserCaptcha']);

        $_SESSION['UserEmail'] = null;
        $_SESSION['UserPassword'] = null;
        $_SESSION['UserCaptcha'] = null;
        $_SESSION['UserSkills'] = null;

        header('Location: '."login.php");
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

