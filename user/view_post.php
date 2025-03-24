<?php
session_start();
include('../includes/db.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

// Fetch post details and comments for the post
if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];

    // Fetch post data
    $sql = "SELECT * FROM posts WHERE id = :post_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':post_id', $post_id);
    $stmt->execute();
    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fetch comments for the post
    $sql = "SELECT comments.comment, comments.created_at, users.email AS commenter
            FROM comments
            JOIN users ON comments.user_id = users.id
            WHERE comments.post_id = :post_id
            ORDER BY comments.created_at DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':post_id', $post_id);
    $stmt->execute();
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Redirect to the homepage if no post ID is provided
    header('Location: user_home.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Post</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include('../includes/header.php'); ?>
<div class="user-container">
<h1><?php echo htmlspecialchars($post['title']); ?></h1>
<p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
<p><small>Posted on <?php echo $post['created_at']; ?></small></p>

<hr>

<h2>Comments</h2>

<!-- Display Comments -->
<?php if (!empty($comments)): ?>
    <ul>
        <?php foreach ($comments as $comment): ?>
            <li>
                <p><strong><?php echo htmlspecialchars($comment['commenter']); ?>:</strong> <?php echo nl2br(htmlspecialchars($comment['comment'])); ?></p>
                <p><small>Commented on <?php echo $comment['created_at']; ?></small></p>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No comments yet. Be the first to comment!</p>
<?php endif; ?>

<!-- Comment Form -->
<h3>Leave a Comment</h3>
<form action="comment.php" method="POST">
    <textarea name="comment" required></textarea><br><br>
    <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
    <button type="submit">Submit Comment</button>
</form>
</div>
<a href="user_home.php">Back to Home</a>
<?php include('../includes/footer.php'); ?>
</body>
</html>
