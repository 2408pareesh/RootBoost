<?php
session_start();

// Database config - change these with your actual credentials
$host = 'localhost';
$dbname = 'rootboost_db';
$user = 'root';       // your DB username
$pass = '';           // your DB password
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,  // throw exceptions
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (!$username || !$password || !$confirm_password) {
        $_SESSION['error'] = "Please fill in all fields.";
        header("Location: register.php");
        exit;
    }

    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Passwords do not match.";
        header("Location: register.php");
        exit;
    }

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM rootboost WHERE username = :username");
    $stmt->execute(['username' => $username]);
    if ($stmt->fetchColumn() > 0) {
        $_SESSION['error'] = "Username already taken.";
        header("Location: register.php");
        exit;
    }

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO rootboost (username, password) VALUES (:username, :password)");
    if ($stmt->execute(['username' => $username, 'password' => $passwordHash])) {
        $_SESSION['success'] = "Registration successful!";
        header("Location: index.php");
        exit;
    } else {
        $_SESSION['error'] = "Registration failed.";
        header("Location: register.php");
        exit;
    }
} else {
    header("Location: register.php");
    exit;
}
?>
