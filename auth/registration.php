<?php
session_start();
require_once __DIR__ . '/../config/db.php'; 

if (!empty($_SESSION['user_id'])) {
    header('Location: ../dashboard.php');
    exit;
}

if ($name === '') {
    $errors[] = 'Name is required.';
}

if ($email === '') {
    $errors[] = 'Email is required.';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Please enter a valid email address.';
}

if ($password === '') {
    $errors[] = 'Password is required.';
} elseif (strlen($password) < 6) {
    $errors[] = 'Password must be at least 6 characters long.';
}

if ($password !== $confirmPassword) {
    $errors[] = 'Passwords do not match.';
}

if (empty($errors)) {
    try {
        $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            $errors[] = 'An account with this email already exists.';
        }
    } catch (PDOException $e) {
        $errors[] = 'Something went wrong. Please try again later.';
        error_log('Register lookup error: ' . $e->getMessage());
    }
}
if (empty($errors)) {
    try {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare(
            'INSERT INTO users (name, email, password_hash, created_at)
             VALUES (?, ?, ?, NOW())'
        );

        $stmt->execute([$name, $email, $passwordHash]);

        $userId = $pdo->lastInsertId();
        
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Even Tracker</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="auth-container">
        <h1>Even Tracker</h1>
        <h2>Create an Account</h2>

        <form>
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name"
                       value="name" required autofocus>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email"
                       value="email" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" minlength="6" required>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" minlength="6" required>
            </div>

            <button type="submit" class="btn btn-primary">Register</button>
        </form>

        <p class="auth-switch">
            Already have an account? <a href="login.php">Log in here</a>
        </p>
    </div>

</body>
</html>