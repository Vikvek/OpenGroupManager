<?php
require_once __DIR__ . '/../../vital/secure.php';


if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['gathering_id'])) {
    $gathering_id = $_GET['gathering_id'];

    // Fetch gathering details
    $stmt = $pdo->prepare("SELECT * FROM gatherings WHERE id = ?");
    $stmt->execute([$gathering_id]);
    $gathering = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fetch club members for the selected club
    $stmt = $pdo->prepare("SELECT * FROM club_members WHERE club_id = ?");
    $stmt->execute([$gathering['club_id']]);
    $clubMembers = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $gathering_id = $_POST['gathering_id'];
    $attendance = isset($_POST['attendance']) ? $_POST['attendance'] : [];

    // Update attendance in the database
    try {
        $stmt = $pdo->prepare("UPDATE gatherings SET attendance = ? WHERE id = ?");
        $stmt->execute([implode(',', $attendance), $gathering_id]);
    } catch (PDOException $e) {
        die("Error updating attendance: " . $e->getMessage());
    }

    // Update gathering status, date, and time
    $status = $_POST['status'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    try {
        $stmt = $pdo->prepare("UPDATE gatherings SET status = ?, gathering_date = ?, gathering_time = ? WHERE id = ?");
        $stmt->execute([$status, $date, $time, $gathering_id]);
    } catch (PDOException $e) {
        die("Error updating gathering details: " . $e->getMessage());
    }

    // Redirect back to the gathering list
    header("Location: ../../kokoontuminen.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Management</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Attendance Management</h1>

        <?php if (isset($gathering) && isset($clubMembers)): ?>
            <h2>Gathering Details</h2>
            <p><strong>Club:</strong> <?= $gathering['club_id'] ?></p>
            <p><strong>Status:</strong> <?= $gathering['status'] ?></p>
            <p><strong>Gathering Date:</strong> <?= $gathering['gathering_date'] ?></p>
            <p><strong>Gathering Time:</strong> <?= $gathering['gathering_time'] ?></p>

            <h2>Mark Attendance</h2>
            <form action="attendance.php" method="post">
                <input type="hidden" name="gathering_id" value="<?= $gathering_id ?>">

                <label>Select attendees:</label>
                <?php foreach ($clubMembers as $member): ?>
                    <label>
                        <input type="checkbox" name="attendance[]" value="<?= $member['customer_name'] ?>" 
                            <?= in_array($member['customer_name'], explode(',', $gathering['attendance'])) ? 'checked' : '' ?>>
                        <?= $member['customer_name'] ?>
                    </label>
                <?php endforeach; ?>

                <h3>Gathering Status</h3>
                <label for="status">Select status:</label>
                <select name="status">
                    <option value="Planned" <?= $gathering['status'] == 'Planned' ? 'selected' : '' ?>>Planned</option>
                    <option value="Canceled" <?= $gathering['status'] == 'Canceled' ? 'selected' : '' ?>>Canceled</option>
                    <option value="Completed" <?= $gathering['status'] == 'Completed' ? 'selected' : '' ?>>Completed</option>
                </select>

                <h3>Gathering Date and Time</h3>
                <label for="date">Date:</label>
                <input type="date" name="date" value="<?= $gathering['gathering_date'] ?>" required>

                <label for="time">Time:</label>
                <input type="time" name="time" value="<?= $gathering['gathering_time'] ?>" required>

                <button type="submit">Submit Attendance</button>
            </form>
        <?php else: ?>
            <p>Error: Gathering details not found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
