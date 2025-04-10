<?php
require '../includes/db.php';
require '../includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize all inputs
    $name = htmlspecialchars($_POST['name']);
    $location = htmlspecialchars($_POST['location']);
    $description = htmlspecialchars($_POST['description']); // Sanitized description
    $attractions = htmlspecialchars($_POST['attractions']);
    $best_time = htmlspecialchars($_POST['best_time_to_visit']);

    // Handle image upload
    $target_dir = "../images/resorts/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

    // Prepare and execute SQL with all parameters
    $stmt = $pdo->prepare("INSERT INTO resorts
                        (name, location, description, attractions, best_time_to_visit, image_path)
                        VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $name,
        $location,
        $description, // Sanitized description
        $attractions,
        $best_time,
        $target_file
    ]);
    header("Location: dashboard.php?success=1");
    exit();
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Add New Resort</title>
    <!-- Existing CSS -->
    <!-- Add CKEditor -->
    <script src="assets\ckeditor5-45.0.0\ckeditor5.js"></script>
    <!-- Custom Editor Styling -->
    <style>
    .cke_top {
    background: #f5f5f5 !important;
    border-radius: 5px 5px 0 0;
    }
    .cke_bottom {
    background: #f5f5f5 !important;
}
</style>
</head>
<body>
    <form method="post" enctype="multipart/form-data">
        <h2>Add New Resort</h2>
        <label>Resort Name:</label>
        <input type="text" name="name" required>
        <label>Location:</label>
        <input type="text" name="location" required>
        <label>Description:</label>
        <textarea name="description" id="editor"></textarea>
        <script>
            CKEDITOR.replace('editor', {
                toolbar: [
                    ['Bold', 'Italic', 'Underline', '-', 'NumberedList', 'BulletedList']
            ],
            height: 200,
            removeButtons: 'Source,Save,NewPage,Preview,Print,Templates',
            removePlugins: 'elementspath',
            resize_enabled: false
            });
        </script>
        <label>Main Image:</label>
        <input type="file" name="image" accept="image/*" required>
        <label>Attractions (one per line):</label>
        <textarea name="attractions" rows="3"></textarea>
        <label>Best Time to Visit:</label>
        <input type="text" name="best_time_to_visit">
        <button type="submit">Add Resort</button>
    </form>
</body>
</html>