<?php
require_once 'includes/session.php';
require_once 'config/db.php';
require_once 'includes/functions.php';
set_base_depth(0);

// Load 6 most recent approved products for the featured grid
$featured = $pdo->query("
    SELECT p.*, u.full_name AS seller_name
    FROM products p JOIN users u ON u.id=p.seller_id
    WHERE p.status='approved'
    ORDER BY p.created_at DESC LIMIT 6
")->fetchAll();

$flash = get_flash();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>AccessTech – Home</title>
  <link rel="stylesheet" href="assets/style.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Bangers&family=IM+Fell+English:ital@0;1&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>
  <style>
    .hero-home { position:relative; width:100%; height:100vh; min-height:600px; background-image:url('https://images.unsplash.com/photo-1531297484001-80022131f5a1?w=1600&auto=format&fit=crop'); background-size:cover; background-position:center; display:flex; align-items:flex-end; padding-bottom:120px; }
    .hero-home .hero-overlay { position:absolute; inset:0; background:rgba(0,0,0,.45); }
    .hero-home .hero-content { position:relative; z-index:2; padding:0 60px; max-width:780px; }
    .hero-title { font-family:'Bangers',cursive; font-size:clamp(52px,7vw,90px); color:#fff; line-height:1.05; letter-spacing:2px; text-shadow:2px 3px 10px rgba(0,0,0,.4); margin-bottom:18px; }
    .hero-sub { font-size:18px; color:#eee; margin-bottom:36px; text-shadow:1px 1px 6px rgba(0,0,0,.5); }
    .excellence-section { display:grid; grid-template-columns:60% 40%; min-height:460px; background:#1e2d52; }
    .excellence-img img { width:100%; height:100%; object-fit:cover; display:block; }
    .excellence-content { display:flex; flex-direction:column; justify-content:center; align-items:center; text-align:center; padding:56px 44px; gap:20px; }
    @media(max-width:860px){ .excellence-section{grid-template-columns:1fr;} .excellence-img{height:280px;} }
    @media(max-width:700px){ .hero-home .hero-content{padding:0 28px;} }
  </style>
</head>
<body>
<?php require 'includes/navbar.php'; ?>

<?php if ($flash): ?>
  <div class="flash <?= e($flash['type']) ?>" style="position:fixed;top:80px;left:50%;transform:translateX(-50%);z-index:999;min-width:320px;text-align:center;"><?= e($flash['message']) ?></div>
<?php endif; ?>

<!-- HERO -->
<section class="hero-home">
  <div class="hero-overlay"></div>
  <div class="hero-content">
    <h1 class="hero-title">Access the Latest Electronics</h1>
    <p class="hero-sub">Discover a wide range of electronic devices for every need</p>
    <a href="products.php" class="btn-hero">Shop Now</a>
  </div>
</section>

<!-- FEATURED PRODUCTS -->
<section class="section">
  <div class="section-header">
    <h2>Our Featured Electronics</h2>
    <p>Discover top-rated gadgets and devices selected for quality and popularity.</p>
  </div>

  <?php if (empty($featured)): ?>
    <p class="empty-state">No products available yet. <a href="register.php" style="color:#6b9fe4;">Become a seller</a> to list the first one!</p>
  <?php else: ?>
  <div class="products-grid">
    <?php foreach ($featured as $p): ?>
    <div class="product-card">
      <?php $img = $p['image_path'] ? 'uploads/products/'.basename($p['image_path']) : 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=600&q=80'; ?>
      <img src="<?= e($img) ?>" alt="<?= e($p['name']) ?>"/>
      <div class="card-info">
        <p class="card-name"><?= e($p['name']) ?></p>
        <p class="card-price"><?= format_money($p['price']) ?></p>
        <p class="card-seller">By <?= e($p['seller_name']) ?></p>
        <a href="product-detail.php?id=<?= $p['id'] ?>" class="btn-small">View Product</a>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>
</section>

<!-- COMMITTED TO EXCELLENCE SPLIT -->
<section class="excellence-section">
  <div class="excellence-img">
    <img src="https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=1000&auto=format&fit=crop" alt="Laptop on desk"/>
  </div>
  <div class="excellence-content">
    <h2 class="split-title">Committed to Excellence</h2>
    <p class="split-desc">At AccessTech, we prioritize quality, security, and customer satisfaction to ensure a trusted shopping experience for all users.</p>
    <a href="about.php" class="btn-learn">Learn More</a>
  </div>
</section>

<footer class="site-footer">&copy; <?= date('Y') ?> AccessTech · <a href="about.php">About</a> · <a href="support.php">Support</a></footer>
</body>
</html>