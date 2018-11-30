<?php

include_once "Controllers/mysql_operations.php";
include_once "../Controllers/mysql_operations.php";
include_once "Models/do_checkloggedinstatus.php";
include_once "Models/do_edittask.php";
include_once "../Models/do_checkloggedinstatus.php";
include_once "../Models/do_edittask.php";


if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $_SESSION['TaskID'] = $_GET["TaskID"];
    $msql = new mysql_operations();
    $msql->getPostDetails($_GET["TaskID"]);
}


?>

<html>
<head>
    <style>
        .error {color: #FF0000;}
    </style>
</head>
<body>

<h1>Edit task</h1>>

<?php
include_once  "navigationbar.php";
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
    Active: <input type="text" name="TaskActive" value="<?=$_SESSION['TaskActive']?>"><span class="error">* <?php echo $TaskActiveErr;?></span>
    <br><br>
    Task description: <input type="text" name="TaskDescription" value="<?=$_SESSION['TaskDescription']?>"><span class="error">* <?php echo $TaskDescriptionErr;?></span>
    <br><br>
    Location: <input type="text" name="TaskLocation" value="<?=$_SESSION['TaskLocation']?>"><span class="error">* <?php echo $TaskLocationErr;?></span>
    <br><br>
    Required skills: <input type="text" name="TaskRequiredSkills" value="<?=$_SESSION['TaskRequiredSkills']?>"><span class="error">* <?php echo $TaskRequiredSkillsErr;?></span>
    <br><br>
    Credit: <input type="text" name="TaskCredit" value="<?=$_SESSION['TaskCredit']?>"><span class="error">* <?php echo $TaskCreditErr;?></span>
    <br><br>
    <input type="submit" name="submit" value="Submit">
</form>

</body>
</html>