<?php
require 'db.php';
header("Content-Type: application/json");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'parent') {
    http_response_code(403);
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

$sql = "SELECT u.latitude, u.longitude, u.location_updated_at, u.name
        FROM parent_child pc
        JOIN users u ON pc.child_id = u.id
        WHERE pc.parent_id = ?
        LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$stmt->close();

if ($row) {
    if ($row['latitude'] !== null && $row['longitude'] !== null) {
        echo json_encode([
            "latitude" => $row['latitude'],
            "longitude" => $row['longitude'],
            "location_updated_at" => $row['location_updated_at'],
            "child_name" => $row['name']
        ]);
    } else {
        echo json_encode(["error" => "Child is linked but has not shared location yet"]);
    }
} else {
    echo json_encode(["error" => "No child linked to this parent"]);
}
?>
