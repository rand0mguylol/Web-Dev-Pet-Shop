<?php
$dbHost = "localhost";
$dbUsername = "";
$dbPassword = "";
$dbName = ""; // The name of your database

$connection = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);
if (!$connection) {
    die("Connection Unsuccessful" . mysqli_connect_error());
}
