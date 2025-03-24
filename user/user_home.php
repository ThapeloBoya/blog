<?php
session_start();
include('../includes/db.php');

// If the user is not logged in, redirect to login page
if (!isset($_SESSION['user_id'])) {
    header('Location: ../register.php');
    exit;
}

// Fetch the username from the session
$username = $_SESSION['username']; // This will fetch the username from the session

// Fetch only published posts for users
$sql = "SELECT * FROM posts WHERE status = 'published' ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Include the CSS file -->
</head>
<body>
    <div class="user-container">
    <?php include('../includes/header.php'); ?>
    <!-- Posts Container -->
    <h1 class="title">Latest posts</h1>
    <div class="posts">
        <?php if (!empty($posts)): ?>
            <?php foreach ($posts as $post): ?>
                <div class="post">
                    <h2><?php echo htmlspecialchars($post['title']); ?></h2>
                    <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                    <p><small>Posted on <?php echo $post['created_at']; ?></small></p>

                    <!-- Link to View the Full Post -->
                    <a href="view_post.php?post_id=<?php echo $post['id']; ?>" class="btn">View Post</a>
                    
                    <!-- Link to Comment on the Post -->
                    <a href="comment.php?post_id=<?php echo $post['id']; ?>" class="btn">Comment</a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No published posts available.</p>
        <?php endif; ?>
    </div>
    </div>
    <?php include('../includes/footer.php'); ?>
</body>
</html>
