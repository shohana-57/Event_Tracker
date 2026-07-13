<?php

require_once __DIR__ . '/includes/auth_check.php'; // must run before any output
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/auth_check.php'; 
require_once __DIR__ . '/config/db.php';

$userId = $_SESSION['user_id'];

// Total events
$totalStmt = $pdo->prepare('SELECT COUNT(*) FROM events WHERE user_id = ?');
$totalStmt->execute([$userId]);
$totalEvents = (int) $totalStmt->fetchColumn();

// Upcoming events (today or later)
$upcomingStmt = $pdo->prepare('SELECT COUNT(*) FROM events WHERE user_id = ? AND event_date >= CURDATE()');
$upcomingStmt->execute([$userId]);
$upcomingCount = (int) $upcomingStmt->fetchColumn();

// Past events
$pastCount = $totalEvents - $upcomingCount;

// Next 6 upcoming events, soonest first
$nextStmt = $pdo->prepare(
    'SELECT id, title, event_date, location
     FROM events
     WHERE user_id = ? AND event_date >= CURDATE()
     ORDER BY event_date ASC
     LIMIT 6'
);
$nextStmt->execute([$userId]);
$upcomingEvents = $nextStmt->fetchAll();

// 6 most recently added events listing
$recentStmt = $pdo->prepare(
    'SELECT id, title, event_date, created_at
     FROM events
     WHERE user_id = ?
     ORDER BY created_at DESC
     LIMIT 6'
);
$recentStmt->execute([$userId]);
$recentlyAdded = $recentStmt->fetchAll();

require_once __DIR__ . '/includes/header.php';
?>
// Dashboard page
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<main class="dashboard">

    <div class="dashboard-header">
        <div>
            <h1>Dashboard</h1>
            <p>Welcome back, User.</p>
        </div>
    </div>

    <section class="dashboard-stats">

        <div class="stat-card">
            <span class="stat-number">12</span>
            <span class="stat-label">Total Events</span>
        </div>

        <div class="stat-card">
            <span class="stat-number">5</span>
            <span class="stat-label">Upcoming</span>
        </div>

        <div class="stat-card">
            <span class="stat-number">7</span>
            <span class="stat-label">Past</span>
        </div>

    </section>

    <section class="dashboard-section">
        <h2>Next Up</h2>

        <ul class="event-summary-list">
            <li>
                <strong>Department Meeting</strong><br>
                <small>15 Jul 2026 • Conference Room</small>
            </li>

            <li>
                <strong>Project Presentation</strong><br>
                <small>18 Jul 2026 • Lab 402</small>
            </li>
        </ul>
    </section>

    <section class="dashboard-section">
        <h2>Recently Added</h2>

        <ul class="event-summary-list">
            <li>
                <strong>Hackathon Registration</strong><br>
                <small>10 Jul 2026</small>
            </li>

            <li>
                <strong>Club Orientation</strong><br>
                <small>08 Jul 2026</small>
            </li>
        </ul>
    </section>

    <div class="dashboard-actions">
        <a href="#" class="btn btn-secondary">View All Events</a>
        <a href="#" class="btn btn-primary">+ New Event</a>
    </div>

</main>

</body>
</html>
