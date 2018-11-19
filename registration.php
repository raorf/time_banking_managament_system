<?php
include_once "Models/do_registration.php";
include_once "Captcha/generate_captcha.php";
$generate_captcha = new generate_captcha();
$GeneratedCaptcha = $generate_captcha->randomKey();
$_SESSION['GeneratedCaptcha'] = $GeneratedCaptcha;
?>

<html>
<head>
    <style>
        .error {color: #FF0000;}
    </style>
</head>
<body>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Name: <input type="text" name="UserName" value="<?=$_SESSION['UserName']?>"><span class="error">* <?php echo $UserNameErr;?></span>
    <br><br>
    E-mail: <input type="email" name="UserEmail" value="<?=$_SESSION['UserEmail']?>"><span class="error">* <?php echo $UserEmailErr;?></span>
    <br><br>
    Password: <input type="password" name="UserPassword" value="<?=$_SESSION['UserPassword']?>"><span class="error">* <?php echo $UserPasswordErr;?></span>
    <br><br>
    Skills: <input type="text" name="UserSkills" value="<?=$_SESSION['UserSkills']?>"><span class="error">* <?php echo $UserSkillsErr;?></span>
    <br><br>
    <img src="Captcha/render_captcha.php?s=FFFFFF_00_173_50&t=<?=$GeneratedCaptcha?>" alt="Error while generating captcha text...">
    <br><br>
    Please enter text from image in the form below (case sensitive):
    <input type="text" name="UserCaptcha"><span class="error">* <?php echo $UserCaptchaErr;?></span>
    <br><br>
    <input type="submit" name="submit" value="Submit">
</form>

</body>
</html>