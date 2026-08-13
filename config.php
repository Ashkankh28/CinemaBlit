<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "cinemablit";

$link = mysqli_connect($host, $username, $password, $database);

if (!$link) {
    die("Database connection failed: " . mysqli_connect_error());
}
