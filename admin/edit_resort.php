<?php
session_start();
require '../includes/db.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Authentication check
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

// Fetch existing resort data
$resort_id = $_GET['id'] ?? null;
if (!$resort_id) {
    header("Location: dashboard.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $location = $_POST['location'];
    $description = $_POST['description'];
    $attractions = $_POST['attractions'];
    $best_time = $_POST['best_time_to_visit'];
    // Update database
    $stmt = $pdo->prepare("UPDATE resorts SET
        name = ?,
        location = ?,
        description = ?,
        attractions = ?,
        best_time_to_visit = ?
        WHERE id = ?");

    $stmt->execute([
        $name,
        $location,
        $description,
        $attractions,
        $best_time,
        $resort_id // Make sure this is defined earlier
        ]);

    // Handle image upload if new image is provided
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "../images/resorts/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        // Update image path in database

        $pdo->prepare("UPDATE resorts SET image_path = ? WHERE id = ?")
        ->execute([$target_file, $resort_id]);
}
    header("Location: dashboard.php?success=1");
    exit();

}

// Get current resort data
$stmt = $pdo->prepare("SELECT * FROM resorts WHERE id = ?");
$stmt->execute([$resort_id]);
$resort = $stmt->fetch();
?>


<!DOCTYPE html>
<html>
<head>
    <title>Edit Resort</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        .edit-form { max-width: 600px; margin: 0 auto; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input[type="text"], textarea, select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
    }
        textarea { height: 150px; }
        .btn {
            background: #1a6d1f;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
        }
        </style>
</head>
<body>

    <h1>Edit Resort: <?= htmlspecialchars($resort['name']) ?></h1>
        
    <form class="edit-form" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>Resort Name:</label>
            <input type="text" name="name" value="<?= htmlspecialchars($resort['name']) ?>"
            required>
        </div>

        <div class="form-group">
            <label>Location:</label>
            <input type="text" name="location" value="<?= htmlspecialchars($resort['location'])
            ?>" required>
         </div>

        <div class="form-group">
            <label>Description:</label>
            <textarea name="description" required><?= htmlspecialchars($resort['description'])
            ?></textarea>
        </div>

        <div class="form-group">
            <label>Attractions (one per line):</label>
            <textarea name="attractions"><?= htmlspecialchars($resort['attractions'])
            ?></textarea>
        </div>

        <div class="form-group">
            <label>Best Time to Visit:</label>
            <input type="text" name="best_time_to_visit" value="<?=
            htmlspecialchars($resort['best_time_to_visit']) ?>">
        </div>

        <div class="form-group">
            <label>Current Image:</label>
            <img src="<?= htmlspecialchars($resort['image_path']) ?>" style="max-width: 200px;
            display: block;">
        </div>

        <div class="form-group">
            <label>Update Image (optional):</label>
            <input type="file" name="image" accept="image/*">
        </div>
        <button type="submit" class="btn">Update Resort</button>
        <a href="dashboard.php" style="margin-left: 10px;">Cancel</a>
    </form>
</body>
</html>