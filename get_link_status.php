<?php
session_start();
require 'db.php';
header("Content-Type: application/json");

$userId = $_SESSION['user_id'];

// Incoming request
$incoming = null;
$sql = "SELECT lr.id, u.id as requester_id, u.username 
        FROM link_requests lr
        JOIN users u ON lr.requester_id = u.id
        WHERE lr.target_id = ? AND lr.status='pending' LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    $incoming = [
        "id" => $row['id'],
        "requester_id" => $row['requester_id'],
        "username" => $row['username']
    ];
}
$stmt->close();

// Outgoing request
$outgoing = null;
$sql = "SELECT lr.id, u.id as target_id, u.username, lr.status 
        FROM link_requests lr
        JOIN users u ON lr.target_id = u.id
        WHERE lr.requester_id = ? LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    $outgoing = [
        "id" => $row['id'],
        "target_id" => $row['target_id'],
        "username" => $row['username'],
        "status" => $row['status']
    ];
}
$stmt->close();

echo json_encode([
    "incoming" => $incoming,
    "outgoing" => $outgoing
]);
?>
