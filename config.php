<?php
$servername = "us-cdbr-east-04.cleardb.com";
$username = "bffc20313bc21a";
$password = "a8ffd044";
$dbname = "heroku_a17091ef0145058";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
else{
    // echo ("SUCCESS");
}
?>

