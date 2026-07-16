<?php
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
?>

<form method="POST" action="create.php" id="event-form" novalidate>
    <div class="form-group">
        <label for="title">Title *</label>
        <input type="text" id="title" name="title" maxlength="150"
               value="<?php echo htmlspecialchars($title); ?>" required autofocus>
    </div>

    <div class="form-group">
        <label for="event_date">Date *</label>
        <input type="date" id="event_date" name="event_date"
               value="<?php echo htmlspecialchars($eventDate); ?>" required>
    </div>
        <div class="form-group">
        <label for="location">Location</label>
        <input type="text" id="location" name="location" maxlength="150"
               value="<?php echo htmlspecialchars($location); ?>">
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <textarea id="description" name="description" rows="4"><?php echo htmlspecialchars($description); ?></textarea>
    </div>