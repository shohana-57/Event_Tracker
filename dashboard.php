<?php

require_once __DIR__ . '/includes/auth_check.php'; // must run before any output
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/auth_check.php'; 
require_once __DIR__ . '/config/db.php';

$userId = $_SESSION['user_id'];

// Total events
$totalStmt = $pdo->prepare('SELECT COUNT(*) FROM events WHERE user_id = ?');
$totalStmt->execute([$userId]);
$totalEvents = (int) $totalStmt->fetchColumn();

// Upcoming events (today or later)
$upcomingStmt = $pdo->prepare('SELECT COUNT(*) FROM events WHERE user_id = ? AND event_date >= CURDATE()');
$upcomingStmt->execute([$userId]);
$upcomingCount = (int) $upcomingStmt->fetchColumn();

// Past events
$pastCount = $totalEvents - $upcomingCount;

// Next 6 upcoming events, soonest first
$nextStmt = $pdo->prepare(
    'SELECT id, title, event_date, location
     FROM events
     WHERE user_id = ? AND event_date >= CURDATE()
     ORDER BY event_date ASC
     LIMIT 6'
);
$nextStmt->execute([$userId]);
$upcomingEvents = $nextStmt->fetchAll();

// 6 most recently added events listing
$recentStmt = $pdo->prepare(
    'SELECT id, title, event_date, created_at
     FROM events
     WHERE user_id = ?
     ORDER BY created_at DESC
     LIMIT 6'
);
$recentStmt->execute([$userId]);
$recentlyAdded = $recentStmt->fetchAll();

require_once __DIR__ . '/includes/header.php';
?>
// Dashboard page
?>


<h1>Dashboard</h1>
<p>Welcome back, <?php echo htmlspecialchars($_SESSION['user_name']); ?>.</p>

<section class="dashboard-stats">
    <div class="stat-card">
        <span class="stat-number"><?php echo $totalEvents; ?></span>
        <span class="stat-label">Total Events</span>
    </div>
    <div class="stat-card">
        <span class="stat-number"><?php echo $upcomingCount; ?></span>
        <span class="stat-label">Upcoming</span>
    </div>
    <div class="stat-card">
        <span class="stat-number"><?php echo $pastCount; ?></span>
        <span class="stat-label">Past</span>
    </div>
</section>

<section class="dashboard-section">
    <h2>Next Up</h2>
    <?php if (empty($upcomingEvents)): ?>
        <p class="empty-state">No upcoming events. <a href="events/create.php">Create one</a>.</p>
    <?php else: ?>
        <ul class="event-summary-list">
            <?php foreach ($upcomingEvents as $event): ?>
                <li>
                    <a href="events/view.php?id=<?php echo (int) $event['id']; ?>">
                        <?php echo htmlspecialchars($event['title']); ?>
                    </a>
                    <span class="event-meta">
                        <?php echo date('d M Y', strtotime($event['event_date'])); ?>
                        <?php if (!empty($event['location'])): ?>
                            &middot; <?php echo htmlspecialchars($event['location']); ?>
                        <?php endif; ?>
                    </span>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</section>

<section class="dashboard-section">
    <h2>Recently Added</h2>
    <?php if (empty($recentlyAdded)): ?>
        <p class="empty-state">You haven't added any events yet.</p>
    <?php else: ?>
        <ul class="event-summary-list">
            <?php foreach ($recentlyAdded as $event): ?>
                <li>
                    <a href="events/view.php?id=<?php echo (int) $event['id']; ?>">
                        <?php echo htmlspecialchars($event['title']); ?>
                    </a>
                    <span class="event-meta">
                        <?php echo date('d M Y', strtotime($event['event_date'])); ?>
                    </span>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</section>


<a href="events/list.php" class="btn btn-secondary">View All Events</a>
<a href="events/create.php" class="btn btn-primary">+ New Event</a>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
