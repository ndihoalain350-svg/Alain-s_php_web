<?php
$user = current_user();
$base = site_url();
?>
<header class="navbar">
  <a href="<?= $base ?>index.php" class="logo-block">
    <div class="logo-icon">
      <div class="at-badge">A↑</div>
      <div class="at-sub">ACCESS<br>TECH</div>
    </div>
    <span class="logo-text">Access<span>Tech</span></span>
  </a>

  <nav>
    <a href="<?= $base ?>index.php">Home</a>
    <a href="<?= $base ?>products.php">Products</a>
    <a href="<?= $base ?>about.php">About Us</a>
    <a href="<?= $base ?>support.php">Support</a>
    <a href="<?= $base ?>cart.php">Cart &amp; Checkout</a>
    <a href="<?= $base ?>community.php">Join Our Community</a>
    <?php if ($user): ?>
      <?php if ($user['role'] === 'admin'): ?>
        <a href="<?= $base ?>admin/dashboard.php">Admin Panel</a>
      <?php elseif ($user['role'] === 'seller'): ?>
        <a href="<?= $base ?>seller/dashboard.php">Seller Panel</a>
      <?php else: ?>
        <a href="<?= $base ?>customer/my-orders.php">My Orders</a>
      <?php endif; ?>
    <?php endif; ?>
  </nav>

  <div class="nav-right">
    <?php if ($user): ?>
      <span class="nav-user">Hi, <strong><?= e($user['full_name']) ?></strong></span>
      <a href="<?= $base ?>logout.php" class="btn-nav-outline">Log Out</a>
    <?php else: ?>
      <a href="<?= $base ?>login.php" class="btn-nav">Login</a>
      <a href="<?= $base ?>register.php" class="btn-nav-outline">Register</a>
    <?php endif; ?>
  </div>
</header>