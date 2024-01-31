<?php
require_once __DIR__ . '/../../vital/secure.php'; //Includes database connection and session login

$stmt = $pdo->query("SELECT * FROM clubs");
$clubs = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($clubs as $club) {
    echo "<li>{$club['name']}</li>";
}
?>
