<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

require 'db_connection.php';

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Prevent deleting yourself
    if ($user_id != $_SESSION['user_id']) {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
    }
}

header("Location: admin_panel.php");
exit;
