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