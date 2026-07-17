<?php
$configPath = __DIR__ . '/../config.php';
$config = file_exists($configPath) ? require $configPath : [];

$dbHost    = $config['db_host']    ?? '127.0.0.1';
$dbPort    = $config['db_port']    ?? '3306';
$dbName    = $config['db_name']    ?? 'even_tracker';
$dbUser    = $config['db_user']    ?? 'root';
$dbPass    = $config['db_pass']    ?? '';
$dbCharset = $config['db_charset'] ?? 'utf8mb4';

$dsn = "mysql:host={$dbHost};port={$dbPort};dbname={$dbName};charset={$dbCharset}";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,   
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,          
    PDO::ATTR_EMULATE_PREPARES   => false,                     
];

try {
    $pdo = new PDO($dsn, $dbUser, $dbPass, $options);
} catch (PDOException $e) {
    error_log('Database connection failed: ' . $e->getMessage());
    die('Something went wrong connecting to the database. Please try again later.');
}