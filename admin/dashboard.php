<?php
require_once '../includes/session.php';
require_once '../config/db.php';
require_once '../includes/functions.php';
set_base_depth(1);
require_role(['admin']);

// Stats
$stats = [];
$stats['users']    = $pdo->query("SELECT COUNT(*) FROM users WHERE role != 'admin'")->fetchColumn();
$stats['sellers']  = $pdo->query("SELECT COUNT(*) FROM users WHERE role='seller'")->fetchColumn();
$stats['customers']= $pdo->query("SELECT COUNT(*) FROM users WHERE role='customer'")->fetchColumn();
$stats['products'] = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
$stats['pending']  = $pdo->query("SELECT COUNT(*) FROM products WHERE status='pending'")->fetchColumn();
$stats['orders']   = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();

// Recent pending products
$pending = $pdo->query("
    SELECT p.*, u.full_name AS seller_name
    FROM products p JOIN users u ON u.id = p.seller_id
    WHERE p.status = 'pending'
    ORDER BY p.created_at DESC LIMIT 5
")->fetchAll();

// Recent orders
$recentOrders = $pdo->query("
    SELECT o.*, u.full_name AS customer_name
    FROM orders o JOIN users u ON u.id = o.customer_id
    ORDER BY o.created_at DESC LIMIT 5
")->fetchAll();

$flash = get_flash();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Dashboard – NDIHOTech</title>
  <link rel="stylesheet" href="../assets/style.css"/>
  <link href="https://fonts.googleapis.com/css2?family=IM+Fell+English:ital@0;1&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>
</head>
<body>
<?php require '../includes/navbar.php'; ?>

<section class="section">
  <div class="section-header">
    <h2>Admin Dashboard</h2>
    <p>Overview of AccessTech platform activity</p>
  </div>

  <?php if ($flash): ?>
    <div class="flash <?= e($flash['type']) ?>" style="max-width:1100px;margin:0 auto 20px;"><?= e($flash['message']) ?></div>
  <?php endif; ?>

  <!-- STAT CARDS -->
  <div class="stats-row">
    <div class="stat-card"><div class="num"><?= $stats['users'] ?></div><div class="label">Total Users</div></div>
    <div class="stat-card"><div class="num"><?= $stats['sellers'] ?></div><div class="label">Sellers</div></div>
    <div class="stat-card"><div class="num"><?= $stats['customers'] ?></div><div class="label">Customers</div></div>
    <div class="stat-card"><div class="num"><?= $stats['products'] ?></div><div class="label">Products</div></div>
    <div class="stat-card"><div class="num" style="color:#e6b41e;"><?= $stats['pending'] ?></div><div class="label">Pending Review</div></div>
    <div class="stat-card"><div class="num"><?= $stats['orders'] ?></div><div class="label">Orders</div></div>
  </div>

  <!-- QUICK LINKS -->
  <div style="max-width:1180px; margin:0 auto 40px; display:flex; gap:12px; flex-wrap:wrap;">
    <a href="manage-products.php" class="btn-submit">📦 Manage Products</a>
    <a href="manage-users.php"    class="btn-submit">👥 Manage Users</a>
  </div>

  <!-- PENDING PRODUCTS -->
  <h3 style="font-family:'IM Fell English',serif;font-style:italic;color:#fff;max-width:1180px;margin:0 auto 16px;font-size:1.5rem;">⏳ Products Awaiting Approval</h3>
  <div class="table-wrap" style="max-width:1180px; margin:0 auto 48px;">
    <table class="data-table">
      <thead><tr><th>Image</th><th>Name</th><th>Price</th><th>Seller</th><th>Date</th><th>Action</th></tr></thead>
      <tbody>
        <?php if (empty($pending)): ?>
          <tr><td colspan="6" style="text-align:center;color:#9db4d4;padding:30px;">No products pending review.</td></tr>
        <?php else: ?>
        <?php foreach ($pending as $p): ?>
        <tr>
          <td><?php $img = $p['image_path'] ? '../uploads/products/'.basename($p['image_path']) : 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=80&q=80'; ?><img class="thumb" src="<?= e($img) ?>" alt=""/></td>
          <td><?= e($p['name']) ?></td>
          <td><?= format_money($p['price']) ?></td>
          <td><?= e($p['seller_name']) ?></td>
          <td><?= date('d M Y', strtotime($p['created_at'])) ?></td>
          <td style="display:flex;gap:6px;">
            <form method="POST" action="manage-products.php"><input type="hidden" name="product_id" value="<?= $p['id'] ?>"><button name="action" value="approve" class="btn-tiny approve">✓ Approve</button></form>
            <form method="POST" action="manage-products.php"><input type="hidden" name="product_id" value="<?= $p['id'] ?>"><button name="action" value="reject"  class="btn-tiny reject">✕ Reject</button></form>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <!-- RECENT ORDERS -->
  <h3 style="font-family:'IM Fell English',serif;font-style:italic;color:#fff;max-width:1180px;margin:0 auto 16px;font-size:1.5rem;">🛒 Recent Orders</h3>
  <div class="table-wrap" style="max-width:1180px; margin:0 auto;">
    <table class="data-table">
      <thead><tr><th>Order #</th><th>Customer</th><th>Total</th><th>Status</th><th>Date</th></tr></thead>
      <tbody>
        <?php foreach ($recentOrders as $o): ?>
        <tr>
          <td>#<?= $o['id'] ?></td>
          <td><?= e($o['customer_name']) ?></td>
          <td><?= format_money($o['total_amount']) ?></td>
          <td><span class="status-badge status-<?= $o['status'] === 'completed' ? 'approved' : ($o['status']==='cancelled'?'rejected':'pending') ?>"><?= ucfirst($o['status']) ?></span></td>
          <td><?= date('d M Y', strtotime($o['created_at'])) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</section>

<footer class="site-footer">&copy; <?= date('Y') ?> AccessTech. All rights reserved.</footer>
</body>
</html>
