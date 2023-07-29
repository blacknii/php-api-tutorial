<?php

$host = "localhost";
$username = "root";
$password = "";
$dbName = "crud";

$conn = mysqli_connect($host, $username, $password, $dbName);

if(!$conn) {
  die("connection failed" . mysqli_connect_error());
}

?>