<?php
function getDailyMessage($conn) {
    $today = date('Y-m-d');

    $result = $conn->query("SELECT * FROM messages WHERE DATE(timestamp) = '$today' LIMIT 1");

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        $res = $conn->query("SELECT * FROM messages ORDER BY RAND() LIMIT 1");

        if ($res && $res->num_rows > 0) {
            $msg = $res->fetch_assoc();
            $todayDate = date('Y-m-d H:i:s');
            $conn->query("UPDATE messages SET timestamp = '$todayDate' WHERE id = " . $msg['id']);
            return $msg;
        } else {
            return [
                'id' => 0,
                'content' => "No messages yet. Be the first to share something!",
                'votes' => 0,
                'category' => "None",
                'timestamp' => date('Y-m-d H:i:s')
            ];
        }
    }
}


function getAllMessages($conn) {
    $res = $conn->query("SELECT * FROM messages ORDER BY timestamp DESC");
    return $res->fetch_all(MYSQLI_ASSOC);
}
?>
