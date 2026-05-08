<?php
include 'db.php';
header("Content-Type: application/json");

$username = $_GET['username'] ?? '';

$stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc(); // fetch the actual row

if ($user) {
    $id = $user['id']; // now $id is an integer

    $stmt = $conn->prepare("
        SELECT s.child_id, p.name, p.price, p.duration_days, s.start_date , p.id
        FROM subscriptions s 
        JOIN packages p ON s.package_id = p.id 
        WHERE s.child_id = ?
    ");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    $subs = [];
    while ($row = $result->fetch_assoc()) {
        $subs[] = $row;
    }

    echo json_encode($subs);
} else {
    echo json_encode([]);
}
