<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

require 'db_connection.php';

if (!isset($_GET['id'])) {
    header("Location: admin_panel.php");
    exit;
}

$user_id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user) {
    echo "User not found.";
    exit;
}

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $role = $_POST['role'];

    $updateStmt = $pdo->prepare("UPDATE users SET fullname=?, email=?, username=?, role=? WHERE id=?");
    $updateStmt->execute([$fullname, $email, $username, $role, $user_id]);

    header("Location: admin_panel.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit User</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h2>Edit User</h2>
  <form method="POST">
    <div class="mb-3">
      <label class="form-label">Full Name</label>
      <input type="text" name="fullname" class="form-control" value="<?= htmlspecialchars($user['fullname']) ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Email</label>
      <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Username</label>
      <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($user['username']) ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Role</label>
      <select name="role" class="form-control">
        <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>User</option>
        <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
      </select>
    </div>
    <button type="submit" class="btn btn-primary">Update User</button>
    <a href="admin_panel.php" class="btn btn-secondary">Cancel</a>
  </form>
</div>
</body>
</html>
