<?php
require_once 'includes/session.php';
require_once 'config/db.php';
require_once 'includes/functions.php';
set_base_depth(0);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['full_name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name && $email && $message && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $pdo->prepare("INSERT INTO contact_messages (full_name, email, message) VALUES (?,?,?)")
            ->execute([$name, $email, $message]);
        set_flash('success', 'Thank you! Your message has been sent. We\'ll get back to you within 24 hours.');
    } else {
        set_flash('error', 'Please fill in all fields with a valid email.');
    }
}

// Return to wherever they came from (about or support)
$ref = $_SERVER['HTTP_REFERER'] ?? 'support.php';
redirect($ref);