<?php
$cfg = include __DIR__ . '/config.php';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    $conn = new mysqli($cfg['host'], $cfg['user'], $cfg['pass'], $cfg['dbname']);
    $conn->set_charset('utf8mb4');
} catch (mysqli_sql_exception $e) {
    error_log($e->getMessage());
    http_response_code(500);
    die('Database connection failed.');
}
