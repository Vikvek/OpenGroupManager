
<?php
require 'vital/secure.php'; //Includes database connection and session login
?>
<!DOCTYPE html>
<html lang="en">
	<?php
		include "elements/head.php";
	?>
<body>
						<?php
						include "elements/menu.php";
						?>
    <div class="container">
        <h1>Main menu</h1>

        <!-- Form to create a new club -->

        <h2>Current active clubs</h2>
        <ul>
            <?php include 'page_func/clubmanager/list_clubs.php'; ?>
        </ul>

        <!-- Form to attach a person to a club -->
        <h2>Attach Person to Club</h2>

        <!-- Display club members -->
        <h2>Versio</h2>
        <ul>
            <a>Versio 0.01</a>
        </ul>
    </div>
	
</body>

</html>
