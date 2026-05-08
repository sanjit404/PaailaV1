<?php
session_start();
require 'db.php';
header("Content-Type: application/json");

// Check approved link
$sql = "SELECT * FROM link_requests WHERE 
        (requester_id=? AND status='approved') OR
        (target_id=? AND status='approved') LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $_SESSION['user_id'], $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 0) {
    echo json_encode(["error" => "No approved link"]);
    exit;
}

// Get the linked user ID
$link = $result->fetch_assoc();
$linkedUserId = ($link['requester_id'] == $_SESSION['user_id']) ? $link['target_id'] : $link['requester_id'];

// Get location
$stmt = $conn->prepare("SELECT latitude, longitude, updated_at, username FROM locations l JOIN users u ON l.user_id=u.id WHERE l.user_id=? LIMIT 1");
$stmt->bind_param("i", $linkedUserId);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    echo json_encode([
        "latitude" => $row['latitude'],
        "longitude" => $row['longitude'],
        "location_updated_at" => $row['updated_at'],
        "username" => $row['username']
    ]);
} else {
    echo json_encode(["error" => "Location not available"]);
}
?>
