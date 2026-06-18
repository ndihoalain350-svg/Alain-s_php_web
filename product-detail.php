<?php
require_once 'includes/session.php';
require_once 'config/db.php';
require_once 'includes/functions.php';
set_base_depth(0);

$id = (int)($_GET['id'] ?? 0);
if (!$id) { redirect('products.php'); }

$stmt = $pdo->prepare("
    SELECT p.*, u.full_name AS seller_name, sp.location_text, sp.latitude, sp.longitude
    FROM products p
    JOIN users u ON u.id = p.seller_id
    LEFT JOIN seller_profiles sp ON sp.user_id = p.seller_id
    WHERE p.id = ? AND p.status = 'approved'
");
$stmt->execute([$id]);
$product = $stmt->fetch();
if (!$product) { redirect('products.php'); }

// Documents
$docs = $pdo->prepare("SELECT * FROM product_documents WHERE product_id = ?");
$docs->execute([$id]);
$documents = $docs->fetchAll();

// Comments
$coms = $pdo->prepare("
    SELECT c.*, u.full_name
    FROM comments c JOIN users u ON u.id = c.customer_id
    WHERE c.product_id = ?
    ORDER BY c.created_at DESC
");
$coms->execute([$id]);
$comments = $coms->fetchAll();

$error = '';
// Handle comment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment_text'])) {
    require_login();
    require_role(['customer']);
    $rating  = max(1, min(5, (int)($_POST['rating'] ?? 5)));
    $comment = trim($_POST['comment_text'] ?? '');
    if ($comment === '') {
        $error = 'Comment cannot be empty.';
    } else {
        $ins = $pdo->prepare("INSERT INTO comments (product_id, customer_id, rating, comment_text) VALUES (?,?,?,?)");
        $ins->execute([$id, current_user()['id'], $rating, $comment]);
        set_flash('success', 'Comment posted!');
        redirect("product-detail.php?id=$id");
    }
}

// Add to cart (session-based)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
    $pid = $id;
    if (isset($_SESSION['cart'][$pid])) {
        $_SESSION['cart'][$pid]['qty']++;
    } else {
        $_SESSION['cart'][$pid] = [
            'id'    => $product['id'],
            'name'  => $product['name'],
            'price' => $product['price'],
            'image' => $product['image_path'],
            'qty'   => 1,
        ];
    }
    set_flash('success', 'Added to cart!');
    redirect("product-detail.php?id=$id");
}

$flash = get_flash();
$img = $product['image_path']
    ? 'uploads/products/' . basename($product['image_path'])
    : 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=800&q=80';
$avgRating = count($comments) ? round(array_sum(array_column($comments,'rating')) / count($comments)) : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= e($product['name']) ?> – AccessTech</title>
  <link rel="stylesheet" href="assets/style.css"/>
  <link href="https://fonts.googleapis.com/css2?family=IM+Fell+English:ital@0;1&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>
</head>
<body>
<?php require 'includes/navbar.php'; ?>

<section class="section">
  <?php if ($flash): ?>
    <div class="flash <?= e($flash['type']) ?>" style="max-width:1100px;margin:0 auto 20px;"><?= e($flash['message']) ?></div>
  <?php endif; ?>
  <?php if ($error): ?>
    <div class="flash error" style="max-width:1100px;margin:0 auto 20px;"><?= e($error) ?></div>
  <?php endif; ?>

  <div class="product-detail">
    <!-- Image -->
    <div>
      <img class="main-img" src="<?= e($img) ?>" alt="<?= e($product['name']) ?>"/>
    </div>

    <!-- Info -->
    <div>
      <h1><?= e($product['name']) ?></h1>
      <p class="price-big"><?= format_money($product['price']) ?></p>
      <p class="seller-line">Sold by: <strong><?= e($product['seller_name']) ?></strong>
        <?php if ($product['location_text']): ?>
          &nbsp;· 📍 <?= e($product['location_text']) ?>
        <?php endif; ?>
      </p>
      <?php if ($avgRating): ?>
        <p style="color:#e6b41e; margin-bottom:14px; font-size:1.1rem;"><?= star_rating($avgRating) ?> <span style="color:#9db4d4; font-size:.85rem;">(<?= count($comments) ?> review<?= count($comments)!==1?'s':'' ?>)</span></p>
      <?php endif; ?>
      <p class="desc"><?= nl2br(e($product['description'] ?? '')) ?></p>

      <!-- Add to cart -->
      <form method="POST" style="margin-bottom:20px;">
        <input type="hidden" name="add_to_cart" value="1"/>
        <button type="submit" class="btn-submit" style="padding:13px 36px; font-size:1rem;">🛒 Add to Cart</button>
      </form>

      <!-- Documents -->
      <?php if ($documents): ?>
      <div style="margin-top:10px;">
        <h3 style="color:#7eb8e0; font-size:.9rem; text-transform:uppercase; letter-spacing:1px; margin-bottom:10px;">📄 Product Documents</h3>
        <ul class="doc-list">
          <?php foreach ($documents as $doc): ?>
            <li><a href="uploads/documents/<?= e(basename($doc['file_path'])) ?>" download="<?= e($doc['file_name']) ?>">⬇ <?= e($doc['file_name']) ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- COMMENTS SECTION -->
  <div style="max-width:860px; margin:0 auto;">
    <h2 style="font-family:'IM Fell English',serif; font-style:italic; color:#fff; margin-bottom:24px;">Customer Reviews</h2>

    <?php if (is_logged_in() && current_user()['role']==='customer'): ?>
    <div style="background:rgba(255,255,255,.04); border:1px solid rgba(255,255,255,.1); border-radius:12px; padding:24px; margin-bottom:32px;">
      <h3 style="color:#7eb8e0; margin-bottom:16px;">Leave a Review</h3>
      <form method="POST">
        <div class="form-group">
          <label style="color:#b8c8e0;">Rating</label>
          <select name="rating" class="form-input" style="max-width:200px;">
            <option value="5">★★★★★ (5)</option>
            <option value="4">★★★★☆ (4)</option>
            <option value="3">★★★☆☆ (3)</option>
            <option value="2">★★☆☆☆ (2)</option>
            <option value="1">★☆☆☆☆ (1)</option>
          </select>
        </div>
        <div class="form-group">
          <label style="color:#b8c8e0;">Your Comment</label>
          <textarea name="comment_text" class="form-input" rows="4" placeholder="Share your experience with this product..."></textarea>
        </div>
        <button type="submit" class="btn-submit">Post Review</button>
      </form>
    </div>
    <?php elseif (!is_logged_in()): ?>
      <p style="color:#9db4d4; margin-bottom:24px;"><a href="login.php" style="color:#6b9fe4;">Log in</a> as a customer to leave a review.</p>
    <?php endif; ?>

    <?php if (empty($comments)): ?>
      <p class="muted">No reviews yet. Be the first!</p>
    <?php else: ?>
      <?php foreach ($comments as $c): ?>
      <div class="comment-card">
        <div class="stars"><?= star_rating($c['rating']) ?></div>
        <p style="color:#d0dcea;"><?= nl2br(e($c['comment_text'])) ?></p>
        <p class="author">— <?= e($c['full_name']) ?> · <?= date('d M Y', strtotime($c['created_at'])) ?></p>
      </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</section>

<footer class="site-footer">&copy; <?= date('Y') ?> AccessTech. All rights reserved.</footer>
</body>
</html>