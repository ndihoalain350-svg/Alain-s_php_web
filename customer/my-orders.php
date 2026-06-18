<?php
require_once '../includes/session.php';
require_once '../config/db.php';
require_once '../includes/functions.php';
set_base_depth(1);
require_role(['customer']);

$uid = current_user()['id'];

$orders = $pdo->prepare("
    SELECT o.*,
           COUNT(oi.id) AS item_count
    FROM orders o
    LEFT JOIN order_items oi ON oi.order_id = o.id
    WHERE o.customer_id = ?
    GROUP BY o.id
    ORDER BY o.created_at DESC
");
$orders->execute([$uid]);
$myOrders = $orders->fetchAll();

// Fetch items for a specific order if requested
$viewOrder = null;
$viewItems = [];
if (isset($_GET['view'])) {
    $oid = (int)$_GET['view'];
    $check = $pdo->prepare("SELECT * FROM orders WHERE id=? AND customer_id=?");
    $check->execute([$oid, $uid]);
    $viewOrder = $check->fetch();
    if ($viewOrder) {
        $items = $pdo->prepare("
            SELECT oi.*, p.name, p.image_path
            FROM order_items oi JOIN products p ON p.id = oi.product_id
            WHERE oi.order_id = ?
        ");
        $items->execute([$oid]);
        $viewItems = $items->fetchAll();
    }
}

$flash = get_flash();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>My Orders – AccessTech</title>
  <link rel="stylesheet" href="../assets/style.css"/>
  <link href="https://fonts.googleapis.com/css2?family=IM+Fell+English:ital@0;1&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>
</head>
<body>
<?php require '../includes/navbar.php'; ?>

<section class="section" style="min-height:80vh;">
  <div class="section-header">
    <h2>My Orders</h2>
    <p>Track all your AccessTech purchases in one place.</p>
  </div>

  <?php if ($flash): ?>
    <div class="flash <?= e($flash['type']) ?>" style="max-width:1100px;margin:0 auto 20px;"><?= e($flash['message']) ?></div>
  <?php endif; ?>

  <?php if ($viewOrder && $viewItems): ?>
  <!-- ORDER DETAIL VIEW -->
  <div style="max-width:860px; margin:0 auto 40px;">
    <a href="my-orders.php" style="color:#6b9fe4; font-size:.9rem;">← Back to all orders</a>
    <h3 style="font-family:'IM Fell English',serif;font-style:italic;color:#fff;margin:16px 0 8px;font-size:1.6rem;">Order #<?= $viewOrder['id'] ?></h3>
    <p style="color:#9db4d4; margin-bottom:20px;">Placed on <?= date('d M Y, H:i', strtotime($viewOrder['created_at'])) ?> · Status: <span class="status-badge status-<?= $viewOrder['status']==='completed'?'approved':($viewOrder['status']==='cancelled'?'rejected':'pending') ?>"><?= ucfirst($viewOrder['status']) ?></span></p>

    <div class="table-wrap">
      <table class="data-table">
        <thead><tr><th>Product</th><th>Unit Price</th><th>Qty</th><th>Subtotal</th></tr></thead>
        <tbody>
          <?php foreach ($viewItems as $item): ?>
          <tr>
            <td>
              <?php $img = $item['image_path'] ? '../uploads/products/'.basename($item['image_path']) : 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=80&q=80'; ?>
              <img class="thumb" src="<?= e($img) ?>" alt=""/> <?= e($item['name']) ?>
            </td>
            <td><?= format_money($item['unit_price']) ?></td>
            <td><?= $item['quantity'] ?></td>
            <td><?= format_money($item['unit_price'] * $item['quantity']) ?></td>
          </tr>
          <?php endforeach; ?>
          <tr>
            <td colspan="3" style="text-align:right; font-weight:700; color:#fff;">Total</td>
            <td style="font-weight:700; color:#6b9fe4;"><?= format_money($viewOrder['total_amount']) ?></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <?php endif; ?>

  <!-- ORDERS LIST -->
  <?php if (empty($myOrders)): ?>
    <p class="empty-state">You haven't placed any orders yet. <a href="../products.php" style="color:#6b9fe4;">Start shopping →</a></p>
  <?php else: ?>
  <div class="table-wrap" style="max-width:1100px; margin:0 auto;">
    <table class="data-table">
      <thead>
        <tr><th>Order #</th><th>Items</th><th>Total</th><th>Status</th><th>Date</th><th></th></tr>
      </thead>
      <tbody>
        <?php foreach ($myOrders as $o): ?>
        <tr>
          <td>#<?= $o['id'] ?></td>
          <td><?= $o['item_count'] ?> item<?= $o['item_count']!==1?'s':'' ?></td>
          <td><?= format_money($o['total_amount']) ?></td>
          <td><span class="status-badge status-<?= $o['status']==='completed'?'approved':($o['status']==='cancelled'?'rejected':'pending') ?>"><?= ucfirst($o['status']) ?></span></td>
          <td><?= date('d M Y', strtotime($o['created_at'])) ?></td>
          <td><a href="?view=<?= $o['id'] ?>" class="btn-tiny edit">View Details</a></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php endif; ?>
</section>

<footer class="site-footer">&copy; <?= date('Y') ?> AccessTech. All rights reserved.</footer>
</body>
</html>