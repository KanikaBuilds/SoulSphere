<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include 'db.php';

$search = $_GET['q'] ?? '';
$search = $conn->real_escape_string($search);

// 🔍 Search & sort logic
if ($search) {
    $res = $conn->query("SELECT * FROM messages WHERE content LIKE '%$search%' OR category LIKE '%$search%' ORDER BY votes DESC");
} else {
    $res = $conn->query("SELECT * FROM messages ORDER BY votes DESC");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" href="style.css">
    </head>
<body class="" onload="checkDarkMode()">
    <button onclick="toggleDarkMode()">🌓 Toggle Dark Mode</button>
    <script>
    function toggleDarkMode() {
        document.body.classList.toggle('dark');
        localStorage.setItem("dark", document.body.classList.contains('dark'));
    }
    function checkDarkMode() {
        if (localStorage.getItem("dark") === "true") {
            document.body.classList.add('dark');
        }
    }
    </script>

    <h2>🔐 Admin Panel</h2>
    <a href="add_message.php">➕ Add New Message</a> | 
    <a href="logout.php">🚪 Logout</a>
    <hr>

    <form method="GET">
        <input type="text" name="q" placeholder="Search keyword or category..." value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
        <button type="submit">Search</button>
        <?php if ($search): ?>
            <a href="admin.php">❌ Clear</a>
        <?php endif; ?>
    </form>

    <?php if ($res->num_rows > 0): ?>
        <?php while ($msg = $res->fetch_assoc()): ?>
            <div class="msg-box">
                <p><?= htmlspecialchars($msg['content']) ?></p>
                <small>
                    Votes: <?= $msg['votes'] ?> | 
                    Category: <?= htmlspecialchars($msg['category']) ?> | 
                    <?= date('d M Y, h:i A', strtotime($msg['timestamp'])) ?>
                </small><br>
                <form method="POST" action="delete.php" onsubmit="return confirm('Delete this message?');">
                    <input type="hidden" name="id" value="<?= $msg['id'] ?>">
                    <button type="submit" class="delete-btn">🗑️ Delete</button>
                </form>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No messages found.</p>
    <?php endif; ?>
    </div> <!-- any content -->
<script>/* JS here */</script>
</body>
</html>
