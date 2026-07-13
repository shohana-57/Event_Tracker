<?php
// includes/header.php
// Shared header + navigation bar, included on dashboard.php and events/*.php
// Usage: require_once __DIR__ . '/../includes/header.php';  (adjust '../' to match depth)

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Base path of the project under your web root.
// e.g. if the project lives at http://localhost/Event_Tracker/, keep it as below.
// If it lives at the domain root (http://localhost/), set this to ''.
if (!defined('BASE_URL')) {
    define('BASE_URL', '/Event_Tracker');
}

$isLoggedIn = !empty($_SESSION['user_id']);
$currentUserName = $_SESSION['user_name'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Even Tracker</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/style.css">
</head>
<body>

<header class="site-header">
    <div class="nav-container">
        <a href="<?php echo BASE_URL; ?>/dashboard.php" class="site-logo">Event Tracker</a>

        <nav class="site-nav">
            <?php if ($isLoggedIn): ?>
                <a href="<?php echo BASE_URL; ?>/dashboard.php">Dashboard</a>
                <a href="<?php echo BASE_URL; ?>/events/list.php">Events</a>
                <a href="<?php echo BASE_URL; ?>/events/create.php">+ New Event</a>
                <span class="nav-user">Hi, <?php echo htmlspecialchars($currentUserName); ?></span>
                <a href="<?php echo BASE_URL; ?>/auth/logout.php" class="nav-logout">Logout</a>
            <?php else: ?>
                <a href="<?php echo BASE_URL; ?>/auth/login.php">Login</a>
                <a href="<?php echo BASE_URL; ?>/auth/registration.php">Register</a>
            <?php endif; ?>
        </nav>
    </div>
</header>

<main class="site-main">