<?php
session_start();
include 'db.php';

// If already logged in, go to dashboard
if (isset($_SESSION['admin'])) {
    header("Location: admin_dashboard.php");
    exit;
}

$message = "";

// Handle registration
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Insert new admin
    $stmt = $conn->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);

    if ($stmt->execute()) {
        $message = "✅ Registration successful. You can now login.";
    } else {
        $message = "❌ Username already exists.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Registration</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; display:flex; justify-content:center; align-items:center; height:100vh; }
        .form-box { background:white; padding:30px; border-radius:8px; border:1px dotted orangered; box-shadow:0px 2px 8px rgba(230, 134, 8, 1); width:300px; }
        h2 { text-align:center; color:orangered; }
        input { width:100%; padding:10px; margin:10px 0; border:1px solid #ccc; border-radius:4px; }
        button { width:100%; background:orangered; color:white; border:none; padding:10px; cursor:pointer; border-radius:4px; }
        button:hover { background:darkred; }
        .msg { text-align:center; margin:10px 0; color:green; }
        a { display:block; text-align:center; margin-top:10px; text-decoration:none; color:orangered; }
        hr{
            background-color:orangered;
            height: 3px;
            border: none;
        }
    </style>
</head>
<body>
    <div class="form-box">
        <h2>Paaila Admin Register</h2>
        <?php if ($message) echo "<p class='msg'>$message</p>"; ?>
        <hr>
        <form method="POST">
            <input type="text" name="username" placeholder="Enter username" required>
            <input type="password" name="password" placeholder="Enter password" required>
            <button type="submit">Register</button>
        </form>
        <a href="admin_login.php">Already have account? Login</a>
    </div>
</body>
</html>
