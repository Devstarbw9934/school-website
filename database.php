<?php
include_once('db.php');
// Create connection
$con= new mysqli($servername, $username, $password);
// Check connection
if ($con->connect_error) {
die("Connection failed: " . $con->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($con->query($sql) === TRUE) {
echo "Database created successfully";
} else {
echo "Error creating database: " . $con->error;
}

// File path 
$filePath   = 'files/cbqs.sql';

if(file_exists($filePath)){
  importDatabaseTables($servername, $username, $password, $dbname, $filePath);
}

function importDatabaseTables($dbHost, $dbUname, $dbPass, $dbName, $filePath){
  // Connect & select the database
  $db = new mysqli($dbHost, $dbUname, $dbPass, $dbName); 

  // Temporary variable, used to store current query
  $templine = '';
  
  // Read in entire file
  $lines = file($filePath);
  
  $error = '';
  
  // Loop through each line
  foreach ($lines as $line){
      // Skip it if it's a comment
      if(substr($line, 0, 2) == '--' || $line == ''){
          continue;
      }
      
      // Add this line to the current segment
      $templine .= $line;
      
      // If it has a semicolon at the end, it's the end of the query
      if (substr(trim($line), -1, 1) == ';'){
          // Perform the query
          if(!$db->query($templine)){
              $error .= 'Error importing query "<b>' . $templine . '</b>": ' . $db->error . '<br /><br />';
          }
          
          // Reset temp variable to empty
          $templine = '';
      }
  }
  echo "<br>";
  echo "Database imported successfully";
  $db->close(); 
  return !empty($error)?$error:true;
}

$con->close();
