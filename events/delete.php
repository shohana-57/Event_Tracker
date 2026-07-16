<?php

require_once __DIR__ . '/../includes/auth_check.php'; // must run before any output
require_once __DIR__ . '/../config/db.php';

$userId = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}

$eventId = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

if (!$eventId) {
    header('Location: list.php?error=invalid_id');
    exit;
}

try {
    $stmt = $pdo->prepare('DELETE FROM events WHERE id = ? AND user_id = ?');
    $stmt->execute([$eventId, $userId]);

    if ($stmt->rowCount() > 0) {
        header('Location: list.php?deleted=1');
    } else {
        header('Location: list.php?notfound=1');
    }
    exit;
} catch (PDOException $e) {
    error_log('Event delete error: ' . $e->getMessage());
    header('Location: list.php?error=delete_failed');
    exit;
}