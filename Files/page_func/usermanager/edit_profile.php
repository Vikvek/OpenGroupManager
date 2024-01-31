<?php
require_once __DIR__ . '/../../vital/secure.php'; //Includes database connection and session login

// Fetch user profile details
$stmt = $pdo->prepare("SELECT * FROM club_members WHERE name = ?");
$stmt->execute([$username]); // Change $name to $username
$userProfile = $stmt->fetch(PDO::FETCH_ASSOC);


// Handle form submission to update user profile
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];

    try {
        $stmt = $pdo->prepare("UPDATE club_members SET email = ?, phone_number = ?, address = ? WHERE name = ?");
        $stmt->execute([$email, $phone_number, $address, $name]);
        header("Location: profile.php");
        exit();
    } catch (PDOException $e) {
        die("Error updating profile: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User Profile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Edit User Profile</h1>

        <form action="edit_profile.php" method="post">
            <label for="email">Email:</label>
            <input type="email" name="email" value="<?= $userProfile['email'] ?>" required>

            <label for="phone_number">Phone Number:</label>
            <input type="tel" name="phone_number" value="<?= $userProfile['phone_number'] ?>" required>

            <label for="address">Address:</label>
            <textarea name="address" required><?= $userProfile['address'] ?></textarea>

            <button type="submit">Update Profile</button>
        </form>

        <a href="profile.php">Back to Profile</a>
    </div>
</body>
</html>
