<?php

require_once __DIR__ . '/../includes/auth_check.php'; 
require_once __DIR__ . '/../config/db.php';

$userId = $_SESSION['user_id'];
$eventId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ?: filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

if (!$eventId) {
    header('Location: list.php');
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM events WHERE id = ? AND user_id = ? LIMIT 1');
$stmt->execute([$eventId, $userId]);
$event = $stmt->fetch();

if (!$event) {
    header('Location: list.php?notfound=1');
    exit;
}

$errors = [];
$title = $event['title'];
$eventDate = $event['event_date'];
$location = $event['location'];
$description = $event['description'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $eventDate = trim($_POST['event_date'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $description = trim($_POST['description'] ?? '');

    // Validation
    if ($title === '') {
        $errors[] = 'Title is required.';
    } elseif (strlen($title) > 150) {
        $errors[] = 'Title must be 150 characters or fewer.';
    }

    if ($eventDate === '') {
        $errors[] = 'Event date is required.';
    } else {
        $dateObj = DateTime::createFromFormat('Y-m-d', $eventDate);
        if (!$dateObj || $dateObj->format('Y-m-d') !== $eventDate) {
            $errors[] = 'Event date must be a valid date (YYYY-MM-DD).';
        }
    }

    if (empty($errors)) {
        try {
            $updateStmt = $pdo->prepare(
                'UPDATE events
                 SET title = ?, event_date = ?, location = ?, description = ?
                 WHERE id = ? AND user_id = ?'
            );
            $updateStmt->execute([
                $title,
                $eventDate,
                $location ?: null,
                $description ?: null,
                $eventId,
                $userId,
            ]);

            header('Location: list.php?updated=1');
            exit;
        } catch (PDOException $e) {
            $errors[] = 'Could not update the event. Please try again later.';
            error_log('Event update error: ' . $e->getMessage());
        }
    }
}

require_once __DIR__ . '/../includes/header.php';
?>
<h1>Edit Event</h1>

<?php if (!empty($errors)): ?>
    <div class="alert alert-error">
        <?php foreach ($errors as $error): ?>
            <p><?php echo htmlspecialchars($error); ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
