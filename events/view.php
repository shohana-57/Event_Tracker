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

<div class="page-header-row">
    <h1><?php echo htmlspecialchars($event['title']); ?></h1>
    <div class="actions-cell">
        <a href="edit.php?id=<?php echo (int) $event['id']; ?>" class="btn btn-secondary">Edit</a>
        <form method="POST" action="delete.php" class="inline-form"
              data-confirm="Delete '<?php echo htmlspecialchars($event['title'], ENT_QUOTES); ?>'? This cannot be undone.">
            <input type="hidden" name="id" value="<?php echo (int) $event['id']; ?>">
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    </div>
</div>

<dl class="event-details">
    <dt>Date</dt>
    <dd><?php echo date('l, d F Y', strtotime($event['event_date'])); ?></dd>

    <dt>Location</dt>
    <dd><?php echo htmlspecialchars($event['location'] ?: 'Not specified'); ?></dd>

    <dt>Description</dt>
    <dd><?php echo nl2br(htmlspecialchars($event['description'] ?: 'No description provided.')); ?></dd>

    <dt>Created</dt>
    <dd><?php echo date('d M Y, g:i A', strtotime($event['created_at'])); ?></dd>

    <?php if ($event['updated_at'] !== $event['created_at']): ?>
        <dt>Last Updated</dt>
        <dd><?php echo date('d M Y, g:i A', strtotime($event['updated_at'])); ?></dd>
    <?php endif; ?>
</dl>

<a href="list.php" class="btn btn-secondary">&larr; Back to My Events</a>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>