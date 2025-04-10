<?php
require 'includes/db.php';

$destinations = $pdo->query("SELECT id, name, image_path FROM resorts ORDER BY name")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Destinations | Zimbabwe Resorts</title>
    <link rel="stylesheet"
    href="assets\fontawesome-free-6.7.2-web\fontawesome-free-6.7.2-web\css\all.min.css">
    <style>
        body{
            font-family: 'Segeo UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            color: #333;
        }
        nav{
            background-color: #1a6d1f;
            padding: 15px 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);  
        }
        .nav-container{
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logo a{
            color: white;
            text-decoration: none;
            font-size: 1.5rem;
            font-weight: bold;
        }
        .nav-links{
            display: flex;
            list-style: none;
            gap: 20px;
        }
        .nav-links a{
            color: white;
            text-decoration: none;
            transition: opacity 0.3s;
        }
        .nav-links a:hover{
            opacity: 0.8;
        }

        .gallery-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }
        .page-title{
            text-align: center;
            color: #1a6d1f;
            margin-bottom: 40px;
        }
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
        }
        .destination-card {
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            aspect-ratio: 4/3;
        }
        .destination-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: filter 0.3s ease;
        }
        .destination-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            }
            .destination-name {
            color: white;
            font-size: 1.5rem;
            text-align: center;
            padding: 20px;
            transform: translateY(20px);
            transition: transform 0.3s ease;
            }
            .destination-card:hover .destination-overlay {
            opacity: 1;
            }
            .destination-card:hover .destination-name {
            transform: translateY(0);
            }
            .destination-card:hover .destination-image {
            filter: brightness(0.7);
            }
            /* Loading */
            .gallery-grid {
                view-timeline-name: --gallery;
            }
            .destination-card {
                animation: fade-in linear;
                animation-timeline: --gallery;
                animation-range: entry 10% cover 30%;
            }
            @keyframes fade-in {
                from { opacity: 0; transform: scale(0.9); }
                to { opacity: 1; transform: scale(1); }
            }
            .image-error {
                width: 100%;
                height: 100%;
                background: #eee;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #666;
            }

            /* Footer */
            footer{
                background-color: #1a6d1f;
                color: white;
                text-align: center;
                padding: 20px;
                margin-top: 50px;
            }

            @media (max-width: 768px) {
                .nav-container{
                    flex-direction: column;
                    gap: 15px;
                }

                .gallery-grid {
                     grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav>
        <div class="nav-container">
            <div class="logo">
                <a href="index.php">ZimResorts</a>
            </div>
            <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="all-destinations.php">Destinations</a></li>
            <li><a href="accommodations.php">Accommodations</a></li>
            <li><a href="gallery.php">Gallery</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>

        </div>
    </nav>
    
    <!-- Main Content -->
    <div class="gallery-container">
    <h1 class="page-title">Explore Our Destinations</h1>

    <div class="gallery-grid">
        <?php foreach ($destinations as $destination):
            // Clean the image path
            $image_path = str_replace('C:/xampp/htdocs/', '', $destination['image_path']);
            $full_path = $_SERVER['DOCUMENT_ROOT'] . '/zim_resort/' . $image_path;
        ?>
        <a href="destination.php?id=<?= $destination['id'] ?>" class="destination-card">
            <?php if (file_exists($full_path)): ?>
                <img src="<?= htmlspecialchars($image_path) ?>"
                    alt="<?= htmlspecialchars($destination['name']) ?>"
                    class="destination-image">
            <?php else: ?>
                <div class="image-error">Image missing</div>
            <?php endif; ?>

            <div class="destination-overlay">
                <h3 class="destination-name"><?= htmlspecialchars($destination['name']) ?></h3>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
</div>
    <!-- Footer -->
            <footer>
                <p>&copy; <?= date('Y') ?> Zimbabwe Natural Resorts. All rights reserved.</p>
        </footer>
</body>
</html>