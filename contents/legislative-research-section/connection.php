<?php
<<<<<<< HEAD
// connections.php

// Database connection details for lgu2
$servername_lgu2 = "localhost";
$username_lgu2 = "root";
$password_lgu2 = "";
$dbname_lgu2 = "lgu2";

// Create connection to lgu2 database
$lgu2_conn = new mysqli($servername_lgu2, $username_lgu2, $password_lgu2, $dbname_lgu2);

// Check lgu2 connection
if ($lgu2_conn->connect_error) {
    die("Connection to lgu2 failed: " . $lgu2_conn->connect_error);
}

?>
=======

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lgu2";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Connection failed: ' . $conn->connect_error]);
    exit();
}
>>>>>>> 9a058cd9da00ccba920a6f57b37d5a7c959d057c
