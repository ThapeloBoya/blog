<?php
session_start();
include('../includes/db.php');

// If the user is not logged in, redirect to login page
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}
// Fetch the username from the session
$username = $_SESSION['username']; // This will fetch the username from the session
// Fetch the user's current profile details
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = :user_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle profile update request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bio = $_POST['bio'];
    $phone_number = $_POST['phone_number'];
    
    // Handle file upload for profile picture (optional)
    $profile_pic = $_FILES['profile_pic']['name'];
    if ($profile_pic) {
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES["profile_pic"]["name"]);
        move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file);
    } else {
        $profile_pic = $user['profile_pic']; // Keep the old profile pic if no new one is uploaded
    }

    // Update user information in the database
    $sql = "UPDATE users SET bio = :bio, phone_number = :phone_number, profile_pic = :profile_pic WHERE id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':bio', $bio);
    $stmt->bindParam(':phone_number', $phone_number);
    $stmt->bindParam(':profile_pic', $profile_pic);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();

    // Set success message in the session
    $_SESSION['profile_update_success'] = "Your profile has been successfully updated!";

    // Redirect back to profile page
    header('Location: profile.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="../css/style.css">

</head>
<body>
<div class="user-container">
<!-- Navbar -->
<?php include('../includes/header.php'); ?>
<!-- Display Success Message -->
<?php if (isset($_SESSION['profile_update_success'])): ?>
    <div class="success-message">
        <?php
        echo htmlspecialchars($_SESSION['profile_update_success']);
        unset($_SESSION['profile_update_success']); // Remove the success message after displaying it
        ?>
    </div>
<?php endif; ?>
<h1 class="title">Update portfolio</h1>
<!-- Profile Details Form -->
<form action="profile.php" method="POST" enctype="multipart/form-data" class="form">
    <div>
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($user['username']); ?>" required disabled>
    </div>

    <div>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required disabled>
    </div>

    <div>
        <label for="bio">Bio:</label>
        <textarea name="bio" id="bio"><?php echo htmlspecialchars($user['bio']); ?></textarea>
    </div>

    <div>
        <label for="phone_number">Phone Number:</label>
        <input type="text" name="phone_number" id="phone_number" value="<?php echo htmlspecialchars($user['phone_number']); ?>">
    </div>

    <div>
        <label for="profile_pic">Profile Picture:</label>
        <input type="file" name="profile_pic" id="profile_pic">

    </div>

    <div>
        <button type="submit">Update Profile</button>
    </div>
</form>
        </div>
        <?php include('../includes/footer.php'); ?>
</body>
</html>
