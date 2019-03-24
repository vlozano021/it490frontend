<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
}
?>

<h1>You are logged in</h1>

<a href="forums.php">Message Board</a>