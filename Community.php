<?php
require_once 'includes/session.php';
require_once 'config/db.php';
require_once 'includes/functions.php';
set_base_depth(0);

// Handle newsletter subscription
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if ($email && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Check duplicate
        $chk = $pdo->prepare("SELECT id FROM newsletter_subscribers WHERE email=?");
        $chk->execute([$email]);
        if ($chk->fetch()) {
            set_flash('error', 'That email is already subscribed!');
        } else {
            $pdo->prepare("INSERT INTO newsletter_subscribers (full_name, email) VALUES (?,?)")->execute([$name ?: null, $email]);
            set_flash('success', '🎉 You\'re subscribed! Welcome to the AccessTech community.');
        }
    } else {
        set_flash('error', 'Please enter a valid email address.');
    }
    redirect('community.php');
}

$flash = get_flash();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>AccessTech – Join Our Community</title>
  <link rel="stylesheet" href="assets/style.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@700&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>
  <style>
    .newsletter-hero { position:relative; min-height:420px; display:flex; align-items:center; justify-content:center; overflow:hidden; }
    .newsletter-hero img.hero-bg { position:absolute; inset:0; width:100%; height:100%; object-fit:cover; filter:brightness(.42); }
    .newsletter-content { position:relative; z-index:2; text-align:center; padding:60px 24px 80px; max-width:820px; width:100%; }
    .newsletter-content h1 { font-family:'Caveat',cursive; font-size:3.2rem; color:#fff; letter-spacing:2px; margin-bottom:16px; }
    .newsletter-content p { color:#d8e8f5; font-size:1rem; line-height:1.65; margin-bottom:36px; }
    .newsletter-form { display:flex; gap:12px; justify-content:center; flex-wrap:wrap; }
    .newsletter-form input { flex:1; min-width:180px; max-width:260px; background:#fff; border:none; border-radius:7px; padding:15px 18px; font-size:.97rem; color:#333; outline:none; }
    .newsletter-hero::after { content:''; position:absolute; bottom:-1px; left:0; width:100%; height:90px; background:#0f1b35; clip-path:polygon(0 55%,100% 0,100% 100%,0 100%); z-index:3; }
    .social-section { background:radial-gradient(circle,rgba(255,255,255,.05) 1px,transparent 1px),linear-gradient(155deg,#0f1b35 0%,#1a2c55 40%,#162d45 75%,#0d2233 100%); background-size:28px 28px,100% 100%; padding:80px 24px 90px; }
    .social-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:22px; max-width:1060px; margin:0 auto 56px; }
    .social-card { border-radius:16px; padding:32px 20px 28px; text-align:center; display:flex; flex-direction:column; align-items:center; gap:14px; cursor:pointer; transition:transform .22s; }
    .social-card:hover { transform:translateY(-7px); }
    .card-facebook  { background:linear-gradient(145deg,#1a3c8f,#1877f2); }
    .card-twitter   { background:linear-gradient(145deg,#0d1f3c,#1da1f2); }
    .card-instagram { background:linear-gradient(145deg,#833ab4,#e1306c,#f77737); }
    .card-youtube   { background:linear-gradient(145deg,#1a0a0a,#ff0000); }
    .social-icon { width:62px; height:62px; background:rgba(255,255,255,.18); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:1.8rem; border:2px solid rgba(255,255,255,.25); }
    .social-card h3 { color:#fff; font-size:1.05rem; font-weight:700; }
    .social-card p { color:rgba(255,255,255,.75); font-size:.85rem; line-height:1.5; }
    .social-card .followers { color:rgba(255,255,255,.6); font-size:.78rem; background:rgba(0,0,0,.2); padding:4px 14px; border-radius:20px; }
    .btn-follow { background:rgba(255,255,255,.18); color:#fff; border:1.5px solid rgba(255,255,255,.45); padding:9px 26px; border-radius:6px; font-size:.88rem; font-weight:600; cursor:pointer; text-decoration:none; transition:background .2s; }
    .btn-follow:hover { background:rgba(255,255,255,.3); }
    @media(max-width:860px){ .social-grid{grid-template-columns:repeat(2,1fr);} }
    @media(max-width:560px){ .social-grid{grid-template-columns:1fr 1fr;gap:14px;} }
  </style>
</head>
<body>
<?php require 'includes/navbar.php'; ?>

<!-- NEWSLETTER HERO -->
<section class="newsletter-hero">
  <img class="hero-bg" src="https://images.unsplash.com/photo-1529156069898-49953e39b3ac?w=1400&q=80" alt="Community"/>
  <div class="newsletter-content">
    <h1>Join Our Newsletter</h1>
    <p>Stay informed about the latest electronic devices, exclusive deals, and updates directly in your inbox.</p>

    <?php if ($flash): ?>
      <div class="flash <?= e($flash['type']) ?>" style="margin-bottom:20px;"><?= e($flash['message']) ?></div>
    <?php endif; ?>

    <form method="POST" class="newsletter-form">
      <input type="text"  name="full_name" placeholder="Name"  autocomplete="name"/>
      <input type="email" name="email"     placeholder="Email" autocomplete="email" required/>
      <button type="submit" class="btn-submit">Subscribe</button>
    </form>
  </div>
</section>

<!-- SOCIAL MEDIA -->
<section class="social-section">
  <div style="text-align:center; margin-bottom:56px;">
    <h2 style="font-family:'Caveat',cursive; font-size:2.8rem; color:#fff; letter-spacing:2px; margin-bottom:16px;">Connect with Us on Social Media</h2>
    <p style="color:#8ab8d8; font-size:1rem; max-width:680px; margin:0 auto; line-height:1.65;">Follow our profiles to get real-time updates, industry news, and engaging content about our products.</p>
  </div>

  <div class="social-grid">
    <div class="social-card card-facebook"><div class="social-icon">📘</div><h3>Facebook</h3><p>Join our community page for deals and announcements</p><span class="followers">12.4K Followers</span><a href="#" class="btn-follow">Follow Us</a></div>
    <div class="social-card card-twitter"><div class="social-icon">🐦</div><h3>Twitter / X</h3><p>Get real-time updates and tech news in your feed</p><span class="followers">8.1K Followers</span><a href="#" class="btn-follow">Follow Us</a></div>
    <div class="social-card card-instagram"><div class="social-icon">📸</div><h3>Instagram</h3><p>Browse product photos, reels, and user stories</p><span class="followers">21.7K Followers</span><a href="#" class="btn-follow">Follow Us</a></div>
    <div class="social-card card-youtube"><div class="social-icon">▶️</div><h3>YouTube</h3><p>Watch reviews, tutorials and unboxing videos</p><span class="followers">5.3K Subscribers</span><a href="#" class="btn-follow">Subscribe</a></div>
  </div>

  <!-- BENEFITS -->
  <div style="display:flex; justify-content:center; gap:40px; flex-wrap:wrap; max-width:860px; margin:0 auto;">
    <?php $benefits = [['🎁','Exclusive Deals','Members-only discounts & offers'],['📰','Latest News','First to know about new products'],['🤝','Community','Connect with fellow tech lovers'],['🛡️','Priority Support','Faster responses for community members']]; ?>
    <?php foreach ($benefits as [$ico,$title,$desc]): ?>
    <div style="display:flex; align-items:center; gap:12px; color:#b0cce4;">
      <div style="width:42px;height:42px;background:rgba(74,144,217,.15);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1.2rem;border:1px solid rgba(74,144,217,.25);flex-shrink:0;"><?= $ico ?></div>
      <div><h4 style="color:#e0eaf8;font-size:.92rem;font-weight:600;margin-bottom:2px;"><?= $title ?></h4><p style="font-size:.8rem;color:#7a9dc0;line-height:1.4;"><?= $desc ?></p></div>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<footer class="site-footer">&copy; <?= date('Y') ?> AccessTech. All rights reserved.</footer>
</body>
</html>