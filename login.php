<?php
/**
 * Created by PhpStorm.
 * User: aleks
 * Date: 03/11/2018
 * Time: 22:43
 */
include_once "Properties/configuration.php";
include_once "Models/do_login.php";
include_once "Captcha/generate_captcha.php";
include_once "Models/do_cookiemanagement.php";

$generate_captcha = new generate_captcha();
$GeneratedCaptcha = $generate_captcha->randomKey();
$_SESSION['GeneratedCaptcha'] = $GeneratedCaptcha;
$cook = new do_cookiemanagement();

//echo "User login: ".$cook->getUserNameFromCookies();

?>

<html>
<head>
    <style>
        .error {color: #FF0000;}
    </style>
</head>
<body>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Name: <input type="text" name="UserName" value="<?=$cook->getUserNameFromCookies();?>"><span class="error">* <?php echo $UserNameErr;?></span>
<br><br>
Password: <input type="password" name="UserPassword" value="<?=$_SESSION['UserPassword']?>"><span class="error">* <?php echo $UserPasswordErr;?></span>
<br><br>
<img src="Captcha/render_captcha.php?s=FFFFFF_00_173_50&t=<?=$GeneratedCaptcha?>" alt="Error while generating captcha text...">
<br><br>
Please enter text from image in the form below (case sensitive):
<br><br>
<input type="text" name="UserCaptcha"><span class="error">* <?php echo $UserCaptchaErr;?></span>
<br><br>
<input type="submit" name="submit" value="Log In">
</form>