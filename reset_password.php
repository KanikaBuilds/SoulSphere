<?php
include 'db.php';

$error = '';
$success = '';

// Check if token is present in the URL
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Prepare the query to check if the token exists in the database
    $stmt = $conn->prepare("SELECT * FROM users WHERE reset_token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    // If token exists in the database, allow password reset
    if ($result && $result->num_rows > 0) {
        // Handle form submission for password reset
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'] ?? '';
            $confirm = $_POST['confirm'] ?? '';

            // Validate password
            if ($password !== $confirm) {
                $error = "Passwords do not match!";
            } elseif (strlen($password) < 5) {
                $error = "Password must be at least 5 characters!";
            } else {
                // Hash the new password
                $hashed = password_hash($password, PASSWORD_DEFAULT);

                // Update the password in the database and clear the reset token
                $stmt = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL WHERE reset_token = ?");
                $stmt->bind_param("ss", $hashed, $token);

                if ($stmt->execute()) {
                    $success = "Your password has been successfully reset!";
                } else {
                    $error = "Failed to reset password. Please try again.";
                }
            }
        }
    } else {
        $error = "Invalid or expired token.";
    }
} else {
    $error = "No reset token provided.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | SoulSphere</title>
    <link rel="stylesheet" href="soulsphere.css">
    <style>/* Style for reset password page */
body.reset-password-page {
    margin: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
}

.reset-container {
    background-color: #1e2b38;
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
    max-width: 400px;
    width: 100%;
    text-align: center;
}

.reset-container h2 {
    margin-bottom: 20px;
    color: #f0f0f0;
}

.form-group {
    text-align: left;
    margin-bottom: 15px;
}

label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

input[type="password"] {
    width: 100%;
    padding: 10px;
    border: none;
    border-radius: 8px;
    outline: none;
    font-size: 16px;
    background-color: #2f3d4f;
    color: #fff;
}

input[type="password"]::placeholder {
    color: #bbb;
}

button {
    width: 100%;
    padding: 12px;
    font-size: 16px;
    background-color: #4db8ff;
    color: #fff;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    margin-top: 15px;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #3399ff;
}

.error-message,
.success-message {
    padding: 12px;
    border-radius: 6px;
    margin-bottom: 20px;
    font-weight: bold;
}

.error-message {
    background-color: #ff4d4d;
    color: #fff;
}

.success-message {
    background-color: #4CAF50;
    color: #fff;
}
</style>
</head>
<body class="reset-password-page">
    <div class="reset-container">
        <h2>Reset Your Password</h2>

        <!-- Display errors or success messages -->
        <?php if ($error): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php elseif ($success): ?>
            <div class="success-message"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <!-- Display the password reset form if not already successful -->
        <?php if (!$success): ?>
        <form method="POST">
            <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" name="password" id="password" placeholder="New Password" required><br><br>
            </div>
            <div class="form-group">
                <label for="confirm">Confirm Password</label>
                <input type="password" name="confirm" id="confirm" placeholder="Confirm Password" required><br><br>
            </div>
            <button type="submit">Reset Password</button>
        </form>
        <?php endif; ?>
    </div>
</body>
</html>
