<?php
// Admin session + helpers shared by the admin pages
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params(['httponly' => true, 'samesite' => 'Lax']);
    session_start();
}
if (empty($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(16));
}

function require_admin() {
    if (empty($_SESSION['admin'])) {
        header('Location: login.php');
        exit;
    }
}

function check_csrf($token) {
    if (!is_string($token) || !hash_equals($_SESSION['csrf'], $token)) {
        http_response_code(400);
        die('Invalid request.');
    }
}

function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

// Accept only real JPG/PNG images up to 5 MB, saved under a random name
function save_uploaded_image($file) {
    if (empty($file) || ($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) return null;
    if ($file['size'] > 5 * 1024 * 1024) return null;
    $info = @getimagesize($file['tmp_name']);
    $types = [IMAGETYPE_JPEG => 'jpg', IMAGETYPE_PNG => 'png'];
    if (!$info || !isset($types[$info[2]])) return null;
    $name = bin2hex(random_bytes(8)) . '.' . $types[$info[2]];
    if (!move_uploaded_file($file['tmp_name'], __DIR__ . '/uploaded_img/' . $name)) return null;
    return $name;
}
