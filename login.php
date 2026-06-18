<?php
require_once 'includes/session.php';
require_once 'config/db.php';
require_once 'includes/functions.php';
set_base_depth(0);

// Already logged in → go to correct dashboard
if (is_logged_in()) {
    $r = current_user()['role'];
    redirect($r === 'admin' ? 'admin/dashboard.php' : ($r === 'seller' ? 'seller/dashboard.php' : 'customer/my-orders.php'));
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $error = 'Please fill in both fields.';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND status = 'active'");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = [
                'id'        => $user['id'],
                'full_name' => $user['full_name'],
                'email'     => $user['email'],
                'role'      => $user['role'],
            ];
            set_flash('success', 'Welcome back, ' . $user['full_name'] . '!');
            if ($user['role'] === 'admin')        redirect('admin/dashboard.php');
            elseif ($user['role'] === 'seller')   redirect('seller/dashboard.php');
            else                                   redirect('customer/my-orders.php');
        } else {
            $error = 'Invalid email or password, or your account is suspended.';
        }
    }
}
$flash = get_flash();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>AccessTech – Login</title>
  <link rel="stylesheet" href="assets/style.css"/>
  <link href="https://fonts.googleapis.com/css2?family=IM+Fell+English:ital@0;1&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>
</head>
<body>
<?php require 'includes/navbar.php'; ?>

<section class="section" style="min-height:80vh; display:flex; align-items:center; justify-content:center;">
  <div class="form-card" style="width:100%; max-width:440px;">
    <h2>Welcome Back</h2>
    <p class="form-sub">Log in to your AccessTech account</p>

    <?php if ($flash): ?>
      <div class="flash <?= e($flash['type']) ?>"><?= e($flash['message']) ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
      <div class="flash error"><?= e($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="login.php">
      <div class="form-group">
        <label for="email">Email Address</label>
        <input id="email" name="email" type="email" class="form-input" placeholder="you@example.com" value="<?= e($_POST['email'] ?? '') ?>" required/>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input id="password" name="password" type="password" class="form-input" placeholder="••••••••" required/>
      </div>
      <button type="submit" class="btn-submit btn-full" style="margin-top:8px;">Log In</button>
    </form>

    <p class="form-footer-link">Don't have an account? <a href="register.php">Register here</a></p>
  </div>
</section>

<footer class="site-footer">
  &copy; <?= date('Y') ?> AccessTech. All rights reserved.
</footer>
</body>
</html>