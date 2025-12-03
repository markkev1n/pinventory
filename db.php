<?php
$servername = "t681ln.h.filess.io";
$username = "pinventory_stemshisor";
$password = "45350513e8c96f8a9f06239f2c8ebd125d72438a";
$database = "pinventory_stemshisor";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

