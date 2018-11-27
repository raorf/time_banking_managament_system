<html>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

<?php
/**
 * Created by PhpStorm.
 * Date: 28/10/2018
 * Time: 23:10
 */
include_once "Models/do_cookiemanagement.php";
include_once "../Models/do_cookiemanagement.php";

session_start();

$cm = new do_cookiemanagement();

echo "   
   <style>
        h1  {
          color: grey;
          position: relative; 
          right: -10px;
          top: 5px;
        }
        form  {
          position: relative; 
          right: -10px;
        }
   </style>
   ";
echo "<h2>";

if ($_SESSION['UserLoggedIn'] == true){
echo "
    <form>
    <div class=\"btn-group\" role=\"group\" aria-label=\"Logged in user\">
    <button type=\"submit\" class=\"btn btn-light\" formaction=\"membersearch.php\">Member search</button>
    <button type=\"submit\" class=\"btn btn-light\" formaction=\"memberpost.php\">Create post</button>
    <button type=\"submit\" class=\"btn btn-light\" formaction=\"listposts.php\">List posts</button>
    <button type=\"submit\" class=\"btn btn-light\" formaction=\"Models/do_logout.php\">Log out</button>
    </div>
    </form>
    ";
} else {
    echo "
   <form>
   <div class=\"btn-group\" role=\"group\" aria-label=\"Anonymous\">
   <button type=\"submit\" class=\"btn btn-light\" formaction=\"membersearch.php\">Member search</button>
    <button type=\"submit\" class=\"btn btn-light\" formaction=\"login.php\">Log in</button>
    <button type=\"submit\" class=\"btn btn-light\" formaction=\"registration.php\">Registration</button>  
    </div>
    </form>
    ";
}

echo "</h2>";
?>

</html>