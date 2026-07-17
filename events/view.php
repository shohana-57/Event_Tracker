<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../config/db.php';
$userId = $_SESSION['user_id'];
$eventId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$eventId) {
    header('Location: list.php');
    exit;
}

$stmt = $pdo->prepare(
    'SELECT id, title, event_date, location, description, created_at, updated_at
     FROM events
     WHERE id = ? AND user_id = ?
     LIMIT 1'
);
$stmt->execute([$eventId, $userId]);
$event = $stmt->fetch();
if (!$event) {
    header('Location: list.php?notfound=1');
    exit;
}

require_once __DIR__ . '/../includes/header.php';
?>



<?php require_once __DIR__ . '/../includes/footer.php'; ?>