<?php
require 'db.php';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $email = $_POST['email'];
  $password = $_POST['password'];
  $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE email=?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $stmt->bind_result($id, $hashed_pw, $role);
  if ($stmt->fetch() && password_verify($password, $hashed_pw)) {
    $_SESSION['user_id'] = $id;
    $_SESSION['role'] = $role;
    header("Location: " . ($role === 'parent' ? "parent.html" : "child.php"));
    exit;
  } else {
    echo "Invalid login ";
  }
}
?>
<form method="post">
  Email: <input type="email" name="email" required><br>
  Password: <input type="password" name="password" required><br>
  <button type="submit">Login</button>
  <a href="register.php">Don't have account? Sign up</a>
  <a href="forgot_password.php">Forgot Password?</a>

</form>