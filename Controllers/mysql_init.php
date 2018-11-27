<?php
//    ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . dirname(__FILE__));

    $servername = "mysql.cms.gre.ac.uk";
    $username = "ma6912b";
    $password = "ma6912b";

    // Create connection
    $conn = new mysqli($servername, $username, $password);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    //Create DB if doesn't exist
    $sql = "CREATE DATABASE IF NOT EXISTS `mdb_ma6912b`";
    if ($conn->query($sql) === TRUE) {
        $sql = "USE mdb_ma6912b";
        $conn->query($sql);
    } else {
        echo "Error creating database: " . $conn->error;
    }

    if (!$conn->connect_error) {
        $create_tables = file_get_contents('Resources/create_tables.sql');
        if ($conn->multi_query($create_tables) === TRUE) {
        } else {
            echo "Error creating tables: " . $conn->error;
        }
    }

?>