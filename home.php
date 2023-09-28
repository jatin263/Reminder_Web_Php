<?php
    session_start();
    echo '<h1>Welcome to the Reminder Application '.$_SESSION['name'].'</h1>
        <h2>Today is '.date("l jS \of F Y").'</h2>
        <ul>
            <li><a href="add.php">Set  Reminder</a></li>
            <li><a href="modify.php">Modify  Reminder</a></li>
            <li><a href="disable.php">Disable  Reminder</a></li>
            <li><a href="delete.php">Delete  Reminder</a></li>
            <li><a href="enable.php">Enable  Reminder</a></li>
            <li><a href="view.php">View Your Reminder</a></li>
        </ul>';


?>