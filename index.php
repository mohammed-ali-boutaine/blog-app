<?php
require './db/conn.php';
require './functions/helpers.php';  // Include your helper functions

// Check if the user is authenticated
requireAuth();

// If authenticated, continue to display the page content
echo "Welcome to your dashboard!";
?>
<br>
<a href="./view/article_add.php">add article</a>
<br>

<a href="./view/article_show.php">Show article</a>
<br>

