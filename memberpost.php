<?php

include_once "Models/do_checkloggedinstatus.php";
include_once "Models/do_memberpost.php";
include_once "../Models/do_checkloggedinstatus.php";
include_once "../Models/do_memberpost.php";


?>

<html>
<head>
    <style>
        .error {color: #FF0000;}
    </style>
</head>
<body>

<h1>Member Post:</h1>

<?php
include_once  "navigationbar.php";
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
<div class="form-group">
<br>
Task description:
    <div>
<input type="text" name="TaskDescription" value="<?=$_SESSION['TaskDescription']?>"><span class="error">* <?php echo $TaskDescriptionErr;?></span>
<br><br>
Location:
    <div>
<input type="text" name="TaskLocation" value="<?=$_SESSION['TaskLocation']?>"><span class="error">* <?php echo $TaskLocationErr;?></span>
<br><br>
<div>
Required skills:
    <div>
<input type="text" name="TaskRequiredSkills" value="<?=$_SESSION['TaskRequiredSkills']?>"><span class="error">* <?php echo $TaskRequiredSkillsErr;?></span>
<br><br>
Credit:
<div>
<input type="text" name="TaskCredit" value="<?=$_SESSION['TaskCredit']?>"><span class="error">* <?php echo $TaskCreditErr;?></span>
<br><br>
<input type="submit" name="submit" value="Submit">
</div>
</form>

</body>
</html>