        <!-- Navbar -->
        <div class="navbar">
    <h1>Welcome, <?php echo htmlspecialchars($username ?? 'User'); ?>!</h1>
    <div>
        <a href="admin_home.php" class="btn">Home</a>
        <a href="./create_post.php" class="btn">Create Posts</a>
        <a href="../logout.php" class="btn btn-logout">Logout</a>
    </div>
</div>