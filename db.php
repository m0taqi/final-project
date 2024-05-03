<?php
$host = "192.168.1.17";
$username = "taqi";
$password = "P@ssw0rd";
$database = "final database";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
