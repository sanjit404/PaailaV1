<?php
include 'db.php';

header("Content-Type: application/json");

$sql = "SELECT id, name, price, duration_days FROM packages";
$result = $conn->query($sql);

$packages = [];
while ($row = $result->fetch_assoc()) {
    $packages[] = $row;
}

echo json_encode($packages);
