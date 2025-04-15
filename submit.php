<?php
include 'db.php';

$msg = trim($_POST['message']);
$cat = $_POST['category'];

if (!empty($msg)) {
    $stmt = $conn->prepare("INSERT INTO messages (content, category) VALUES (?, ?)");
    $stmt->bind_param("ss", $msg, $cat);
    $stmt->execute();
}
header("Location: index.php?submitted=true");
?>
