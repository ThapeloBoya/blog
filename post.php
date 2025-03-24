<?php
include 'includes/db.php';

// Get post ID from URL
$post_id = $_GET['id'];

// Fetch the specific post
$stmt = $pdo->prepare('SELECT * FROM posts WHERE id = :id');
$stmt->execute(['id' => $post_id]);
$post = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$post) {
    die('Post not found!');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <title><?= $post['title'] ?></title>
</head>
<body>
  <h1><?= $post['title'] ?></h1>
  <p><?= $post['content'] ?></p>
  <small>Published on <?= $post['created_at'] ?></small>
  <br><br>
  <a href="index.php">Back to Home</a>
</body>
</html>
