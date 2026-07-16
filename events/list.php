<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../config/db.php';
$userId = $_SESSION['user_id'];

$stmt = $pdo->prepare(
    'SELECT id, title, event_date, location
     FROM events
     WHERE user_id = ?
     ORDER BY event_date ASC'
);
$stmt->execute([$userId]);
$events = $stmt->fetchAll();

$justCreated = isset($_GET['created']);
$justUpdated = isset($_GET['updated']);
$justDeleted = isset($_GET['deleted']);
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/footer.php';
?>