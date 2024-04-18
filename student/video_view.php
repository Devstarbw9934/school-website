<?php
session_start();
include("../conn.php");
if(isset($_POST['video'])){
    $id=$_SESSION['id'];
    $query = "SELECT * FROM stuvideos where sid='$id' AND vid='$_POST[video]'"; //You don't need a ; like you do in SQL
    $result = mysqli_query($conn,$query);
    if ($result->num_rows == 0) {
        $sql = "INSERT INTO stuvideos (sid, vid) VALUES ('$id', '$_POST[video]')";
        mysqli_query($conn, $sql);
        echo "OK";
    } else {
        echo "Already watched!";
    }
} else {
    echo "Failed";
}
?>