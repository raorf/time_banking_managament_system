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
            return "";
        }
    }

    function setUserNameToCookies($UserName){
            $_COOKIE['UserName'] = $UserName;
            return true;
        }
}