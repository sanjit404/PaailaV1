<?php
require 'db.php';
header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'child') {
  http_response_code(403);
  echo json_encode(["error" => "Unauthorized"]);
  exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data["latitude"]) || !isset($data["longitude"])) {
  echo json_encode(["error" => "Missing latitude or longitude"]);
  exit;
}

$lat = floatval($data["latitude"]);
$lng = floatval($data["longitude"]);

$stmt = $conn->prepare("UPDATE users SET latitude=?, longitude=?, location_updated_at=NOW() WHERE id=?");
$stmt->bind_param("ddi", $lat, $lng, $_SESSION['user_id']);

if ($stmt->execute()) {
  echo json_encode(["status" => "success", "lat" => $lat, "lng" => $lng]);
} else {
  echo json_encode(["error" => "DB error", "details" => $stmt->error]);
}
