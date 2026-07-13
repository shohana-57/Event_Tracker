<?php
// includes/footer.php
// Shared footer, included at the end of dashboard.php and events/*.php
// Usage: require_once __DIR__ . '/../includes/footer.php';  (adjust '../' to match depth)

if (!defined('BASE_URL')) {
    define('BASE_URL', '/Event_Tracker');
}
?>

</main>

<footer class="site-footer">
    <p>&copy; <?php echo date('Y'); ?> Even Tracker &mdash; a practice project for learning SCRUM.</p>
</footer>

<script src="<?php echo BASE_URL; ?>/assets/js/validate.js"></script>
<script src="<?php echo BASE_URL; ?>/assets/js/confirm-delete.js"></script>
</body>
</html>