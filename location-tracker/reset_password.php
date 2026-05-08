<?php
require 'db.php';

$token = $_GET['token'] ?? '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $token = $_POST['token'];
    $newPassword = $_POST['password'];

    // 1️⃣ Check if token is valid
    $check = $conn->prepare(
        "SELECT id FROM users WHERE reset_token=? AND reset_expiry > NOW()"
    );
    $check->bind_param("s", $token);
    $check->execute();
    $check->store_result();

    if ($check->num_rows === 0) {
        die("Invalid or expired token");
    }

    // 2️⃣ Hash new password
    $hashed = password_hash($newPassword, PASSWORD_DEFAULT);

    // 3️⃣ Update password
    $update = $conn->prepare(
        "UPDATE users 
         SET password=?, reset_token=NULL, reset_expiry=NULL
         WHERE reset_token=?"
    );
    $update->bind_param("ss", $hashed, $token);
    $update->execute();

    echo "Password reset successful. <a href='login.php'>Login</a>";
    exit;
}
?>

<form method="post">
  <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
  New Password:<br>
  <input type="password" name="password" required>
  <button type="submit">Reset Password</button>
</form>
