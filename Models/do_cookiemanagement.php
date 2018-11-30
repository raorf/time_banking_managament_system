<?php

class do_cookiemanagement
{
    function getUserNameFromCookies(){
        if(isset($_COOKIE['UserName'])){
            return $_COOKIE['UserName'];
        } else {
            return "No username set to cookies";
        }
    }

    function setUserNameToCookies($UserName){
        setcookie("UserName", $UserName, time() + (86400 * 30), "/"); // 86400 = 1 day

        if(!isset($_COOKIE["UserName"])) {
            echo "Cookie named UserName is not set!";
        } else {
            echo "Cookie UserName is set!<br>";
            echo "Value is: " . $_COOKIE["UserName"];
        }

        return true;
    }

    function getLocationFromCookies(){
        if(isset($_COOKIE['Location'])){
            return $_COOKIE['Location'];
        } else {
            return "";
        }
    }

    function setLocationToCookies($Location){
        setcookie("Location", $Location, time() + (86400 * 30), "/"); // 86400 = 1 day

//        if(!isset($_COOKIE["Location"])) {
//            echo "Cookie named Location is not set!";
//        } else {
//            echo "Cookie Location is set!<br>";
//            echo "Value is: " . $_COOKIE["Location"];
//        }

        return true;
    }

    function getSkillFromCookies(){
        if(isset($_COOKIE['Skill'])){
            return $_COOKIE['Skill'];
        } else {
            return "";
        }
    }

    function setSkillToCookies($Skill){
        setcookie("Skill", $Skill, time() + (86400 * 30), "/"); // 86400 = 1 day

//        if(!isset($_COOKIE["Skill"])) {
//            echo "Cookie named Skill is not set!";
//        } else {
//            echo "Cookie Skill is set!<br>";
//            echo "Value is: " . $_COOKIE["Skill"];
//        }

        return true;
    }
}