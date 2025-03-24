<?php
session_start();
include('./includes/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Fetch user from the database
    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verify password and check if user exists
    if ($user && password_verify($password, $user['password'])) {
        // Store user info in the session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role']; // Store user role
        $_SESSION['username'] = $user['username']; // Store the username

        // Redirect based on role
        if ($user['role'] === 'admin') {
            header('Location: admin/admin_home.php');
        } else {
            header('Location: user/user_home.php');
        }
        exit;
    } else {
        $error = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="login-container">
    <h2 class="login">Login</h2>
<form action="login.php" method="POST">
    <input type="email" name="email" required placeholder="Email..."><br><br>

    <input type="password" name="password" required placeholder="Password..."><br><br>

    <button type="submit">Login</button>
</form>
<p>Don't have an account? <a href="register.php" class="register">Register</a> to continue.</p>
<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
</div>
<?php include('includes/footer.php'); ?>
</body>
</html>
