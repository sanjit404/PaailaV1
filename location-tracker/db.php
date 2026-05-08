<?php
session_start();
$conn = new mysqli("localhost", "root", "", "locate");
if ($conn->connect_error) die("DB Error: " . $conn->connect_error);
?>