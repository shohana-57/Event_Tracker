<?php
// Dashboard page
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<main class="dashboard">
   <div class="dashboard-header">
    <div>
        <h1>Dashboard</h1>
        <p>Welcome back, User.</p>
    </div>
   </div>
    <section class="dashboard-stats">
     <div class="stat-card">
        <span class="stat-number">0</span>
        <span class="stat-label">Total Events</span>
     </div>

     <div class="stat-card">
        <span class="stat-number">0</span>
        <span class="stat-label">Upcoming</span>
     </div>

     <div class="stat-card">
        <span class="stat-number">0</span>
        <span class="stat-label">Past</span>
     </div>
    </section>
    <section class="dashboard-section">
     <h2>Next Up</h2>

     <ul class="event-summary-list">
       <li>No upcoming events.</li>
     </ul>
    </section>
    <section class="dashboard-section">
    <h2>Recently Added</h2>

    <ul class="event-summary-list">
      <li>You haven't added any events yet.</li>
    </ul>
</section>
<div class="dashboard-actions">
    <a href="#" class="btn btn-secondary">View All Events</a>
    <a href="#" class="btn btn-primary">+ New Event</a>
</div>
</main>

</body>
</html>