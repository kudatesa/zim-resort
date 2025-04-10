<?php
require 'includes/db.php';

$resort_id = $_GET['id'] ?? null;

if ($resort_id) {
    $stmt = $pdo->prepare("SELECT * FROM resorts WHERE id = ?");
    $stmt->execute([$resort_id]);
    $resort = $stmt->fetch(PDO::FETCH_ASSOC);
}

if (!$resort) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($resort['name']) ?> | Zimbabwe Resorts</title>
    <link rel="stylesheet"
        href="assets\fontawesome-free-6.7.2-web\fontawesome-free-6.7.2-web\css\all.min.css">
    <style>
/* Base Styles */
    body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    line-height: 1.6;
    color: #333;
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    background-color: #f9f9f9;
    }
    /* Resort Header */
    .resort-header {
    text-align: center;
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 1px solid #e1e1e1;
    }
    .resort-name {
    color: #1a6d1f;
    font-size: 2.5rem;
    margin-bottom: 10px;
    font-weight: 700;
    letter-spacing: -0.5px;
    }
    .resort-location {
    color: #6b6b6b;
    font-size: 1.2rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    }
    /* Main Content */
    .resort-container {
    display: grid;
    grid-template-columns: 1fr;
    gap: 30px;
    }
    @media (min-width: 768px) {
    .resort-container {
    grid-template-columns: 1fr 1fr;
    }
    }
    /* Image Styling */
    .resort-image {
    width: 100%;
    border-radius: 8px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
    }
    .resort-image:hover {
    transform: scale(1.02);
    }
    /* Description Styling */
    .description {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #444;
    }
    .description p {
    margin-bottom: 20px;
    text-align: justify;
    }
    /* Details Section */
    .details-card {
    background: white;
    padding: 25px;
    border-radius: 8px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.08);
    }
    .detail-item {
    margin-bottom: 20px;
    display: flex;
    gap: 15px;
    }
    .detail-icon {
    color: #1a6d1f;
    font-size: 1.5rem;
    min-width: 30px;
    }
    .detail-content h3 {
    margin: 0 0 8px 0;
    color: #1a6d1f;
    font-size: 1.3rem;
    }
    /* Back Button */
    .back-btn {
    display: inline-block;
    margin-top: 30px;
    padding: 12px 25px;
    background: #1a6d1f;
    color: white;
    text-decoration: none;
    border-radius: 4px;
    font-weight: 500;
    transition: background 0.3s;
    }
    .back-btn:hover {
    background: #145218;
    }
</style>
</head>
<body>
    <div class="resort-header">
            <h1 class="resort-name"><?= htmlspecialchars($resort['name']) ?></h1>
            <p class="resort-location">
            <i class="fas fa-map-marker-alt"></i>
            <?= htmlspecialchars($resort['location']) ?>
            </p>
        </div>
    <div class="resort-container">
    <div>
    <img src="<?= htmlspecialchars($resort['image_path']) ?>"
    alt="<?= htmlspecialchars($resort['name']) ?>"
    class="resort-image">
    </div>
    <div class="details-card">
    <div class="description">
    <?= nl2br(htmlspecialchars($resort['description'])) ?>
    </div>
    <div class="detail-item">
    <div class="detail-icon">
    <i class="fas fa-calendar-alt"></i>
    </div>
    <div class="detail-content">

   
    <h3>Best Time to Visit</h3>
    <p><?= htmlspecialchars($resort['best_time_to_visit']) ?></p>
    </div>
    </div>
    <div class="detail-item">
    <div class="detail-icon">
    <i class="fas fa-binoculars"></i>
    </div>
    <div class="detail-content">
    <h3>Key Activities</h3>
    <p><?= nl2br(htmlspecialchars($resort['attractions'])) ?></p>
    </div>
    </div>
    </div>
    </div>
    <div class="action-buttons">
        <a href="accommodations.php?resort_id=<?= $resort['id'] ?>" class="btn
                    btn-accommodation">
        <i class="fas fa-hotel"></i> View Accommodations
        </a>
    </div>
    <a href="index.php" class="back-btn">
    <i class="fas fa-arrow-left"></i> Back to All Resorts
    </a>
</body>
</html>