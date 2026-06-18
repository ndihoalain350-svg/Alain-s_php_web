<?php
require_once '../includes/session.php';
require_once '../config/db.php';
require_once '../includes/functions.php';
set_base_depth(1);
require_role(['admin']);

// Handle approve / reject / delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pid    = (int)($_POST['product_id'] ?? 0);
    $action = $_POST['action'] ?? '';

    if ($pid && in_array($action, ['approve','reject','delete'], true)) {
        if ($action === 'delete') {
            $pdo->prepare("DELETE FROM products WHERE id=?")->execute([$pid]);
            set_flash('success', 'Product deleted.');
        } else {
            $status = $action === 'approve' ? 'approved' : 'rejected';
            $pdo->prepare("UPDATE products SET status=? WHERE id=?")->execute([$status, $pid]);
            set_flash('success', 'Product ' . $status . '.');
        }
    }
    redirect('manage-products.php');
}

$filter = $_GET['filter'] ?? 'all';
$where  = $filter !== 'all' ? "WHERE p.status = '$filter'" : '';

$products = $pdo->query("
    SELECT p.*, u.full_name AS seller_name
    FROM products p JOIN users u ON u.id = p.seller_id
    $where
    ORDER BY p.created_at DESC
")->fetchAll();

$flash = get_flash();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Manage Products – AccessTech Admin</title>
  <link rel="stylesheet" href="../assets/style.css"/>
  <link href="https://fonts.googleapis.com/css2?family=IM+Fell+English:ital@0;1&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>
</head>
<body>
<?php require '../includes/navbar.php'; ?>

<section class="section">
  <div class="section-header">
    <h2>Manage Products</h2>
    <p>Approve, reject or delete seller products.</p>
  </div>

  <?php if ($flash): ?>
    <div class="flash <?= e($flash['type']) ?>" style="max-width:1180px;margin:0 auto 20px;"><?= e($flash['message']) ?></div>
  <?php endif; ?>

  <!-- FILTER TABS -->
  <div style="max-width:1180px; margin:0 auto 24px; display:flex; gap:10px; flex-wrap:wrap;">
    <?php foreach (['all','pending','approved','rejected'] as $f): ?>
      <a href="?filter=<?= $f ?>" class="btn-tiny <?= $filter===$f ? 'approve' : 'edit' ?>" style="padding:8px 18px; font-size:.9rem;"><?= ucfirst($f) ?></a>
    <?php endforeach; ?>
  </div>

  <div class="table-wrap" style="max-width:1180px; margin:0 auto;">
    <table class="data-table">
      <thead>
        <tr><th>Image</th><th>Name</th><th>Price</th><th>Seller</th><th>Status</th><th>Date</th><th>Actions</th></tr>
      </thead>
      <tbody>
        <?php if (empty($products)): ?>
          <tr><td colspan="7" style="text-align:center;color:#9db4d4;padding:40px;">No products found.</td></tr>
        <?php else: ?>
        <?php foreach ($products as $p): ?>
        <tr>
          <td><?php $img = $p['image_path'] ? '../uploads/products/'.basename($p['image_path']) : 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=80&q=80'; ?><img class="thumb" src="<?= e($img) ?>" alt=""/></td>
          <td><?= e($p['name']) ?></td>
          <td><?= format_money($p['price']) ?></td>
          <td><?= e($p['seller_name']) ?></td>
          <td><span class="status-badge status-<?= $p['status'] ?>"><?= ucfirst($p['status']) ?></span></td>
          <td><?= date('d M Y', strtotime($p['created_at'])) ?></td>
          <td style="display:flex;gap:5px;flex-wrap:wrap;">
            <?php if ($p['status']==='pending'): ?>
              <form method="POST"><input type="hidden" name="product_id" value="<?= $p['id'] ?>"><button name="action" value="approve" class="btn-tiny approve">✓</button></form>
              <form method="POST"><input type="hidden" name="product_id" value="<?= $p['id'] ?>"><button name="action" value="reject" class="btn-tiny reject">✕</button></form>
            <?php endif; ?>
            <form method="POST" onsubmit="return confirm('Delete this product permanently?')">
              <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
              <button name="action" value="delete" class="btn-tiny delete">🗑</button>
            </form>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</section>

<footer class="site-footer">&copy; <?= date('Y') ?> AccessTech. All rights reserved.</footer>
</body>
</html>