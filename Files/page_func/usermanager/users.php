<?php
require_once __DIR__ . '/../../vital/secure.php';

// Handle form submission to update user profile
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $editedBy = $username;
    $editedAt = date('Y-m-d H:i:s');
    
    // Assume you have form fields named 'email', 'phone_number', 'address'
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];

    try {
        $stmt = $pdo->prepare("UPDATE club_members SET email = ?, phone_number = ?, address = ?, edited_by = ?, edited_at = ? WHERE name = ?");
        $stmt->execute([$email, $phone_number, $address, $editedBy, $editedAt, $username]);
        $updateMessage = "Profile updated by $editedBy on $editedAt";
    } catch (PDOException $e) {
        die("Error updating profile: " . $e->getMessage());
    }
}

// Fetch all users
$stmt = $pdo->query("SELECT * FROM club_members");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch distinct user types and clubs for filtering
$stmt = $pdo->query("SELECT DISTINCT userType FROM users");
$userTypes = $stmt->fetchAll(PDO::FETCH_COLUMN);
$stmt = $pdo->query("SELECT DISTINCT userType FROM users");
$clubs = $stmt->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link rel="stylesheet" href="https://mannemarket.fi/onlinecss.css">
</head>
<body>
						<?php
						include "../../elements/menu.php";
						?>
    <div class="container">
        <h1>User Management</h1>

        <!-- Filter form -->
        <form action="users.php" method="get">
            <label for="type">Filter by Type:</label>
            <select name="type">
                <option value="">All</option>
                <?php foreach ($userTypes as $type): ?>
                    <option value="<?= $type ?>"><?= $type ?></option>
                <?php endforeach; ?>
            </select>

            <label for="club">Filter by Club:</label>
            <select name="club">
                <option value="">All</option>
                <?php foreach ($clubs as $club): ?>
                    <option value="<?= $club ?>"><?= $club ?></option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Filter</button>
        </form>

        <!-- Users list -->
 <table>
    <thead>
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th>Address</th>
            <th>Type</th>
            <th>Club</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user['customer_name'] ?></td>
                <td><?= $user['email'] ?></td>
                <td><?= $user['phone_number'] ?></td>
                <td><?= $user['address'] ?></td>
                <td><?= isset($user['type']) ? $user['type'] : 'N/A' ?></td>
                <td><?= isset($user['club']) ? $user['club'] : 'N/A' ?></td>
                <td>
                    <a href="edit_users.php?username=<?= $user['customer_name'] ?>">Edit</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>


        <!-- Edit Profile Section -->
        <?php if (isset($updateMessage)): ?>
            <div class="update-message"><?= $updateMessage ?></div>
        <?php endif; ?>

    </div>
</body>
</html>
