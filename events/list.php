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
?>

<div class="page-header-row">
    <h1>My Events</h1>
    <a href="create.php" class="btn btn-primary">+ New Event</a>
</div>

<?php if ($justCreated): ?>
    <div class="alert alert-success"><p>Event created successfully.</p></div>
<?php elseif ($justUpdated): ?>
    <div class="alert alert-success"><p>Event updated successfully.</p></div>
<?php elseif ($justDeleted): ?>
    <div class="alert alert-success"><p>Event deleted.</p></div>
<?php endif; ?>

<form method="GET" action="search.php" class="search-bar">
    <label for="search_date" class="sr-only">Filter by date</label>
    <input type="date" id="search_date" name="date">
    <button type="submit" class="btn btn-secondary">Search by Date</button>
</form>

<?php if (empty($events)): ?>
    <p class="empty-state">You don't have any events yet. <a href="create.php">Create your first one</a>.</p>
<?php else: ?>
    <table class="events-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Date</th>
                <th>Location</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($events as $event): ?>
                <tr>
                    <td>
                        <a href="view.php?id=<?php echo (int) $event['id']; ?>">
                            <?php echo htmlspecialchars($event['title']); ?>
                        </a>
                    </td>
                    <td><?php echo date('d M Y', strtotime($event['event_date'])); ?></td>
                    <td><?php echo htmlspecialchars($event['location'] ?: '—'); ?></td>
                    <td class="actions-cell">
                        <a href="view.php?id=<?php echo (int) $event['id']; ?>">View</a>
                        <a href="edit.php?id=<?php echo (int) $event['id']; ?>">Edit</a>
                        <form method="POST" action="delete.php" class="inline-form"
                              data-confirm="Delete '<?php echo htmlspecialchars($event['title'], ENT_QUOTES); ?>'? This cannot be undone.">
                            <input type="hidden" name="id" value="<?php echo (int) $event['id']; ?>">
                            <button type="submit" class="link-button">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
<?php require_once __DIR__ . '/../includes/footer.php';?>
