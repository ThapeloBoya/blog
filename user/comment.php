<?php
session_start();
include('../includes/db.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}
// Fetch the username from the session
$username = $_SESSION['username']; // This will fetch the username from the session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect user input
    $post_id = $_POST['post_id'];
    $comment = $_POST['comment'];
    $user_id = $_SESSION['user_id']; // Assuming the user's ID is stored in session

    // Insert comment into the database
    $sql = "INSERT INTO comments (post_id, user_id, comment) VALUES (:post_id, :user_id, :comment)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':post_id', $post_id);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':comment', $comment);
    $stmt->execute();

    // Redirect back to the post page
    header('Location: user_home.php');
    exit;
}

// Fetch post details for the comment form
if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];
    $sql = "SELECT * FROM posts WHERE id = :post_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':post_id', $post_id);
    $stmt->execute();
    $post = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comment on Post</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include('../includes/header.php'); ?>
<div class="user-container">
    <h1>Comment on "<?php echo htmlspecialchars($post['title']); ?>"</h1>
    <form action="comment.php" method="POST">
        <textarea name="comment" required></textarea><br><br>
        <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
        <button type="submit">Submit Comment</button>
    </form>
    </div>
    <?php include('../includes/footer.php'); ?>
</body>
</html>
