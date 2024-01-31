<?php
require_once __DIR__ . '/../../vital/secure.php'; //Includes database connection and session login

// Fetch user profile details
$stmt = $pdo->prepare("SELECT * FROM club_members WHERE customer_name = ?");
$stmt->execute([$username]);
$userProfile = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the user profile exists
if (!$userProfile) {
    echo "User profile not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>User Profile</h1>

        <p><strong>Username:</strong> <?= $userProfile['customer_name'] ?></p>
        <p><strong>Email:</strong> <?= $userProfile['email'] ?></p>
        <p><strong>Phone Number:</strong> <?= $userProfile['phone_number'] ?></p>
        <p><strong>Address:</strong> <?= $userProfile['address'] ?></p>

        <a href="edit_profile.php">Edit Profile</a>
    </div>
</body>
</html>
