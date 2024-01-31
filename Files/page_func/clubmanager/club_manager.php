
<?php
require_once __DIR__ . '/../../vital/secure.php'; //Includes database connection and session login
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Club Management</title>
    <link rel="stylesheet" href="https://mannemarket.fi/onlinecss.css">
</head>
<body>
						<?php
						include "../../elements/menu.php";
						?>
    <div class="container">
        <h1>Club Management</h1>

        <!-- Form to create a new club -->
        <form action="process.php" method="post">
            <label for="club_name">Club Name:</label>
            <input type="text" name="club_name" required>
            <button type="submit" name="create_club">Create Club</button>
        </form>

        <h2>Clubs</h2>
        <ul>
            <?php include 'list_clubs.php'; ?>
        </ul>

        <!-- Form to attach a person to a club -->
        <h2>Attach Person to Club</h2>
        <form action="process.php" method="post">
            <label for="person_name">Person Name:</label>
            <input type="text" name="person_name" required>

            <label for="club_id">Select Club:</label>
            <select name="club_id" required>
                <?php include 'dropdown_clubs.php'; ?>
            </select>

            <button type="submit" name="attach_person">Attach Person</button>
        </form>

        <!-- Display club members -->
        <h2>Club Members</h2>
        <ul>
            <?php include 'list_members.php'; ?>
        </ul>
    </div>
</body>
</html>
