<?php

include_once "Properties/configuration.php";
include_once "../Properties/configuration.php";
ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . dirname(__FILE__));

class mysql_operations
{
    public $conn = null;

    function __construct() {
        $this->createConnection();
    }

    function createConnection(){
        $servername = configuration::MYSQL_HOSTNAME;
        $database = configuration::MYSQL_DATABASENAME;
        $username = configuration::MYSQL_USERNAME;
        $password = configuration::MYSQL_PASSWORD;

        // Create connection
        $conn = new mysqli($servername, $username, $password);
        $this->conn = $conn;

        //Select database
        $sql = "USE $database";
        $this->conn->query($sql);
    }

    function doGetUserDetails($UserName){
        $sql = "
            SELECT User.UserID, User.UserName, User.UserEmail, UserSkill.UserSkill
            FROM UserSkill 
            INNER JOIN User ON UserSkill.UserID = User.UserID
            WHERE UserName='$UserName';
        ";

        $result = $this->conn->query($sql);
        $returnable = null;
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<h3>Id: ".$row["UserID"]."<br>Name: ".$row["UserName"]."<br>Email: ".$row["UserEmail"]."<br>Skills: ".$row["UserSkill"]."</h3>";
            }
        } else {
            echo "Unable to get user details...";
        }


    }

    function doSearchTasks($Skill="", $Location="", $Sort=""){
        $sql = "SELECT TaskID, TaskActive, TaskUserName, TaskDescription, TaskLocation, TaskRequiredSkills, TaskCredit FROM Task WHERE TaskActive=1 AND TaskLocation LIKE '%$Location%' AND TaskRequiredSkills LIKE '%$Skill%'";

        if ($Sort == 'Location'){
            $sql .= " ORDER BY TaskLocation";
        }

        if ($Sort == 'Skill'){
            $sql .= " ORDER BY TaskRequiredSkills";
        }

        if ($Sort == 'Id'){
            $sql .= " ORDER BY TaskID";
        }

        if ($Sort == 'Active'){
            $sql .= " ORDER BY TaskActive";
        }

        if ($Sort == 'UserName'){
            $sql .= " ORDER BY TaskUserName";
        }

        if ($Sort == 'Credit'){
            $sql .= " ORDER BY TaskCredit";
        }

        $result = $this->conn->query($sql);


        if ($result->num_rows > 0) {
            echo "<table class=\"table table-striped\">";    // output data of each row
            echo "<tr><th><a href=\"?Sort=Id\">Id</a></th><th><a href=\"?Sort=Active\">Active</a></th><th><a href=\"?Sort=UserName\">User name</a></th><th>Description</th><th><a href=\"?Sort=Location\">Location</a></th><th><a href=\"?Sort=Skill\">Required skills</a></th><th><a href=\"?Sort=Credit\">Credit</a></th><th>Actions</th></tr>";
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["TaskID"].
                    "</td><td>" . $row["TaskActive"].
                    "</td><td>" . $row["TaskUserName"].
                    "</td><td>" . $row["TaskDescription"].
                    "</td><td>" . $row["TaskLocation"].
                    "</td><td>" . $row["TaskRequiredSkills"].
                    "</td><td>" . $row["TaskCredit"].
                    "</td><td><a href=\"viewuserdetails.php?UserName=".$row["TaskUserName"]."\">View details</a>".
                    "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "0 results";
        }
        $this->conn->close();
    }

    function doUpdateTask($TaskID, $TaskActive, $TaskDescription, $TaskLocation, $TaskRequiredSkills, $TaskCredit){
        $sql = "UPDATE Task SET TaskActive='$TaskActive', TaskDescription='$TaskDescription', TaskLocation='$TaskLocation', TaskRequiredSkills='$TaskRequiredSkills', TaskCredit='$TaskCredit' WHERE TaskID='$TaskID'";

        if ($this->conn->query($sql) === TRUE) {
            print "task updated succesfully";
        } else {
            print "Error updating task: ";
            echo "Error: " . $sql . "<br>" . $this->conn->error;
        }

        $sql = "SELECT TaskID FROM Task WHERE TaskUserName='$UserName' AND TaskActive=1 AND TaskDescription='$TaskDescription' AND TaskLocation='$TaskLocation' AND TaskRequiredSkills='$TaskRequiredSkills' AND TaskCredit='$TaskCredit'";

        $result = $this->conn->query($sql);
        $returnable = null;
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $returnable =  $row["TaskID"];
            }
        } else {
            echo "Unable to determine Task ID.";
        }

        echo "TaskID is ".$returnable;
        return $returnable;

    }

    function getPostDetails($TaskID){
        $sql = "SELECT TaskID, TaskActive, TaskDescription, TaskLocation, TaskRequiredSkills, TaskCredit FROM Task WHERE TaskID='$TaskID'";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $_SESSION['TaskID'] = $row["TaskID"];
                $_SESSION['TaskActive'] = $row["TaskActive"];
                $_SESSION['TaskDescription'] = $row["TaskDescription"];
                $_SESSION['TaskLocation'] = $row["TaskLocation"];
                $_SESSION['TaskRequiredSkills'] = $row["TaskRequiredSkills"];
                $_SESSION['TaskCredit'] = $row["TaskCredit"];
            }
        } else {
            echo "0 results";
        }

        $this->conn->close();
    }

    function doDeleteTask($TaskID){
        $sql = "DELETE FROM Task WHERE TaskID='$TaskID'";

        if ($this->conn->query($sql) === TRUE) {
            print "Post deleted successfully";
            return True;
        } else {
            print "Error deleting post: ";
            echo "Error: " . $sql . "<br>" . $this->conn->error;
            return False;
        }
    }

    function doListUserTasks($UserName){
        $sql = "SELECT TaskID, TaskActive, TaskUserName, TaskDescription, TaskLocation, TaskRequiredSkills, TaskCredit FROM Task WHERE TaskUserName='$UserName'";
        $result = $this->conn->query($sql);


        if ($result->num_rows > 0) {
        echo "<table class=\"table table-striped\">";    // output data of each row
        echo "<tr><th>Id</th><th>Active</th><th>User name</th><th>Description</th><th>Location</th><th>Required skills</th><th>Credit</th><th>Actions</th></tr>";
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["TaskID"].
                    "</td><td>" . $row["TaskActive"].
                    "</td><td>" . $row["TaskUserName"].
                    "</td><td>" . $row["TaskDescription"].
                    "</td><td>" . $row["TaskLocation"].
                    "</td><td>" . $row["TaskRequiredSkills"].
                    "</td><td>" . $row["TaskCredit"].
                    "</td><td><a href=\"Models/do_deletetask.php?TaskID=".$row["TaskID"]."\">delete</a> <a href=\"edittask.php?TaskID=".$row["TaskID"]."\">edit</a>".
                    "</td></tr>";
            }
        echo "</table>";
        } else {
            echo "0 results";
        }
        $this->conn->close();
    }

    function doInsertTaskImage($TaskID, $TaskImage){

        $sql = "INSERT INTO TaskImage (TaskID, TaskImage) VALUES ('$TaskID', '$TaskImage')";

        if ($this->conn->query($sql) === TRUE) {
            print "task image inserted into table successfully";
            return True;
        } else {
            print "Error inserting task image into database: ";
            echo "Error: " . $sql . "<br>" . $this->conn->error;
            return False;
        }
    }

    function doInsertTask($UserName, $TaskDescription, $TaskLocation, $TaskRequiredSkills, $TaskCredit){
        $sql = "INSERT INTO Task (TaskUserName, TaskActive, TaskDescription, TaskLocation, TaskRequiredSkills, TaskCredit)
                          VALUES ('$UserName', 1, '$TaskDescription', '$TaskLocation', '$TaskRequiredSkills', '$TaskCredit')";

        if ($this->conn->query($sql) === TRUE) {
            print "task inserted into table succesfully";
        } else {
            print "Error inserting task into database: ";
            echo "Error: " . $sql . "<br>" . $this->conn->error;
        }

        $sql = "SELECT TaskID FROM Task WHERE TaskUserName='$UserName' AND TaskActive=1 AND TaskDescription='$TaskDescription' AND TaskLocation='$TaskLocation' AND TaskRequiredSkills='$TaskRequiredSkills' AND TaskCredit='$TaskCredit'";

        $result = $this->conn->query($sql);
        $returnable = null;
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $returnable =  $row["TaskID"];
            }
        } else {
            echo "Unable to determine Task ID.";
        }

        echo "TaskID is ".$returnable;
        return $returnable;

    }

    function doRegisterUserInactive($UserName, $UserEmail, $UserPassword, $UserCaptcha, $UserSkills){
        $UserActive = 0;
        $UserPassword = password_hash($UserPassword, PASSWORD_BCRYPT);

        $query = "INSERT INTO User (UserName, UserEmail, UserPassword, UserCaptcha, UserActive) VALUES ('$UserName', '$UserEmail', '$UserPassword', '$UserCaptcha', '$UserActive')";
        if ($this->conn->query($query) === TRUE) {
            print "User inserted into table succesfully";
        } else {
            print "Error inserting user into database: ";
            echo "Error: " . $query . "<br>" . $this->conn->error;
        }

        $userId = $this->getMaxIdValue("User", "UserID");

        $query = "INSERT INTO UserSkill (UserSkill, UserID) VALUES ('$UserSkills', '$userId')";
        if ($this->conn->query($query) === TRUE) {
            print "User skill(s) inserted into table succesfully";
        } else {
            print "Error inserting user skill(s) into database: ";
        }
    }

    function getMaxIdValue($table, $column){
        $query = "SELECT MAX($column) FROM $table";
        $result = $this->conn->query($query);
        $returnable = null;
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $returnable =  $row["MAX($column)"];
            }
        } else {
            echo "Unable to determine Maximum ID value of column $column in database $table";
        }
        return $returnable;
    }

    function checkAccountActivation($UserName){
        $query = "SELECT UserActive FROM User WHERE UserName='$UserName'";
        $result = $this->conn->query($query);
        $returnable = null;
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $returnable =  $row["UserActive"];
            }
        } else {
            echo "Unable to get activation state for user $UserName.";
        }
        return $returnable;
    }

    function getPassword($UserName){
        $query = "SELECT UserPassword FROM User WHERE UserName='$UserName'";
        $result = $this->conn->query($query);
        $returnable = null;
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $returnable =  $row["UserPassword"];
            }
        } else {
            echo "Unable to get password for user $UserName.";
        }
        return $returnable;
    }

    function doVerifyPassword($UserName, $UserPassword){
        $db_password = $this->getPassword($UserName);
//        print "Verifying passwords: ".$UserPassword." and ".$db_password;
        return password_verify($UserPassword, $db_password);
    }

    function doLogin($UserName, $UserPassowrd){
        $login_success = $this->doVerifyPassword($UserName, $UserPassowrd);
        return $login_success;
    }

    function activateUser($UserName, $UserCaptcha){
        $query = "UPDATE User SET UserActive=1 WHERE UserName = '$UserName' AND UserCaptcha = '$UserCaptcha'";
        if ($this->conn->query($query) === TRUE) {
            return true;
        } else {
            print "Error activating user";
            echo "Error: " . $query . "<br>" . $this->conn->error;
            return false;
        }
    }

    function activateUserNoName($UserCaptcha){
        $query = "UPDATE User SET UserActive=1 WHERE UserCaptcha = '$UserCaptcha'";
        if ($this->conn->query($query) === TRUE) {
            return true;
        } else {
            print "Error activating user";
            echo "Error: " . $query . "<br>" . $this->conn->error;
            return false;
        }
    }

    function userNameExists($UserName){
        $query = "SELECT UserID FROM mdb_ma6912b.User WHERE UserName='$UserName'";
        $result = $this->conn->query($query);
        $returnable = null;
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                echo $row["UserID"];
                $returnable =  $row["UserID"];
            }
        } else {
            fwrite(STDOUT, "Error in userNameExists()" . "\n");
        }
        if ($returnable > 0){
            fwrite(STDOUT, "User exists" . "\n");
            return true;
        } else {
            fwrite(STDOUT, "User does not exist" . "\n");
            return false;
        }
    }

}