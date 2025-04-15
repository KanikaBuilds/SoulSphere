<nav class="navbar">
    <div class="navbar-left">
        <a href="index.php" class="brand">SoulSphere</a>
    </div>

    <div class="navbar-center">
        <ul class="navbar-links">
            <li><a href="voc.php">📢 VoC</a></li>
            <li><a href="wellness.php">🧘 Wellness</a></li>
            <li><a href="helpcircle.php">🤝 Help Circle</a></li>
            <li><a href="resources.php">📚 Resources</a></li>
            <li><a href="about.php">ℹ️ About Us</a></li>
        </ul>
    </div>

    <div class="navbar-right">
        <?php
        if (session_status() === PHP_SESSION_NONE) session_start();
        ?>
        <?php if (isset($_SESSION['user'])): ?>
            <a href="logout.php" class="logout">🚪 Logout</a>
        <?php else: ?>
            <a href="login.php" class="auth-link">🔐 Login</a>
            <a href="signup.php" class="auth-link">📝 Signup</a>
        <?php endif; ?>
    </div>
</nav>
