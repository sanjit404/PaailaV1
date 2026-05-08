<?php
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'parent') {
    die("Access denied");
}

$parent_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $child_id = $_POST['child_id'];
    $stmt = $conn->prepare("INSERT INTO parent_child (parent_id, child_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $parent_id, $child_id);
    if ($stmt->execute()) {
        echo "✅ Linked successfully.";
    } else {
        echo "❌ Error: " . $stmt->error;
    }
}

$result = $conn->query("SELECT id, name FROM users WHERE role='child'");
?>

<h2>Link a Child to Your Account</h2>
<form method="POST">
    <label>Select Child:</label>
    <select name="child_id" required>
        <?php while ($row = $result->fetch_assoc()): ?>
            <option value="<?= $row['id'] ?>"><?= $row['name'] ?> (ID: <?= $row['id'] ?>)</option>
        <?php endwhile; ?>
    </select><br><br>
    <button type="submit">Link Child</button>
</form>
<a href="parent.html">← Back to Tracking</a>
