<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require 'database.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit();
}

$adminUsername = $_SESSION['username'];

// Initialize PDO connection using constants from database.php
$pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);

// Fetch admin details from the 'users' table
$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$adminUsername]);
$adminDetails = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the logged-in user has admin privileges
if (!isset($adminDetails['userType']) || $adminDetails['userType'] !== 'admin') {
    echo "You don't have permission to access this page.";
    exit();
}
?>
