<?php

$hostName = "localhost";
$dbUser = "root";
$dbPass = "";
$dbName = "login_database";
$conn = mysqli_connect($hostName, $dbUser, $dbPass, $dbName);
if (!$conn) {
    die("Something went wrong". mysqli_connect_error());
}