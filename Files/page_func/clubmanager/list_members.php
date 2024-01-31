<?php
require_once __DIR__ . '/../../vital/secure.php'; //Includes database connection and session login

$stmt = $pdo->query("SELECT * FROM club_members");
$members = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($members as $member) {
    echo "<li>{$member['customer_name']} (Club ID: {$member['club_id']})</li>";
}
?>
