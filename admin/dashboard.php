<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);


// Redirect if not logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

// Database connection
require '../includes/db.php';
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>
<style>
body { font-family: Arial; padding: 20px; }
        .resort-list { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
        .resort-card { border: 1px solid #ddd; padding: 15px; border-radius: 5px; }
</style>
</head>
<body>

    <h1>Admin Dashboard</h1>
    <p>Welcome, Admin! | <a href="logout.php">Logout</a></p>

    <h2>All Resorts</h2>
    <div class="resort-list">
        <?php
        // Fetch all resorts
        $stmt = $pdo->query("SELECT * FROM resorts");
        while ($resort = $stmt->fetch()):
    ?>
    <div class="resort-card">
        <h3><?= htmlspecialchars($resort['name']) ?></h3>
        <p><?= htmlspecialchars($resort['location']) ?></p>
        <!-- Add this edit link -->
        <a href="edit_resort.php?id=<?= $resort['id'] ?>">Edit</a>
        <!-- Add this delete link if needed -->
        <a href="delete_resort.php?id=<?= $resort['id'] ?>"
            onclick="return confirm('Delete this resort?')"
            style="color: red; margin-left: 10px;">
            Delete
        </a>
        </div>
        <?php endwhile; ?>
</div>
<a href="add_resort.php" style="display: inline-block; margin-top: 20px; padding: 10px 15px; background: #1a6d1f; color: white; text-decoration: none;">Add New Resort</a>
</body>
</html>