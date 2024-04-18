<?php

//MySQLi Procedural
 $servername = "localhost";
 $username = "root";
 $password = "";
 $dbname = "cbqs";

// Configurasi Web Hosting
//$servername = "127.0.0.1";
//$username = "localhost";
//$password = "";
//$dbname = "cbqs";




$conn = new mysqli($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>