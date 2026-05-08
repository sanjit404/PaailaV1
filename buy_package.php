<?php
include 'db.php';

$child_id = $_POST['child_id'] ?? null;
$package_id = $_POST['package_id'] ?? null;

if (!$child_id || !$package_id) {
    echo json_encode(["status"=>"error","message"=>"Missing parameters"]);
    exit;
}

// Check if user already has an active subscription
$check = $conn->prepare("SELECT * FROM subscriptions WHERE child_id = ? AND status = 'active'");
$check->bind_param("i", $child_id);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    echo json_encode(["status"=>"error","message"=>"You already have an active subscription"]);
    exit;
}

// Insert new subscription
$start = date('Y-m-d H:i:s');
$end = date('Y-m-d H:i:s', strtotime('+30 days')); // example 30-day subscription

$stmt = $conn->prepare("INSERT INTO subscriptions (child_id, package_id, start_date, end_date, status) VALUES (?, ?, ?, ?, 'active')");
$stmt->bind_param("iiss", $child_id, $package_id, $start, $end);

if ($stmt->execute()) {
    echo json_encode(["status"=>"success","message"=>"Subscription added successfully"]);
} else {
    echo json_encode(["status"=>"error","message"=>"Failed to add subscription"]);
}
?>
