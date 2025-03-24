<?php
// Correct the path to db.php
include('../includes/db.php');  // Moving up one directory from 'posts' folder to 'includes'

$id = $_GET['id'];  // Get the post ID from the query string

// Prepare the delete query
$sql = "DELETE FROM posts WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);

// Execute the query and redirect
if ($stmt->execute()) {
    header("Location: ../index.php");  // Redirect to the homepage after deletion
    exit;
} else {
    echo "Error deleting the post!";
}
?>
