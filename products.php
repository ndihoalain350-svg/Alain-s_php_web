<?php
require_once 'includes/session.php';
require_once 'config/db.php';
require_once 'includes/functions.php';
set_base_depth(0);

// Fetch only approved products
$stmt = $pdo->query("
    SELECT p.*, u.full_name AS seller_name
    FROM products p
    JOIN users u ON u.id = p.seller_id
    WHERE p.status = 'approved'
    ORDER BY p.created_at DESC
");
$products = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>AccessTech – Products</title>
  <link rel="stylesheet" href="assets/style.css"/>
  <link href="https://fonts.googleapis.com/css2?family=IM+Fell+English:ital@0;1&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>
</head>
<body>
<?php require 'includes/navbar.php'; ?>

<!-- HERO -->
<section class="page-hero">
  <img class="hero-bg" src="https://images.unsplash.com/photo-1531482615713-2afd69097998?w=1600&q=80" alt="Products"/>
  <div class="hero-overlay"></div>
  <div class="hero-content">
    <h1>Discover the Latest Electronic Devices</h1>
    <p>Explore our extensive collection of cutting-edge electronics from verified sellers.</p>
    <a href="#catalogue" class="btn-hero">Browse Products</a>
  </div>
</section>

<!-- PRODUCTS GRID -->
<section class="section" id="catalogue">
  <div class="section-header">
    <h2>Our Electronic Store</h2>
    <p>Quality Devices at Your Fingertips</p>
  </div>

  <?php $flash = get_flash(); if ($flash): ?>
    <div class="flash <?= e($flash['type']) ?>" style="max-width:1100px;margin:0 auto 20px;"><?= e($flash['message']) ?></div>
  <?php endif; ?>

  <?php if (empty($products)): ?>
    <p class="empty-state">No products available yet. Check back soon!</p>
  <?php else: ?>
  <div class="products-grid">
    <?php foreach ($products as $p): ?>
    <div class="product-card">
      <?php
        $img = $p['image_path']
          ? 'uploads/products/' . basename($p['image_path'])
          : 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=600&q=80';
      ?>
      <img src="<?= e($img) ?>" alt="<?= e($p['name']) ?>"/>
      <div class="card-info">
        <p class="card-name"><?= e($p['name']) ?></p>
        <p class="card-price"><?= format_money($p['price']) ?></p>
        <p class="card-seller">Sold by: <?= e($p['seller_name']) ?></p>
        <a href="product-detail.php?id=<?= $p['id'] ?>" class="btn-small">View Product</a>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>
</section>

<footer class="site-footer">&copy; <?= date('Y') ?> AccessTech. All rights reserved.</footer>
</body>
</html>