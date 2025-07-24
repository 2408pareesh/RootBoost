<?php
session_start();
require 'db_connection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: edit_user.php");
    exit;
}




// Fetch current user info
$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'] ?? '';

// Fetch all users for both admin and user roles
$stmt = $pdo->query("SELECT id, fullname, email, username, role FROM users ORDER BY id DESC");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= ucfirst($role) ?> Panel - RootBoost</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body style="background-color: #f2f4f8;">
<div class="container mt-5">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2><?= ucfirst($role) ?> Panel</h2>
    <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
  </div>

  <?php if ($role === 'admin'): ?>
    <!-- Admin Panel -->
    <div class="mb-3">
      <a href="admin_create_user.php" class="btn btn-primary">
        <i class="fas fa-user-plus"></i> Create New User
      </a>
    </div>

    <div class="card mb-4">
      <div class="card-header bg-dark text-white">User Management (Admin Access)</div>
      <div class="card-body">
        <table class="table table-bordered table-hover">
          <thead class="table-dark">
            <tr>
              <th>ID</th>
              <th>Full Name</th>
              <th>Email</th>
              <th>Username</th>
              <th>Role</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($users): ?>
              <?php foreach ($users as $user): ?>
                <tr>
                  <td><?= $user['id'] ?></td>
                  <td><?= htmlspecialchars($user['fullname']) ?></td>
                  <td><?= htmlspecialchars($user['email']) ?></td>
                  <td><?= htmlspecialchars($user['username']) ?></td>
                  <td><?= $user['role'] ?></td>
                  <td>
                    <a href="edit_user.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="delete_user.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this user?')">Delete</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr><td colspan="6" class="text-center">No users found.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

  <?php elseif ($role === 'user'): ?>
    <!-- User Panel (Read-Only) -->
    <div class="card">
      <div class="card-header bg-primary text-white">Users List (Read-Only)</div>
      <div class="card-body">
        <table class="table table-bordered table-hover">
          <thead class="table-primary">
            <tr>
              <th>ID</th>
              <th>Full Name</th>
              <th>Email</th>
              <th>Username</th>
              <th>Role</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($users as $user): ?>
              <tr>
                <td><?= $user['id'] ?></td>
                <td><?= htmlspecialchars($user['fullname']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= htmlspecialchars($user['username']) ?></td>
                <td><?= $user['role'] ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

  <?php else: ?>
    <div class="alert alert-warning">Unauthorized access.</div>
  <?php endif; ?>

</div>

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
