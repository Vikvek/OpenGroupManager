<?php
require 'vital/secure.php'; //Includes database connection and session login

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['create_club'])) {
        // Create a new club
        $club_name = $_POST['club_name'];

        try {
            $stmt = $pdo->prepare("INSERT INTO clubs (name) VALUES (?)");
            $stmt->execute([$club_name]);
        } catch (PDOException $e) {
            die("Error creating club: " . $e->getMessage());
        }
    } elseif (isset($_POST['attach_person'])) {
        // Attach a person to a club
        $person_name = $_POST['person_name'];
        $club_id = $_POST['club_id'];

        try {
            $stmt = $pdo->prepare("INSERT INTO club_members (club_id, name) VALUES (?, ?)");
            $stmt->execute([$club_id, $person_name]);
        } catch (PDOException $e) {
            die("Error attaching person to club: " . $e->getMessage());
        }
    }
}

header('Location: index.php');
