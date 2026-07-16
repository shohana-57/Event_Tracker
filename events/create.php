<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../config/db.php';

$userId = $_SESSION['user_id'];

$errors = [];
$title = '';
$eventDate = '';
$location = '';
$description = '';

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
            $stmt = $pdo->prepare(
                'INSERT INTO events (user_id, title, event_date, location, description, created_at)
                 VALUES (?, ?, ?, ?, ?, NOW())'
            );
            $stmt->execute([$userId, $title, $eventDate, $location ?: null, $description ?: null]);
        }
    }
}
?>

<form method="POST" action="create.php" id="event-form" novalidate>
    <div class="form-group">
        <label for="title">Title *</label>
        <input type="text" id="title" name="title" maxlength="150"
               required autofocus>
    </div>

    <div class="form-group">
        <label for="event_date">Date *</label>
        <input type="date" id="event_date" name="event_date"
               required>
    </div>

    <div class="form-group">
        <label for="location">Location</label>
        <input type="text" id="location" name="location" maxlength="150">
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <textarea id="description" name="description" rows="4"></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Save Event</button>
    <a href="list.php" class="btn btn-secondary">Cancel</a>
</form>
