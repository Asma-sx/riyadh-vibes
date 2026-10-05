<?php
require 'auth.php';
include 'connection.php';

if (isset($_POST['submit'])) {
    $username = trim($_POST['user'] ?? '');
    $password = $_POST['pass'] ?? '';

    $stmt = $conn->prepare('SELECT id, password FROM log WHERE username = ?');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();

    if ($row && password_verify($password, $row['password'])) {
        session_regenerate_id(true);
        $_SESSION['admin'] = $row['id'];
        header('Location: ad.php');
        exit;
    }
}

header('Location: login.php?error=1');
exit;
