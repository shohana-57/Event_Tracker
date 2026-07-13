<?php

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

// Next 5 upcoming events, soonest first
$nextStmt = $pdo->prepare(
    'SELECT id, title, event_date, location
     FROM events
     WHERE user_id = ? AND event_date >= CURDATE()
     ORDER BY event_date ASC
     LIMIT 5'
);
$nextStmt->execute([$userId]);
$upcomingEvents = $nextStmt->fetchAll();

// 5 most recently added events
$recentStmt = $pdo->prepare(
    'SELECT id, title, event_date, created_at
     FROM events
     WHERE user_id = ?
     ORDER BY created_at DESC
     LIMIT 5'
);
$recentStmt->execute([$userId]);
$recentlyAdded = $recentStmt->fetchAll();

require_once __DIR__ . '/includes/header.php';
?>