<?php
require 'includes/db.php';
$resort_id = $_GET['resort_id'] ?? null;
// Fetch resort name
$resort = $pdo->prepare("SELECT name FROM resorts WHERE id = ?");
$resort->execute([$resort_id]);
$resort_name = $resort->fetchColumn();
// Fetch accommodations
$stmt = $pdo->prepare("SELECT * FROM accommodations WHERE resort_id = ?");
$stmt->execute([$resort_id]);
$accommodations = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
<title>Accommodations at <?= htmlspecialchars($resort_name) ?></title>
<link rel="stylesheet"
    href="assets\fontawesome-free-6.7.2-web\fontawesome-free-6.7.2-web\css\all.min.css">
    <style>
        .accommodations-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        }
        .accommodation-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 30px;
        margin-top: 40px;
        }
        .accommodation-card {
        border: 1px solid #e1e1e1;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }
        .accommodation-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        }
        .accommodation-info {
        padding: 20px;
        }
        .price {
        color: #1a6d1f;
        font-weight: bold;
        font-size: 1.2rem;
        margin: 10px 0;
        }
        .amenities {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin: 15px 0;
        }
        .amenity {
        background: #f0f7f0;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.9rem;
        }
        </style>
    </head>
<body>
    <div class="accommodations-container">
    <h1>Accommodations at <?= htmlspecialchars($resort_name) ?></h1>
    <div class="accommodation-grid">
        <?php foreach ($accommodations as $acc): ?>
    <div class="accommodation-card">
        <img src="<?= htmlspecialchars($acc['image_path']) ?>"
        alt="<?= htmlspecialchars($acc['name']) ?>"
    class="accommodation-image">
    <div class="accommodation-info">
        <h3><?= htmlspecialchars($acc['name']) ?></h3>
    <div class="price">$<?= number_format($acc['price_per_night']) ?>/night</div>
    <div class="rating">
        <?php for ($i = 0; $i < 5; $i++): ?>
        <i class="fas fa-star <?= $i < $acc['rating'] ? 'rated' : '' ?>"></i>
        <?php endfor; ?>
    </div>
    <div class="amenities">
        <?php
        $amenities = explode(',', $acc['amenities']);
        foreach ($amenities as $amenity):
        ?>
            <span class="amenity"><?= trim($amenity) ?></span>
        <?php endforeach; ?>
    </div>
        <a href="book.php?accommodation_id=<?= $acc['id'] ?>" class="btn">Book
     Now</a>
    </div>
    </div>
    <?php endforeach; ?>
    </div>
    </div>
</body>
</html>