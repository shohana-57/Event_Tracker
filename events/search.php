<?php
// events/search.php
// US-13: As a user, I want to search/filter events by date so I can find relevant events quickly

require_once __DIR__ . '/../includes/auth_check.php'; // must run before any output
require_once __DIR__ . '/../config/db.php';

$userId = $_SESSION['user_id'];

$searchDate = trim($_GET['date'] ?? '');
$events = [];
$dateError = '';

if ($searchDate !== '') {
    $dateObj = DateTime::createFromFormat('Y-m-d', $searchDate);
    if (!$dateObj || $dateObj->format('Y-m-d') !== $searchDate) {
        $dateError = 'Please enter a valid date.';
    } else {
        $stmt = $pdo->prepare(
            'SELECT id, title, event_date, location
             FROM events
             WHERE user_id = ? AND event_date = ?
             ORDER BY title ASC'
        );
        $stmt->execute([$userId, $searchDate]);
        $events = $stmt->fetchAll();
    }
}

require_once __DIR__ . '/../includes/header.php';
?>

<div class="page-header-row">
    <h1>Search Events</h1>
    <a href="create.php" class="btn btn-primary">+ New Event</a>
</div>

<form method="GET" action="search.php" class="search-bar">
    <label for="search_date" class="sr-only">Filter by date</label>
    <input type="date" id="search_date" name="date"
           value="<?php echo htmlspecialchars($searchDate); ?>">
    <button type="submit" class="btn btn-secondary">Search</button>
    <?php if ($searchDate !== ''): ?>
        <a href="search.php" class="btn-clear">Clear</a>
    <?php endif; ?>
</form>


<?php if ($dateError !== ''): ?>
    <div class="alert alert-error"><p><?php echo htmlspecialchars($dateError); ?></p></div>
<?php elseif ($searchDate === ''): ?>
    <p class="empty-state">Pick a date above to see events on that day.</p>
<?php elseif (empty($events)): ?>
    <p class="empty-state">
        No events found on <?php echo date('d M Y', strtotime($searchDate)); ?>.
        <a href="create.php?event_date=<?php echo urlencode($searchDate); ?>">Create one</a>.
    </p>
<?php else: ?>
    <p class="results-summary">
        <?php echo count($events); ?> event(s) on <?php echo date('d M Y', strtotime($searchDate)); ?>
    </p>
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
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<a href="list.php" class="btn btn-secondary">&larr; Back to All Events</a>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>