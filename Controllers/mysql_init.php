<?php


    ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . dirname(__FILE__));

    $servername = "localhost";
    $username = "root";
    $password = "";

    // Create connection
    $conn = new mysqli($servername, $username, $password);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    echo "Connected successfully";


    //Create DB if doesn't exist
    $sql = "CREATE DATABASE IF NOT EXISTS time_banking_management_system";
    if ($conn->query($sql) === TRUE) {
        echo "Database created successfully";
        $sql = "USE time_banking_management_system";
        $conn->query($sql);
    } else {
        echo "Error creating database: " . $conn->error;
    }

    if (!$conn->connect_error) {
        $create_tables = file_get_contents('../Resources/create_tables.sql');
        if ($conn->multi_query($create_tables) === TRUE) {
            echo "Tables created successfully";
        } else {
            echo "Error creating tables: " . $conn->error;
        }
    }

?>