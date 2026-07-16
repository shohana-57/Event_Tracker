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