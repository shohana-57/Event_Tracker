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