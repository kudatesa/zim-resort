<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['username'] === 'admin' && $_POST['password'] === 'admin') {
        $_SESSION['admin_logged_in'] = true;
        header("Location: dashboard.php");
        exit();
} else {
        $error = "Invalid credentials!";
    }
}
?>

<!DOCTYPE html>

<html>
<head>
<title>Admin Login</title>
</head>
<body>
    <h1>Login</h1>
    <?php if (isset($error)) echo "<p style='color:red'>$error</p>"; ?>
    <form method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
</body>
</html>