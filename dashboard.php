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
            <span class="stat-number">12</span>
            <span class="stat-label">Total Events</span>
        </div>

        <div class="stat-card">
            <span class="stat-number">5</span>
            <span class="stat-label">Upcoming</span>
        </div>

        <div class="stat-card">
            <span class="stat-number">7</span>
            <span class="stat-label">Past</span>
        </div>

    </section>

    <section class="dashboard-section">
        <h2>Next Up</h2>

        <ul class="event-summary-list">
            <li>
                <strong>Department Meeting</strong><br>
                <small>15 Jul 2026 • Conference Room</small>
            </li>

            <li>
                <strong>Project Presentation</strong><br>
                <small>18 Jul 2026 • Lab 402</small>
            </li>
        </ul>
    </section>

    <section class="dashboard-section">
        <h2>Recently Added</h2>

        <ul class="event-summary-list">
            <li>
                <strong>Hackathon Registration</strong><br>
                <small>10 Jul 2026</small>
            </li>

            <li>
                <strong>Club Orientation</strong><br>
                <small>08 Jul 2026</small>
            </li>
        </ul>
    </section>

    <div class="dashboard-actions">
        <a href="#" class="btn btn-secondary">View All Events</a>
        <a href="#" class="btn btn-primary">+ New Event</a>
    </div>

</main>

</body>
</html>