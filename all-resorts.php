<?php
require 'includes/db.php';

$stmt = $pdo->query("SELECT * FROM resorts");
$resorts = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Resorts | Zimbabwe</title>
     <style>
        .resort-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        padding: 20px;
        }
        .resort-card {
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        }
        .resort-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        }
        .resort-info {
        padding: 15px;
        }
        </style>
</head>
<body>
    <h1>All Resorts</h1>
    <div class="resort-list">
    <?php foreach ($resorts as $resort): ?>
    <div class="resort-card">
        <img src="<?= htmlspecialchars($resort['image_path']) ?>" alt="<?=
            htmlspecialchars($resort['name']) ?>">
        <div class="resort-info">
        <h3><?= htmlspecialchars($resort['name']) ?></h3>
        <p><?= substr(htmlspecialchars($resort['description']), 0, 100) ?>...</p>
        <a href="destination.php?id=<?= $resort['id'] ?>" class="btn">View Details</a>
        </div>
        </div>
        <?php endforeach; ?>
    </div>
</body>
</html>