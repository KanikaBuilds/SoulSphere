<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = $conn->real_escape_string($_POST['content']);
    $category = $conn->real_escape_string($_POST['category']);

    $conn->query("INSERT INTO messages (content, category) VALUES ('$content', '$category')");
    header("Location: admin.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Message</title>
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

    <h2>Add New Message</h2>
    <form method="POST">
        <textarea name="content" rows="5" cols="40" required placeholder="Your message..."></textarea><br><br>
        <input type="text" name="category" placeholder="Category"><br><br>
        <button type="submit">Save</button>
    </form>
</body>
</html>
