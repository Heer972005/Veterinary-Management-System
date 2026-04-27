<?php
$conn = new mysqli("localhost", "root", "heermehta.972", "vetmanagement");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>