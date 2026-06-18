<?php
require_once 'includes/session.php';
require_once 'config/db.php';
require_once 'includes/functions.php';
set_base_depth(0);

if (is_logged_in()) redirect('index.php');

$error = '';
$old   = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old  = $_POST;
    $name = trim($_POST['full_name'] ?? '');
    $email= trim($_POST['email'] ?? '');
    $pass = $_POST['password'] ?? '';
    $pass2= $_POST['password2'] ?? '';
    $role = $_POST['role'] ?? 'customer';
    $phone= trim($_POST['phone'] ?? '');

    if (!in_array($role, ['customer','seller'], true)) $role = 'customer';

    if ($name==='' || $email==='' || $pass==='') {
        $error = 'Name, email and password are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif (strlen($pass) < 6) {
        $error = 'Password must be at least 6 characters.';
    } elseif ($pass !== $pass2) {
        $error = 'Passwords do not match.';
    } else {
        // Check duplicate email
        $chk = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $chk->execute([$email]);
        if ($chk->fetch()) {
            $error = 'That email address is already registered.';
        } else {
            $hash = password_hash($pass, PASSWORD_BCRYPT);
            $ins  = $pdo->prepare("INSERT INTO users (full_name, email, password, role, phone) VALUES (?,?,?,?,?)");
            $ins->execute([$name, $email, $hash, $role, $phone ?: null]);

            if ($role === 'seller') {
                $uid = $pdo->lastInsertId();
                $pdo->prepare("INSERT INTO seller_profiles (user_id) VALUES (?)")->execute([$uid]);
            }

            set_flash('success', 'Account created! Please log in.');
            redirect('login.php');
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>AccessTech – Register</title>
  <link rel="stylesheet" href="assets/style.css"/>
  <link href="https://fonts.googleapis.com/css2?family=IM+Fell+English:ital@0;1&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>
</head>
<body>
<?php require 'includes/navbar.php'; ?>

<section class="section" style="min-height:80vh; display:flex; align-items:center; justify-content:center; padding-top:40px;">
  <div class="form-card" style="width:100%; max-width:480px;">
    <h2>Create Account</h2>
    <p class="form-sub">Join AccessTech as a Customer or Seller</p>

    <?php if ($error): ?>
      <div class="flash error"><?= e($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="register.php">
      <div class="form-group">
        <label>Full Name</label>
        <input name="full_name" type="text" class="form-input" placeholder="John Doe" value="<?= e($old['full_name'] ?? '') ?>" required/>
      </div>
      <div class="form-group">
        <label>Email Address</label>
        <input name="email" type="email" class="form-input" placeholder="you@example.com" value="<?= e($old['email'] ?? '') ?>" required/>
      </div>
      <div class="form-group">
        <label>Phone (optional)</label>
        <input name="phone" type="text" class="form-input" placeholder="07xxxxxxxx" value="<?= e($old['phone'] ?? '') ?>"/>
      </div>
      <div class="form-group">
        <label>I am registering as a</label>
        <select name="role" class="form-input">
          <option value="customer" <?= (($old['role']??'customer')==='customer')?'selected':'' ?>>Customer</option>
          <option value="seller"   <?= (($old['role']??'')==='seller')?'selected':'' ?>>Seller</option>
        </select>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label>Password</label>
          <input name="password" type="password" class="form-input" placeholder="Min 6 chars" required/>
        </div>
        <div class="form-group">
          <label>Confirm Password</label>
          <input name="password2" type="password" class="form-input" placeholder="Repeat password" required/>
        </div>
      </div>
      <button type="submit" class="btn-submit btn-full" style="margin-top:8px;">Create Account</button>
    </form>

    <p class="form-footer-link">Already have an account? <a href="login.php">Log in</a></p>
  </div>
</section>

<footer class="site-footer">&copy; <?= date('Y') ?> AccessTech. All rights reserved.</footer>
</body>
</html>