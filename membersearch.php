<?php

include_once "Controllers/mysql_operations.php";
include_once "../Controllers/mysql_operations.php";
include_once "Models/do_cookiemanagement.php";
include_once "../Models/do_cookiemanagement.php";

$cook = new do_cookiemanagement();
if ($_SESSION['Skills'] == null){
    $_SESSION['Skills'] = $cook->getSkillFromCookies();
}

if ($_SESSION['Location'] == null){
    $_SESSION['Location'] = $cook->getLocationFromCookies();
}



$msql = new mysql_operations();

?>


<h1>Member search</h1>

<?php
include_once  "navigationbar.php";
?>

<h3>Search parameters:</h3>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
Skills: <input type="text" name="Skills" value="<?=$_SESSION['Skills']?>"><span class="error">* <?php echo $UserNameErr;?></span>
Location: <input type="text" name="Location" value="<?=$_SESSION['Location']?>"><span class="error">* <?php echo $UserPasswordErr;?></span>
<input type="submit" name="submit" value="Search">
</form>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['Skills'] = $_POST["Skills"];
    $_SESSION['Location'] = $_POST["Location"];
    $cook -> setSkillToCookies($_POST["Skills"]);
    $cook -> setLocationToCookies($_POST["Location"]);
}

$msql->doSearchTasks($_SESSION['Skills'], $_SESSION['Location'], $_GET["Sort"]);


?>