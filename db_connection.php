<?php
// Show PHP errors (for development only)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database credentials
$host = 'localhost';
$db   = 'rootboost_db'; 
$user = 'root';        
$pass = '';            
$charset = 'utf8mb4';   

// Data Source Name (DSN)
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// PDO options
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

// Try connecting
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    // echo "Connection successful"; // optional
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>




