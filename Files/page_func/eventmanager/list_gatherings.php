<?php
require 'vital/secure.php'; //Includes database connection and session login
// Fetch gatherings and display them
$stmt = $pdo->query("SELECT * FROM gatherings");
$gatherings = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($gatherings as $gathering) {
    echo "<li>";
    echo "<strong>Club:</strong> {$gathering['club_id']}, ";
    echo "<strong>Status:</strong> {$gathering['status']}, ";
    echo "<a href='attendance.php?gathering_id={$gathering['id']}'>Mark Attendance</a>";
    echo "</li>";
}
?>
