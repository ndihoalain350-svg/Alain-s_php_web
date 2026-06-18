<?php
function redirect(string $url): void {
    header("Location: $url");
    exit;
}

function e(?string $value): string {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function set_flash(string $type, string $message): void {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function get_flash(): ?array {
    if (!empty($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

function current_user(): ?array {
    return $_SESSION['user'] ?? null;
}

function is_logged_in(): bool {
    return isset($_SESSION['user']);
}

function require_login(): void {
    if (!is_logged_in()) {
        set_flash('error', 'Please log in to continue.');
        redirect(site_url('login.php'));
    }
}

function require_role(array $roles): void {
    require_login();
    $user = current_user();
    if (!in_array($user['role'], $roles, true)) {
        set_flash('error', 'You do not have permission to view that page.');
        redirect(site_url('index.php'));
    }
}

function set_base_depth(int $depth): void {
    $GLOBALS['__base_depth'] = $depth;
}

function site_url(string $path = ''): string {
    $depth = $GLOBALS['__base_depth'] ?? 0;
    $prefix = str_repeat('../', $depth);
    return $prefix . $path;
}

function handle_upload(string $fieldName, string $destDir, string $publicPrefix, array $allowedExt, int $maxBytes): array {
    if (empty($_FILES[$fieldName]) || $_FILES[$fieldName]['error'] === UPLOAD_ERR_NO_FILE) {
        return ['ok' => false, 'path' => null, 'name' => null, 'error' => null];
    }
    $file = $_FILES[$fieldName];
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['ok' => false, 'path' => null, 'name' => null, 'error' => 'Upload failed (error code ' . $file['error'] . ').'];
    }
    if ($file['size'] > $maxBytes) {
        return ['ok' => false, 'path' => null, 'name' => null, 'error' => 'File is too large.'];
    }
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowedExt, true)) {
        return ['ok' => false, 'path' => null, 'name' => null, 'error' => 'File type .' . $ext . ' is not allowed.'];
    }
    if (!is_dir($destDir)) {
        mkdir($destDir, 0775, true);
    }
    $safeName = uniqid('f_', true) . '.' . $ext;
    $destPath = $destDir . '/' . $safeName;
    if (!move_uploaded_file($file['tmp_name'], $destPath)) {
        return ['ok' => false, 'path' => null, 'name' => null, 'error' => 'Could not save the uploaded file.'];
    }
    return ['ok' => true, 'path' => $publicPrefix . '/' . $safeName, 'name' => $file['name'], 'error' => null];
}

function format_money($amount): string {
    return number_format((float)$amount, 0) . ' frw';
}

function star_rating(int $rating): string {
    $rating = max(0, min(5, $rating));
    return str_repeat('★', $rating) . str_repeat('☆', 5 - $rating);
}