<?php
require_once __DIR__ . '/../../vital/secure.php'; //Includes database connection and session login

// Fetch user details based on the provided username
if (isset($_GET['username'])) {
    $editUsername = $_GET['username'];

    // Fetch user profile details from the 'club_members' table
    $stmt = $pdo->prepare("SELECT * FROM club_members WHERE customer_name = ?");
    $stmt->execute([$editUsername]);
    $editUser = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$editUser) {
        die("User not found.");
    }
} else {
    header("Location: users.php"); // Redirect to users page if no username provided
    exit();
}

// Handle form submission to update user profile
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $editedBy = $adminUsername;
    $editedAt = date('Y-m-d H:i:s');
    
    // Validate and sanitize inputs (implement validation logic)

    // Assume you have form fields named 'email', 'phone_number', 'address'
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];

    try {
        $stmt = $pdo->prepare("UPDATE club_members SET email = ?, phone_number = ?, address = ?, edited_by = ?, edited_at = ? WHERE customer_name = ?");
        $stmt->execute([$email, $phone_number, $address, $editedBy, $editedAt, $editUsername]);
        $updateMessage = "Profile updated by $editedBy on $editedAt";
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
        <h1>Edit User Profile - <?= $editUsername ?></h1>

        <!-- Edit Profile Form -->
        <form action="edit_users.php?username=<?= $editUsername ?>" method="post">
            <label for="email">Email:</label>
            <input type="email" name="email" value="<?= $editUser['email'] ?>" required>

            <label for="phone_number">Phone Number:</label>
            <input type="tel" name="phone_number" value="<?= $editUser['phone_number'] ?>" required>

            <label for="address">Address:</label>
            <textarea name="address" required><?= $editUser['address'] ?></textarea>

            <button type="submit">Update Profile</button>
        </form>

        <!-- Back to Users Page Link -->
        <a href="users.php?username=<?= $editUsername ?>">Back to Users Page</a>

        <!-- Update Message Section -->
        <?php if (isset($updateMessage)): ?>
            <div class="update-message"><?= $updateMessage ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
