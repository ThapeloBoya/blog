        <!-- Navbar -->
        <div class="navbar">
    <h1>Welcome, <?php echo htmlspecialchars($username ?? 'User'); ?>!</h1>
    <div>
        <a href="profile.php" class="btn">Profile</a>
        <a href="user_home.php" class="btn">Posts</a>
        <a href="../logout.php" class="btn btn-logout">Logout</a>
    </div>
</div>