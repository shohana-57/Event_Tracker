<?php

session_start();
require_once __DIR__ . '/../config/db.php'; 

// If already logged in, skip straight to dashboard
if (!empty($_SESSION['user_id'])) {
    header('Location: ../dashboard.php');
    exit;
}

$errors = [];
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $errors[] = 'Please enter both email and password.';
    }

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare('SELECT id, name, email, password_hash FROM users WHERE email = ? LIMIT 1');
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password_hash'])) {
                // Prevent session fixation
                session_regenerate_id(true);

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];

                header('Location: ../dashboard.php');
                exit;
            } else {
                $errors[] = 'Invalid email or password.';
            }
        } catch (PDOException $e) {
            // Showing error details
            $errors[] = 'Something went wrong. Please try again later.';
            error_log('Login error: ' . $e->getMessage());
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Even Tracker</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <div class="auth-container">
        <h1>Even Tracker</h1>
        <h2>Login</h2>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="login.php" novalidate>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email"
                       value="<?php echo htmlspecialchars($email); ?>" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" class="btn btn-primary">Log In</button>
        </form>

        <p class="auth-switch">
            Don't have an account? <a href="register.php">Register here</a>
        </p>
    </div>

    <script src="../assets/js/validate.js"></script>
</body>
</html>