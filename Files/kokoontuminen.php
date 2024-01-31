<?php
require 'vital/secure.php'; //Includes database connection and session login

// Fetch gatherings from the database
$stmt = $pdo->query("SELECT * FROM gatherings");
$gatherings = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle gathering creation and attendance update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['create_gathering'])) {
        $club_id = $_POST['club_id'];
        $status = 'Planned'; // Default status for a new gathering

        try {
            $stmt = $pdo->prepare("INSERT INTO gatherings (club_id, status, creator) VALUES (?, ?, ?)");
            $stmt->execute([$club_id, $status, $username]);
            $gathering_id = $pdo->lastInsertId();
        } catch (PDOException $e) {
            die("Error creating gathering: " . $e->getMessage());
        }

        // Redirect to the attendance page for the newly created gathering
        header("Location: attendance.php?gathering_id=$gathering_id");
        exit();
    }
}

// Fetch clubs for the dropdown
$stmt = $pdo->query("SELECT * FROM clubs");
$clubs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gathering Management</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
						<?php
						include "elements/menu.php";
						?>
    <div class="container">
        <h1>Gathering Management</h1>

        <!-- Form to create a new gathering -->
        <form action="kokoontuminen.php" method="post">
            <label for="club_id">Select Club:</label>
            <select name="club_id" required>
                <?php foreach ($clubs as $club): ?>
                    <option value="<?= $club['id'] ?>"><?= $club['name'] ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit" name="create_gathering">Create Gathering</button>
        </form>

        <h2>Gatherings</h2>
        <div class="gatherings-container">
            <?php foreach ($gatherings as $gathering): ?>
                <div class="gathering-box <?= strtolower($gathering['status']) ?>">
                    <p><strong>Club:</strong> <?= $gathering['club_id'] ?></p>
                    <p><strong>Status:</strong> <?= $gathering['status'] ?></p>
                    <p><strong>Gathering Date:</strong> <?= $gathering['gathering_date'] ?></p>
                    <p><strong>Gathering Time:</strong> <?= $gathering['gathering_time'] ?></p>
                    <a href='page_func/eventmanager/attendance.php?gathering_id=<?= $gathering['id'] ?>'>Mark Attendance</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
