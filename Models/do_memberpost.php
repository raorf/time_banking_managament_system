<?php
/**
 * Created by PhpStorm.
 * User: aleksandrsk
 * Date: 11/24/18
 * Time: 8:43 PM
 */

include_once "Controllers/mysql_operations.php";
include_once "Models/do_cookiemanagement.php";
include_once "../Controllers/mysql_operations.php";
include_once "../Models/do_cookiemanagement.php";

session_start();

//Variable initialisation
$TaskDescription = $TaskLocation = $TaskRequiredSkills = $TaskCredit = "";
$TaskDescriptionErr = $TaskLocationErr = $TaskRequiredSkillsErr = $TaskCreditErr = "";
$formValid = true;


//Validation bit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['TaskDescription'] = $_POST["TaskDescription"];
    $_SESSION['TaskLocation'] = $_POST["TaskLocation"];
    $_SESSION['TaskRequiredSkills'] = $_POST["TaskRequiredSkills"];
    $_SESSION['TaskCredit'] = $_POST["TaskCredit"];

    if (empty($_POST["TaskDescription"])) {
        $TaskDescriptionErr = "Description is required";
        $formValid = false;
    } else {
        $TaskDescription = test_input($_POST["TaskDescription"]);
        if (!preg_match("/^[0-9a-zA-Z ]*$/",$TaskDescription)) {
            $TaskDescriptionErr = "Only letters, numbers and whitespaces are allowed";
            $formValid = false;
        }

    }

    if (empty($_POST["TaskLocation"])) {
        $TaskLocationErr = "Task location is required";
        $formValid = false;
    } else {
        $TaskLocation = test_input($_POST["TaskLocation"]);
        if (!preg_match("/^[0-9a-zA-Z ]*$/",$TaskLocation)) {
            $TaskLocationErr = "Only letters, numbers and whitespaces are allowed";
            $formValid = false;
        }

    }

    if (empty($_POST["TaskRequiredSkills"])) {
        $TaskRequiredSkillsErr = "Task skills are required";
        $formValid = false;
    } else {
        $TaskRequiredSkills = test_input($_POST["TaskRequiredSkills"]);
        if (!preg_match("/^[0-9a-zA-Z ]*$/",$TaskRequiredSkills)) {
            $TaskRequiredSkillsErr = "Only letters, numbers and whitespaces are allowed";
            $formValid = false;
        }

    }

    if (empty($_POST["TaskCredit"])) {
        $TaskCreditErr = "Task credit is required";
        $formValid = false;
    } else {
        $TaskCredit = test_input($_POST["TaskCredit"]);
        if (!preg_match("/^[0-9.]*$/",$TaskCredit)) {
            $TaskCreditErr = "Only letters, numbers and whitespaces are allowed";
            $formValid = false;
        }

    }


    if ($formValid){
        $cm = new do_cookiemanagement();
        $UserName = $cm->getUserNameFromCookies();

        $mysqlOps = new mysql_operations();

        $_SESSION['CurrentTaskID'] = $mysqlOps->doInsertTask(
            $UserName,
            $_SESSION['TaskDescription'],
            $_SESSION['TaskLocation'],
            $_SESSION['TaskRequiredSkills'],
            $_SESSION['TaskCredit']
        );

        $_SESSION['TaskDescription'] = null;
        $_SESSION['TaskLocation'] = null;
        $_SESSION['TaskRequiredSkills'] = null;
        $_SESSION['TaskCredit'] = null;

        echo "Task added successfully! Redirecting to image upload...";
//        sleep(3);
        header('Location: '."uploadimage.php");
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

