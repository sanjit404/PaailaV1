<?php
header('Content-Type: application/json');
include 'db.php'; // your DB connection

$identifier = $_POST['identifier'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($identifier) || empty($password)) {
    echo json_encode([
        "status" => "error",
        "message" => "Please enter username/email and password"
    ]);
    exit;
}

try {
    // check if it's an email or username
    if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    }
    $stmt->bind_param("s", $identifier);

    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        echo json_encode([
            "status" => "success",
            "message" => "Login successful",
            "username" => $user['username'],
            "email" => $user['email'],
            "id" => $user['id'],
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Invalid username/email or password"
        ]);
    }

    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Server error: " . $e->getMessage()
    ]);
}




