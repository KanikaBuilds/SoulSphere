<?php include 'nav.php'; ?>
<?php
include 'db.php';

$info = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identifier = $_POST['identifier'];

    // Check if user exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $identifier, $identifier);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        $token = bin2hex(random_bytes(16));
        $stmt = $conn->prepare("UPDATE users SET reset_token = ? WHERE id = ?");
        $stmt->bind_param("si", $token, $user['id']);
        $stmt->execute();
    
        $resetLink = "http://localhost/SoulSphere/reset_password.php?token=" . $token;
    
        // Send email with reset link
        include 'send_reset_email.php';
        if (sendResetEmail($user['email'], $resetLink)) {
            $info = "Reset instructions sent to your email.";
        } else {
            $info = "Failed to send reset email. Please try again.";
        }
    }
    
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="soulsphere.css">
</head>
<body>
    <h2>Forgot Password</h2>
    <form method="POST">
        <input type="text" name="identifier" placeholder="Enter username or email" required><br><br>
        <button type="submit">Recover Password</button><br><br>
        <?php if (!empty($info)) echo "<p style='color: green;'>$info</p>"; ?>
    </form>
</body>
</html>
