<?php
include 'db.php';

// 🔍 Handle search query
$search = $_GET['q'] ?? '';
$search = $conn->real_escape_string($search);

// 📊 Sort by most voted (default)
if ($search) {
    $query = "SELECT * FROM messages WHERE content LIKE '%$search%' OR category LIKE '%$search%' ORDER BY votes DESC";
} else {
    $query = "SELECT * FROM messages ORDER BY votes DESC";
}

$res = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Messages</title>
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

    <h1>🗂️ All Submitted Messages</h1>

    <form method="GET">
        <input type="text" name="q" placeholder="Search keyword or category..." value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
        <button type="submit">Search</button>
        <?php if ($search): ?>
            <a href="view.php">❌ Clear</a>
        <?php endif; ?>
    </form>

    <?php if ($res->num_rows > 0): ?>
        <?php while ($m = $res->fetch_assoc()): ?>
            <div class="msg-box">
                <p><?= htmlspecialchars($m['content']) ?></p>
                <small>Votes: <?= $m['votes'] ?> | Category: <?= htmlspecialchars($m['category']) ?></small><br>
                <form method="POST" action="delete.php" onsubmit="return confirm('Delete this message?');">
                    <input type="hidden" name="id" value="<?= $m['id'] ?>">
                    <button type="submit" class="delete-btn">🗑️ Delete</button>
                </form>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No messages found.</p>
    <?php endif; ?>

    <a href="index.php">🔙 Back to Main</a>
</body>
</html>
