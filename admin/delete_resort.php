<?php
session_start();
require '../includes/db.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

$resort_id = $_GET['id'] ?? null;
if ($resort_id) {
    // Optional: Delete associated image first
    $stmt = $pdo->prepare("SELECT image_path FROM resorts WHERE id = ?");
    $stmt->execute([$resort_id]);
    $image_path = $stmt->fetchColumn();
    if ($image_path && file_exists($image_path)) {
        unlink($image_path);
}
// Delete from database
    $pdo->prepare("DELETE FROM resorts WHERE id = ?")->execute([$resort_id]);
}
header("Location: dashboard.php?deleted=1");
exit();
?>