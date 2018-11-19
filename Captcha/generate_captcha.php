<?php
/**
 * Created by PhpStorm.
 * User: aleks
 * Date: 02/11/2018
 * Time: 17:45
 */
include_once "Properties/configuration.php";

class generate_captcha
{
    function randomKey($length = configuration::CAPTCHA_LENGTH) {
        $pool = array_merge(range(0,9), range('a', 'z'),range('A', 'Z'));
        $key = "";

        for($i=0; $i < $length; $i++) {
            $key .= $pool[mt_rand(0, count($pool) - 1)];
        }
        return $key;
    }

}