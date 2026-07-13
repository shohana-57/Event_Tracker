<?php

require_once __DIR__ . '/includes/auth_check.php'; 
require_once __DIR__ . '/config/db.php';

$userId = $_SESSION['user_id'];

// Total events
$totalStmt = $pdo->prepare('SELECT COUNT(*) FROM events WHERE user_id = ?');
$totalStmt->execute([$userId]);
$totalEvents = (int) $totalStmt->fetchColumn();

// Upcoming events
$upcomingStmt = $pdo->prepare('SELECT COUNT(*) FROM events WHERE user_id = ? AND event_date >= CURDATE()');
$upcomingStmt->execute([$userId]);
$upcomingCount = (int) $upcomingStmt->fetchColumn();

// Past events
$pastCount = $totalEvents - $upcomingCount;