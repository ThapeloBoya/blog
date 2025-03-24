<?php
include('../includes/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the data from the form
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category_id = $_POST['category_id'];
    $status = $_POST['status'];
    $id = $_POST['id'];

    // Update the post in the database
    $sql = "UPDATE posts SET title = :title, content = :content, category_id = :category_id, status = :status WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':content', $content);
    $stmt->bindParam(':category_id', $category_id);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    // Redirect to the index page after updating
    header('Location: admin_home.php');
    exit;
}

// Get the post data to pre-fill the form
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM posts WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $post = $stmt->fetch(PDO::FETCH_ASSOC);
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
<form action="edit_post.php" method="POST">
    <input type="hidden" name="id" value="<?php echo $post['id']; ?>">

    <label for="title">Title:</label>
    <input type="text" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required><br><br>

    <label for="content">Content:</label>
    <textarea name="content" required><?php echo htmlspecialchars($post['content']); ?></textarea><br><br>

    <label for="category_id">Category:</label>
    <select name="category_id" required>
        <?php foreach ($categories as $category): ?>
            <option value="<?php echo $category['id']; ?>" <?php echo ($category['id'] == $post['category_id']) ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($category['name']); ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <label for="status">Status:</label>
    <select name="status">
        <option value="draft" <?php echo ($post['status'] == 'draft') ? 'selected' : ''; ?>>Draft</option>
        <option value="published" <?php echo ($post['status'] == 'published') ? 'selected' : ''; ?>>Published</option>
    </select><br><br>

    <button type="submit">Update Post</button>
    <a href="create_post.php" class="btn">Create Post</a>
</form>
<?php include('../includes/footer.php'); ?>
</body>
</html>