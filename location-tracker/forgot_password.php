<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = $_POST['email'];

    // 1️⃣ Check email exists
    $check = $conn->prepare("SELECT id FROM users WHERE email=?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows !== 1) {
        echo "Email not found";
        exit;
    }

    // 2️⃣ Generate token
    $token  = bin2hex(random_bytes(32));
    $expiry = date("Y-m-d H:i:s", strtotime("+1 hour"));

    // 3️⃣ Update token
    $update = $conn->prepare(
        "UPDATE users SET reset_token=?, reset_expiry=? WHERE email=?"
    );
    $update->bind_param("sss", $token, $expiry, $email);
    $update->execute();

    // 4️⃣ Always show link if email exists
    $link = "http://localhost/location-tracker/reset_password.php?token=$token";
    echo "Reset link (demo): <a href='$link'>Click Here</a>";
}
?>

<form method="post">
  Enter your email:<br>
  <input type="email" name="email" required>
  <button type="submit">Send Reset Link</button>
</form>
