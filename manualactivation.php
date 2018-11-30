<?php

include_once "Controllers/mysql_operations.php";
include_once "../Controllers/mysql_operations.php";

$mysql_operations = new mysql_operations();

?>

<h1>User activation</h1>

<?php
include_once  "navigationbar.php";
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Activation code:
    <div>
    <input type="text" name="ActivationCode" value=""><span class="error">* <?php echo $UserNameErr;?></span>
    <br><br>
    <input type="submit" name="submit" value="Activate">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $successful = $mysql_operations->activateUserNoName($_POST["ActivationCode"]);
    if ($successful) {
        header('Location: ' . "index.php");
    } else {
        echo "Activation is not successful";
        header('Location: ' . "manualactivation.php");
    }
}
 ?>