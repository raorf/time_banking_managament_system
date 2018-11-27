<?php
/**
 * Created by PhpStorm.
 * User: aleks
 * Date: 04/11/2018
 * Time: 01:13
 */

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
}