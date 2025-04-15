<?php
include 'nav.php';
include 'db.php';
include 'functions.php';

$msg = getDailyMessage($conn);
?>


<!DOCTYPE html>
<html>
<head>
    <title>Voices of the Crowd</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="soulsphere.css">
</head>
<body class="" onload="checkDarkMode()">
<div class="dark-toggle-container">
    <button class="toggle-dark-mode" onclick="toggleDarkMode()">🌓</button>
</div>
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

    <h1>📢 Voices of the Crowd</h1>

    <div class="vault">
        <h2>✨ Today's Voice</h2>
        <p><?= htmlspecialchars($msg['content']) ?></p>

        <form id="voteForm">
            <input type="hidden" name="message_id" value="<?= $msg['id'] ?>">
            <button type="button" onclick="submitVote('up')">👍</button>
            <button type="button" onclick="submitVote('down')">👎</button>
        </form>
        <div id="voteResponse"></div>
    </div>

    <h3>Submit a New Message</h3>
    <form method="POST" action="submit.php">
        <textarea name="message" required placeholder="Share your wisdom..."></textarea><br>
        <select name="category">
            <option value="Life">Life</option>
            <option value="Career">Career</option>
            <option value="Love">Love</option>
            <option value="Mental Health">Mental Health</option>
        </select><br>
        <button type="submit">Submit</button>
    </form>

    <a href="view.php">🔍 View All Messages</a>

    <script src="script.js"></script>
</body>
</html>
