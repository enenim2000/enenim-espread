<?php
class DBConnector{
    public static function getConnector(){


        $servername = "localhost"; 
        $username = "root"; 
        $password = "password";
        $dbname = "db_test";

        // Create connection
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        
        return $conn;
    }
}

/*
if (DBConnector::getConnector()){
    echo 'Connection successful again';
}*/
