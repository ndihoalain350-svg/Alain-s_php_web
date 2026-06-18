<?php
require_once '../includes/session.php';
require_once '../config/db.php';
require_once '../includes/functions.php';
set_base_depth(1);
require_role(['seller']);

$uid = current_user()['id'];

$products = $pdo->prepare("SELECT * FROM products WHERE seller_id = ? ORDER BY created_at DESC");
$products->execute([$uid]);
$myProducts = $products->fetchAll();

$profile = $pdo->prepare("SELECT * FROM seller_profiles WHERE user_id = ?");
$profile->execute([$uid]);
$prof = $profile->fetch();

$counts = ['total'=>0,'pending'=>0,'approved'=>0,'rejected'=>0];
foreach ($myProducts as $p) {
    $counts['total']++;
    $counts[$p['status']]++;
}

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $shopName = trim($_POST['shop_name'] ?? '');
    $location = trim($_POST['location_text'] ?? '');
    $lat  = $_POST['latitude']  ?: null;
    $lng  = $_POST['longitude'] ?: null;

    $pdo->prepare("UPDATE seller_profiles SET shop_name=?, location_text=?, latitude=?, longitude=? WHERE user_id=?")
        ->execute([$shopName ?: null, $location ?: null, $lat, $lng, $uid]);
    set_flash('success', 'Profile updated!');
    redirect('dashboard.php');
}

// Handle product delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_product'])) {
    $pid = (int)$_POST['delete_product'];
    $pdo->prepare("DELETE FROM products WHERE id = ? AND seller_id = ?")->execute([$pid, $uid]);
    set_flash('success', 'Product deleted.');
    redirect('dashboard.php');
}

$flash = get_flash();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Seller Dashboard – AccessTech</title>
  <link rel="stylesheet" href="../assets/style.css"/>
  <link href="https://fonts.googleapis.com/css2?family=IM+Fell+English:ital@0;1&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>
</head>
<body>
<?php require '../includes/navbar.php'; ?>

<section class="section">
  <div class="section-header">
    <h2>Seller Dashboard</h2>
    <p>Welcome, <?= e(current_user()['full_name']) ?>! Manage your products and profile here.</p>
  </div>

  <?php if ($flash): ?>
    <div class="flash <?= e($flash['type']) ?>" style="max-width:1100px;margin:0 auto 20px;"><?= e($flash['message']) ?></div>
  <?php endif; ?>

  <!-- STAT CARDS -->
  <div class="stats-row">
    <div class="stat-card"><div class="num"><?= $counts['total'] ?></div><div class="label">Total Products</div></div>
    <div class="stat-card"><div class="num" style="color:#e6b41e;"><?= $counts['pending'] ?></div><div class="label">Pending Approval</div></div>
    <div class="stat-card"><div class="num" style="color:#4fd494;"><?= $counts['approved'] ?></div><div class="label">Approved</div></div>
    <div class="stat-card"><div class="num" style="color:#f08080;"><?= $counts['rejected'] ?></div><div class="label">Rejected</div></div>
  </div>

  <!-- ACTIONS -->
  <div style="max-width:1180px; margin:0 auto 32px; display:flex; gap:12px; flex-wrap:wrap;">
    <a href="upload-product.php" class="btn-submit">+ Upload New Product</a>
  </div>

  <!-- MY PRODUCTS TABLE -->
  <div class="table-wrap" style="max-width:1180px; margin:0 auto 48px;">
    <table class="data-table">
      <thead>
        <tr>
          <th>Image</th><th>Product Name</th><th>Price</th><th>Status</th><th>Date Added</th><th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($myProducts)): ?>
          <tr><td colspan="6" style="text-align:center; color:#9db4d4; padding:40px;">No products yet. <a href="upload-product.php" style="color:#6b9fe4;">Upload your first product →</a></td></tr>
        <?php else: ?>
        <?php foreach ($myProducts as $p): ?>
        <tr>
          <td>
            <?php $img = $p['image_path'] ? '../uploads/products/'.basename($p['image_path']) : 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=80&q=80'; ?>
            <img class="thumb" src="<?= e($img) ?>" alt=""/>
          </td>
          <td><?= e($p['name']) ?></td>
          <td><?= format_money($p['price']) ?></td>
          <td><span class="status-badge status-<?= $p['status'] ?>"><?= ucfirst($p['status']) ?></span></td>
          <td><?= date('d M Y', strtotime($p['created_at'])) ?></td>
          <td style="display:flex; gap:6px; flex-wrap:wrap;">
            <a href="upload-product.php?edit=<?= $p['id'] ?>" class="btn-tiny edit">Edit</a>
            <form method="POST" style="display:inline;" onsubmit="return confirm('Delete this product?')">
              <button name="delete_product" value="<?= $p['id'] ?>" class="btn-tiny delete">Delete</button>
            </form>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <!-- PROFILE UPDATE -->
  <div style="max-width:600px; margin:0 auto;">
    <h3 style="font-family:'IM Fell English',serif; font-style:italic; color:#fff; font-size:1.6rem; margin-bottom:20px;">Shop Profile &amp; Location</h3>
    <form method="POST" class="form-card" style="max-width:100%;">
      <div class="form-group">
        <label>Shop Name</label>
        <input name="shop_name" type="text" class="form-input" value="<?= e($prof['shop_name'] ?? '') ?>" placeholder="My Tech Store"/>
      </div>
      <div class="form-group">
        <label>Location (text, e.g. Kimihurura, Kigali)</label>
        <input name="location_text" type="text" class="form-input" value="<?= e($prof['location_text'] ?? '') ?>"/>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label>Latitude</label>
          <input name="latitude" type="text" class="form-input" value="<?= e($prof['latitude'] ?? '') ?>" placeholder="-1.9441"/>
        </div>
        <div class="form-group">
          <label>Longitude</label>
          <input name="longitude" type="text" class="form-input" value="<?= e($prof['longitude'] ?? '') ?>" placeholder="30.0619"/>
        </div>
      </div>
      <button name="update_profile" value="1" class="btn-submit btn-full">Save Profile</button>
    </form>
  </div>
</section>

<footer class="site-footer">&copy; <?= date('Y') ?> AccessTech. All rights reserved.</footer>
</body>
</html>