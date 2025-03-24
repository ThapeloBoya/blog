<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}
// Fetch the username from the session
$username = $_SESSION['username']; // This will fetch the username from the session
include('../includes/db.php');  // Include DB connection file

// Fetch all posts for admin to manage
$sql = "SELECT * FROM posts ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include('../includes/AdminHeader.php'); ?>
    <h1>Admin Dashboard</h1>
    <p>Welcome, <?php echo $_SESSION['email']; ?>!</p>
    <a href="create_post.php" class="btn">Create Post</a>
    <h2>Posts</h2>
    <?php if (!empty($posts)): ?>
        <?php foreach ($posts as $post): ?>
            <div>
                <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                <p><small>Posted on <?php echo $post['created_at']; ?></small></p>
                <a href="edit_post.php?id=<?php echo $post['id']; ?>" class="btn">Edit</a> |
                <a href="delete_post.php?id=<?php echo $post['id']; ?>" class="btn">Delete</a>
                <hr/>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No posts available.</p>
    <?php endif; ?>
    <?php include('../includes/footer.php'); ?>
</body>

</html>
