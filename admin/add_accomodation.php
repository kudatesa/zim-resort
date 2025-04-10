<?php
// [Authentication check code here]
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $target_dir = "../images/accommodations/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);

    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    $stmt = $pdo->prepare("INSERT INTO accommodations
                    (resort_id, name, description, price_per_night, rating, amenities,
image_path)
                    VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $_POST['resort_id'],
        $_POST['name'],
        $_POST['description'],
        $_POST['price_per_night'],
        $_POST['rating'],
        $_POST['amenities'],
        $target_file
    ]);

    header("Location: dashboard.php?success=1");
    exit();
}
?>



<!DOCTYPE html>
<html>
<head>
    <title>Add Accomodation - Admin</title>

    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet"
    href="assets\fontawesome-free-6.7.2-web\fontawesome-free-6.7.2-web\css\all.min.css">
</head>
<body>

<form method="post" enctype="multipart/form-data">
    <h2>Add New Accommodation</h2>
    <label>Resort:</label>
    <select name="resort_id" required>
        <?php
        $resorts = $pdo->query("SELECT id, name FROM resorts")->fetchAll();
        foreach ($resorts as $resort):
        ?>
        <option value="<?= $resort['id'] ?>"><?= $resort['name'] ?></option>
        <?php endforeach; ?>
    </select>
    <label>Accommodation Name:</label>
    <input type="text" name="name" required>
    <label>Description:</label>
    <textarea name="description" rows="5"></textarea>
    <label>Price Per Night ($):</label>
    <input type="number" step="0.01" name="price_per_night" required>
    <label>Rating (1-5):</label>
    <input type="number" min="1" max="5" name="rating">
    <label>Amenities (comma separated):</label>
    <textarea name="amenities" placeholder="Pool, WiFi, Restaurant"></textarea>
    <label>Image:</label>
    <input type="file" name="image" required>
    <button type="submit">Add Accommodation</button>
</form>
        </body>

        </html>