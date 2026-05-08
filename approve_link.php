<?php
session_start();
require 'db.php';
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);
$requesterId = $data['requester_id'] ?? null;

if (!$requesterId) {
    echo json_encode(["error" => "Requester ID required"]);
    exit;
}

$stmt = $conn->prepare("UPDATE link_requests SET status='approved' WHERE requester_id=? AND target_id=?");
$stmt->bind_param("ii", $requesterId, $_SESSION['user_id']);
$stmt->execute();

echo json_encode(["message" => "Link approved"]);
?>
