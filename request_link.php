<?php
session_start();
require 'db.php';
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);
$targetUsername = $data['targetUsername'] ?? null;

if (!$targetUsername) {
    echo json_encode(["error" => "Target username required"]);
    exit;
}

// Get target user id
$stmt = $conn->prepare("SELECT id FROM users WHERE username=? LIMIT 1");
$stmt->bind_param("s", $targetUsername);
$stmt->execute();
$result = $stmt->get_result();
if (!$row = $result->fetch_assoc()) {
    echo json_encode(["error" => "User not found"]);
    exit;
}
$targetId = $row['id'];

// Check if link already exists
$stmt = $conn->prepare("SELECT * FROM link_requests WHERE requester_id=? OR target_id=? LIMIT 1");
$stmt->bind_param("ii", $_SESSION['user_id'], $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    echo json_encode(["error" => "You already have a link request or link"]);
    exit;
}

// Insert request
$stmt = $conn->prepare("INSERT INTO link_requests (requester_id, target_id, status, created_at) VALUES (?, ?, 'pending', NOW())");
$stmt->bind_param("ii", $_SESSION['user_id'], $targetId);
$stmt->execute();

echo json_encode(["message" => "Request sent"]);
?>
