<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: dashboard.php");
    exit;
}

include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = $_POST['fullname'];
    $email    = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role     = $_POST['role'];

    $stmt = $pdo->prepare("INSERT INTO users (fullname, email, username, password, role) VALUES (?, ?, ?, ?, ?)");
    if ($stmt->execute([$fullname, $email, $username, $password, $role])) {
        header("Location: admin_panel.php?success=user_created");
        exit;
    } else {
        echo "Error creating user.";
    }
}
?>

<!-- HTML Form -->
<form method="POST">
  <input type="text" name="fullname" placeholder="Full Name" required><br>
  <input type="email" name="email" placeholder="Email" required><br>
  <input type="text" name="username" placeholder="Username" required><br>
  <input type="password" name="password" placeholder="Password" required><br>
  <select name="role">
    <option value="user">User</option>
    <option value="admin">Admin</option>
  </select><br>
  <button type="submit">Create User</button>
</form>
