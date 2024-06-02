<?php
ini_set('display_errors', 0);
session_start();
// db.php - Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_assignment";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
