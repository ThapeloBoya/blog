<?php
include('./includes/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect user input
    $email = $_POST['email'];
    $username = $_POST['username'];  // Collect the username
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);  // Hash the password

    // Insert user into the database
    $sql = "INSERT INTO users (email, username, password) VALUES (:email, :username, :password)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':username', $username);  // Bind the username
    $stmt->bindParam(':password', $password);
    $stmt->execute();

    // Redirect to login page
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Include the CSS file -->
</head>
<body>
<div class="login-container">
<h2 class="login">Register</h2>
<form action="register.php" method="POST">
    <input type="text" name="username" required placeholder="Username..."><br><br>
    <input type="email" name="email" required placeholder="Email Address..."><br><br>
    <input type="password" name="password" required placeholder="Password..."><br><br>

    <button type="submit">Register</button>
</form>  
<p>Already have an account? <a href="login.php" class="register">Login</a> to continue.</p>
</div>
</body>
</html>
