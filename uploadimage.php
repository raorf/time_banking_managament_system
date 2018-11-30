<?php

session_start();

?>

<h1>Registration</h1>

<?php
include_once  "navigationbar.php";
?>

<html>
<body>
<h1>Uploading image for task id: <?=$_SESSION['CurrentTaskID']?> </h1>
<h2><p><a href="index.php">Skip / Finish image upload</a></p></h2>
<form method="POST" action="Models/do_upload_file.php" enctype="multipart/form-data">
    <input type="file" name="myimage">
    <input type="submit" name="submit_image" value="Upload">
</form>

</body>
</html>