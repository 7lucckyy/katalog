<?php
$servername = "us-cdbr-east-04.cleardb.com";
$username = "bafc164b0508da";
$password = "6804adaf";
$dbname = "heroku_7f95f92435e21e3";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
else{
    // echo ("SUCCESS");
}
?>
