<?php

$host = "localhost";
$username   = "root";
$password   = "";
$db   = "pbl_portofolio"; 

$conn = mysqli_connect($host, $username, $password, $db);

if (!$conn) {
    die("Gagal mengakses Database : " . mysqli_connect_error());
}

?>