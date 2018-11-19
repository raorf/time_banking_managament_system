<?php
/**
 * Created by PhpStorm.
 * User: aleks
 * Date: 03/11/2018
 * Time: 20:04
 */
include_once "../Properties/configuration.php";
ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . dirname(__FILE__));

class mysql_operations
{
    public $conn = null;

    function __construct() {
        $this->createConnection();
        print "Initiated instance of mysql_operations. Connection to DB has been created";
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

//UserName
//UserEmail
//UserPassword
//UserCaptcha
//UserActive
//UserSkills

    function doRegisterUserInactive($UserName, $UserEmail, $UserPassword, $UserCaptcha, $UserSkills){
        $UserActive = false;
        $UserPassword = password_hash($UserPassword, PASSWORD_BCRYPT);

        $query = "INSERT INTO user (UserName, UserEmail, UserPassword, UserCaptcha, UserActive) VALUES ('$UserName', '$UserEmail', '$UserPassword', '$UserCaptcha', '$UserActive')";
        if ($this->conn->query($query) === TRUE) {
            print "User inserted into table succesfully";
        } else {
            print "Error inserting user into database: ";
            echo "Error: " . $query . "<br>" . $this->conn->error;
        }
        $userId = $this->getMaxIdValue("user", "UserID");

        $query = "INSERT INTO userskill (UserSkill, UserID) VALUES ('$UserSkills', '$userId')";
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

    function doActivateUser($UserCaptcha, $UserEmail){

    }

    function checkAccountActivation($UserName){
        $query = "SELECT UserActive FROM user WHERE UserName='$UserName'";
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
        $query = "SELECT UserPassword FROM user WHERE UserName='$UserName'";
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
        print "Verifying passwords: ".$UserPassword." and ".$db_password;
        return password_verify($UserPassword, $db_password);
    }

    function doLogin($UserName, $UserPassowrd){
        $login_success = $this->doVerifyPassword($UserName, $UserPassowrd);
        return $login_success;
    }

    function activateUser($UserName, $UserCaptcha){
        $query = "UPDATE user SET UserActive=1 WHERE UserName = '$UserName' AND UserCaptcha = '$UserCaptcha'";
        if ($this->conn->query($query) === TRUE) {
            return true;
        } else {
            print "Error activating user";
            echo "Error: " . $query . "<br>" . $this->conn->error;
            return false;
        }
    }
}