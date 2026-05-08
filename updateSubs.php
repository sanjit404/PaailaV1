<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}

// Update subscription status
if (isset($_POST['update_status'])) {
    $subId = $_POST['sub_id'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE subscriptions SET status=? WHERE child_id=?");
    $stmt->bind_param("si", $status, $subId);
    $stmt->execute();

    //log
    $adminId = $_SESSION['admin'];
    $log = $conn->prepare("INSERT INTO admin_logs (admin_id, action) VALUES (?, ?)");
    $action = "Changed subscription $subId status to $status";
    $log->bind_param("is", $adminId, $action);
    $log->execute();
}

// Fetch subscriptions with user + package info
$sql = "
    SELECT s.child_id, u.username, p.name AS package_name, s.start_date, s.end_date, s.status
    FROM subscriptions s
    JOIN users u ON s.child_id = u.id
    JOIN packages p ON s.package_id = p.id
    ORDER BY s.start_date DESC
";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - Subscriptions</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f7f7;
            padding: 20px;
        }
        h2 {
            color: orangered;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            border-radius: 10px;
            overflow: hidden;
        }
        th, td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
            text-align: center;
        }
        th {
            background: orangered;
            color: white;
        }
        tr:hover {
            background: #fdf2ec;
        }
        select, button {
            padding: 6px 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
        button {
            background: orangered;
            color: black;
            border: none;
            cursor: pointer;
            transition: 0.2s;
        }
        button:hover {
            background: darkred;
        }
    </style>
</head>
<body>
    <h2>Manage Subscriptions</h2>

    <table>
        <tr>
            <th>User</th>
            <th>Package</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Status</th>
            <th>Update</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['username']) ?></td>
            <td><?= htmlspecialchars($row['package_name']) ?></td>
            <td><?= $row['start_date'] ?></td>
            <td><?= $row['end_date'] ?></td>
            <td>
                <form method="POST" style="display:flex;justify-content:center;gap:8px;">
                    <input type="hidden" name="sub_id" value="<?= $row['child_id'] ?>">
                    <select name="status">
                        <option value="active" <?= $row['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                        <option value="expired" <?= $row['status'] === 'expired' ? 'selected' : '' ?>>Expired</option>
                    </select>
            </td>
            <td>
                    <button type="submit" name="update_status">Save</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
        <a href="admin_dashboard.php"><button>Go back</button></a>

</body>
</html>
