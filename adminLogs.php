<?php
session_start();
include 'db.php';

// Check admin login
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}

// Fetch logs with admin usernames
$logs = $conn->query("SELECT l.id, a.username, l.action, l.created_at 
                      FROM admin_logs l
                      JOIN admins a ON l.admin_id = a.id
                      ORDER BY l.created_at DESC");

?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - Logs</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        .card { background: white; padding: 15px; border-radius: 8px; margin: 20px; box-shadow: 0px 2px 5px rgba(0,0,0,0.2); }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; background: white; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background: orangered; color: white; }
        tr:nth-child(even) { background: #f9f9f9; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Paaila Admin Activity Logs</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Admin</th>
                <th>Action</th>
                <th>Timestamp</th>
            </tr>
            <?php while ($row = $logs->fetch_assoc()) { ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= htmlspecialchars($row['username']); ?></td>
                    <td><?= htmlspecialchars($row['action']); ?></td>
                    <td><?= $row['created_at']; ?></td>

                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
