<?php
class DBConnector{
    public static function getConnector(){


        $servername = "localhost"; //$servername = "bassey.dqdemos.com";
        $username = "root"; //$username = "dqdemosc_bassey";
        $password = ""; //$password = "Bassey*123#";
        $dbname = "dqdemosc_bassey";


        /*
        $servername = "localhost"; //$servername = "bassey.dqdemos.com";
        $username = "dqdemosc_bassey"; //$username = "dqdemosc_bassey";
        $password = "Bassey*123#"; //$password = "Bassey*123#";
        $dbname = "dqdemosc_bassey";
        */

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