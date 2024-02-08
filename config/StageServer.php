<?php
$hostname = "localhost";
$username = "root";
$password = ""; // Change this if your MySQL root user has a password
$database = "cardmonix";

$conn = new mysqli($hostname, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully";
}
?>
