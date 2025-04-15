<?php include 'nav.php'; ?>
<?php
// session_start();
include 'db.php';

$error = ""; // Initialize error variable

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to check if user exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username); // Use $username here
    $stmt->execute();
    $result = $stmt->get_result();
    $userData = $result->fetch_assoc();

    // Verify password
    if ($userData && password_verify($password, $userData['password'])) {
        $_SESSION['admin'] = true;
        header("Location: admin.php");
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="soulsphere.css">
</head>
<body>
    <h2>Admin Login</h2>
    <form method="POST">
    <input type="text" name="username" placeholder="Username" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit">Login</button><br><br>
    
    <!-- Forgot Password Link -->
    <a href="forgot_password.php" style="color: blue; text-decoration: underline;">Forgot Password?</a>
    
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
</form>

</body>
</html>
