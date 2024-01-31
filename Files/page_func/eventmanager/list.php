<?php
require 'vital/secure.php'; //Includes database connection and session login

// Initialize session variable if not exists
if (!isset($_SESSION['club_members'])) {
    $_SESSION['club_members'] = [
        'Shovel Club' => ['Janne', 'Sami'],
        'Excavator Club' => ['Santeri', 'Arto'],
        'Fun Club' => ['Valtteri', 'Nurmilaukas'],
    ];
}

// Display club members
foreach ($_SESSION['club_members'] as $job => $members) {
    echo "<li><strong>$job:</strong> " . implode(', ', $members) . "</li>";
}
?>
