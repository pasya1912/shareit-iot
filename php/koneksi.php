<?php
//do connection to mysqli
$servername = "localhost";
$username = "root";
$password = "Shareit2023";
$dbname = "shareit";

// Create connection

$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
die("Connection failed: " . mysqli_connect_error());
}
?>