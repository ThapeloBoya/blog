<?php
session_start();

// Redirect logged-in users
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] === 'admin') {
        header('Location: admin/admin_home.php');
        exit;
    } else {
        header('Location: user/user_home.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to My Blog</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Include the CSS file -->
</head>
<body>

<div class="container">
    <div class="image-container">
        <img src="./images/index.jpg" alt="Blog Image">
    </div>
    <div class="text-container">
        <h1>Welcome Back!</h1>
        <p>Welcome to my blog—where ideas pop, insights drop, and curiosity never stops. Dive in for a mix of fun reads and fresh perspectives!</p>
        <p> Join me on this journey of discovery and exploration!</p>
        <p><a href="login.php">Login</a> or <a href="register.php">Register</a> to continue.</p>
    </div>
</div>
<?php include('includes/footer.php'); ?>

</body>
</html>
