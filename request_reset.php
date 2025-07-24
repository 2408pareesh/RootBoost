<?php
session_start();
require_once 'db_connection.php'; // Ensure this file defines $pdo

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');

    if (empty($username)) {
        $_SESSION['reset_error'] = "Username is required.";
        header("Location: request_reset.php");
        exit();
    }

    // Check if user exists
    $stmt = $pdo->prepare("SELECT * FROM rootboost WHERE username = :username");
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch();

    if (!$user) {
        $_SESSION['reset_error'] = "User not found.";
        header("Location: request_reset.php");
        exit();
    }

    // Generate a reset token
    $token = bin2hex(random_bytes(16));
    $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

    // Store token and expiration (You need to add these columns to your table)
    $update = $pdo->prepare("UPDATE rootboost SET reset_token = :token, reset_expires = :expires WHERE username = :username");
    $update->execute([
        ':token' => $token,
        ':expires' => $expires,
        ':username' => $username
    ]);

    // Simulate sending email (or display link)
    $resetLink = "http://localhost/RootBoost/reset_password.php?token=$token";

    $_SESSION['reset_success'] = "Password reset link: <a href='$resetLink'>$resetLink</a>";
    header("Location: request_reset.php");
    exit();
}
?>

<!-- HTML FORM -->
<!DOCTYPE html>
<html>
<head>
    <title>Request Password Reset</title>
</head>
<body>

<h2>Forgot Password</h2>

<form method="POST">
    <input type="text" name="username" placeholder="Enter your username" required><br><br>
    <button type="submit">Request Reset Link</button>
</form>

<p style="color: red;">
    <?= $_SESSION['reset_error'] ?? '' ?>
    <?php unset($_SESSION['reset_error']); ?>
</p>

<p style="color: green;">
    <?= $_SESSION['reset_success'] ?? '' ?>
    <?php unset($_SESSION['reset_success']); ?>
</p>

</body>
</html>
