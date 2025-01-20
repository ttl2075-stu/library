<?php 
session_start();
define('WEB_NAME', 'Thư viện trực tuyến');
$hostname = "localhost";
$username = "root";
$password = "";
$database = "thu_vien";

// Create connection
$conn = mysqli_connect($hostname, $username, $password, $database);
$conn->set_charset("utf8");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    // echo "Connected successfully";
}

// echo "<pre>";
// print_r($_SESSION);
// echo "</pre>";
