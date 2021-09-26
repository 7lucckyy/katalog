<?php
$servername = "us-cdbr-east-04.cleardb.com";
$username = "baaedcd2546d24";
$password = "3d922c37";
$dbname = "heroku_35826186c5287ef";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
else{
    // echo ("SUCCESS");
}
?>
