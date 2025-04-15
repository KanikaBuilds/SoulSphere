<?php
include 'db.php';

$msg_id = $_POST['message_id'];
$vote = $_POST['vote_type'];
$user_ip = $_SERVER['REMOTE_ADDR'];

$check = $conn->query("SELECT * FROM votes WHERE user_ip = '$user_ip' AND message_id = $msg_id");
if ($check->num_rows == 0) {
    $conn->query("INSERT INTO votes (message_id, user_ip, vote_type) VALUES ($msg_id, '$user_ip', '$vote')");
    $change = ($vote === 'up') ? 1 : -1;
    $conn->query("UPDATE messages SET votes = votes + $change WHERE id = $msg_id");
    echo "Thanks for voting!";
} else {
    echo "You already voted!";
}

$vote = $_POST['vote_type'] ?? null;
if (!$vote) {
    echo "Invalid vote.";
    exit;
}

?>
