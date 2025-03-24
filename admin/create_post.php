<?php
include('../includes/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the data from the form
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category_id = $_POST['category_id'];
    $status = $_POST['status'];

    // Insert the post into the database
    $sql = "INSERT INTO posts (title, content, category_id, status) VALUES (:title, :content, :category_id, :status)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':content', $content);
    $stmt->bindParam(':category_id', $category_id);
    $stmt->bindParam(':status', $status);
    $stmt->execute();

    // Redirect after successful post creation
    header('Location: ../index.php');
    exit;
}

// Fetch categories to display in the form
$sql = "SELECT * FROM categories";
$stmt = $conn->prepare($sql);
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
<?php include('../includes/AdminHeader.php'); ?>

<form action="create_post.php" method="POST">
    <label for="title">Title:</label>
    <input type="text" name="title" required><br><br>

    <label for="content">Content:</label>
    <textarea name="content" required></textarea><br><br>

    <label for="category_id">Category:</label>
    <select name="category_id" required>
        <?php foreach ($categories as $category): ?>
            <option value="<?php echo $category['id']; ?>"><?php echo htmlspecialchars($category['name']); ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <label for="status">Status:</label>
    <select name="status">
        <option value="draft">Draft</option>
        <option value="published">Published</option>
    </select><br><br>

    <button type="submit">Create Post</button>
</form>
<?php include('../includes/footer.php'); ?>
</body>
</html>