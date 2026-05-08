<?php
session_start();
include 'db.php';

// Check admin login
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}

// ---------- Handle Packages ---------- //

// Add package
if (isset($_POST['add'])) {
    $stmt = $conn->prepare("INSERT INTO packages (name, price, duration_days) VALUES (?, ?, ?)");
    $stmt->bind_param("sii", $_POST['name'], $_POST['price'], $_POST['duration_days']);
    $stmt->execute();

    $packageName = $_POST['name'];
    $adminId = $_SESSION['admin'];
    $log = $conn->prepare("INSERT INTO admin_logs (admin_id, action) VALUES (?, ?)");
    $action = "Added package: $packageName";
    $log->bind_param("is", $adminId, $action);
    $log->execute();
}

// Update package
if (isset($_POST['update'])) {
    $stmt = $conn->prepare("UPDATE packages SET name=?, price=?, duration_days=? WHERE id=?");
    $stmt->bind_param("siii", $_POST['name'], $_POST['price'], $_POST['duration_days'], $_POST['id']);
    $stmt->execute();

    //add logs
    $packageName = $_POST['name'];
    $adminId = $_SESSION['admin'];
    $log = $conn->prepare("INSERT INTO admin_logs (admin_id, action) VALUES (?, ?)");
    $action = "Updated package (ID {$_POST['id']}): $packageName";
    $log->bind_param("is", $adminId, $action);
    $log->execute();
}

// Delete package
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];

    // get package name before deleting
    $pkg = $conn->prepare("SELECT name FROM packages WHERE id=?");
    $pkg->bind_param("i", $id);
    $pkg->execute();
    $pkgRes = $pkg->get_result()->fetch_assoc();
    $packageName = $pkgRes['name'] ?? 'Unknown';

    $stmt = $conn->prepare("DELETE FROM packages WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();


    //add logs
    $adminId = $_SESSION['admin'];
    $log = $conn->prepare("INSERT INTO admin_logs (admin_id, action) VALUES (?, ?)");
    $action = "Deleted package (ID $id): $packageName";
    $log->bind_param("is", $adminId, $action);
    $log->execute();
}

// Fetch data
$packages = $conn->query("SELECT * FROM packages");
$subscriptions = $conn->query("SELECT u.username, p.name AS package_name, p.price, s.start_date
                               FROM subscriptions s
                               JOIN users u ON s.child_id = u.id
                               JOIN packages p ON s.package_id = p.id");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background: #f5f5f5; }
        input{max-width: 400px;}
        header { background: orangered; color: #fff; padding: 15px; text-align: center; }
        nav { background: #333; color: #fff; padding: 10px; text-align: right; }
        nav a { color: white; margin-left: 15px; text-decoration: none; }
        .container { padding: 20px; }
        h2 { color: white; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; background: white; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background: #ed8b4aff; color: white; }
        tr:nth-child(even) { background: #f9f9f9; }
        input[type=text], input[type=number] { padding: 5px; width: 90%; }
        button { background: orangered; color: white; border: none; padding: 5px 10px; cursor: pointer; }
        button:hover { background: darkred; }
        .card { background: white; padding: 15px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0px 2px 5px rgba(0,0,0,0.2); }
    </style>
</head>
<body>
    <header>
    <h1>Paaila Admin Dashboard</h1>
    <h2>Welcome, <?= htmlspecialchars($_SESSION['admin_username']) ?> 👋</h2>
</header>

    <nav>
        <a href="logout.php">Logout</a>
    </nav>
    <div class="container">
        
        <!-- Packages Management -->
        <div class="card">
            <h2>Manage Packages</h2>
            <form method="POST" style="margin-bottom: 20px;">
                <input type="text" name="name" placeholder="Package name" required>
                <input type="number" name="price" placeholder="Price" required>
                <input type="number" name="duration_days" placeholder="Duration (days)" required>
                <button type="submit" name="add">Add</button>
            </form>

            <table>
                <tr><th>ID</th><th>Name</th><th>Price</th><th>Duration</th><th>Actions</th></tr>
                <?php while($row = $packages->fetch_assoc()) { ?>
                    <tr>
                        <form method="POST">
                            <td><?php echo $row['id']; ?>
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            </td>
                            <td><input type="text" name="name" value="<?php echo $row['name']; ?>"></td>
                            <td><input type="number" name="price" value="<?php echo $row['price']; ?>"></td>
                            <td><input type="number" name="duration_days" value="<?php echo $row['duration_days']; ?>"></td>
                            <td>
                                <button type="submit" name="update">Update</button>
                                <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete this package?')" style="color:red;">Delete</a>
                            </td>
                        </form>
                    </tr>
                <?php } ?>
            </table>
        </div>

        <!-- Subscriptions -->
        <div class="card">
            <h2>All Subscriptions</h2>
            <table>
                <tr><th>User</th><th>Package</th><th>Price</th><th>Start Date</th></tr>
                <?php while($row = $subscriptions->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['username']; ?></td>
                        <td><?php echo $row['package_name']; ?></td>
                        <td>Rs. <?php echo $row['price']; ?></td>
                        <td><?php echo $row['start_date']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
        <a href="updateSubs.php"><button>Update Subscriptions</button></a>

    </div>
</body>
</html>
