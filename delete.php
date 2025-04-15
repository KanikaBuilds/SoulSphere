<?php
include 'db.php';

$id = $_POST['id'] ?? null;

if ($id) {
    // Delete votes related to the message (optional cleanup)
    $conn->query("DELETE FROM votes WHERE message_id = $id");

    // Delete the message
    $conn->query("DELETE FROM messages WHERE id = $id");

    header("Location: view.php?deleted=1");
} else {
    echo "Invalid message ID.";
}
?>
