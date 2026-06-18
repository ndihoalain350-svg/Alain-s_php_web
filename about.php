<?php
require_once 'includes/session.php';
require_once 'config/db.php';
require_once 'includes/functions.php';
set_base_depth(0);
$flash = get_flash();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>AccessTech – About Us</title>
  <link rel="stylesheet" href="assets/style.css"/>
  <link href="https://fonts.googleapis.com/css2?family=IM+Fell+English:ital@0;1&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>
  <style>
    .vision-section { display:grid; grid-template-columns:65% 35%; min-height:520px; background:#1a2540; }
    .vision-img { position:relative; overflow:hidden; }
    .vision-img img { width:100%; height:100%; object-fit:cover; display:block; transition:transform .5s ease,filter .5s ease; }
    .vision-img:hover img { transform:scale(1.06); filter:brightness(.8); }
    .vision-content { background:#1e2d52; display:flex; align-items:center; justify-content:center; padding:60px 44px; transition:background .4s; }
    .vision-content:hover { background:#243568; }
    .vision-card { display:flex; flex-direction:column; gap:24px; text-align:center; max-width:340px; }
    .vision-stats { display:flex; align-items:center; justify-content:center; gap:16px; padding-top:20px; border-top:1px solid rgba(255,255,255,.1); }
    .stat-item-v { display:flex; flex-direction:column; align-items:center; gap:4px; transition:transform .3s; }
    .stat-item-v:hover { transform:translateY(-4px); }
    .stat-num-v { font-size:22px; font-weight:700; color:#6b9fe4; }
    .stat-label-v { font-size:11px; font-weight:600; color:#7a8fad; letter-spacing:1px; text-transform:uppercase; }
    .stat-div { width:1px; height:36px; background:rgba(255,255,255,.15); }
    @media(max-width:768px){ .vision-section{grid-template-columns:1fr;} .vision-img{height:300px;} }
  </style>
</head>
<body>
<?php require 'includes/navbar.php'; ?>

<!-- HERO -->
<section class="page-hero">
  <img class="hero-bg" src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=1600&auto=format&fit=crop" alt="About AccessTech"/>
  <div class="hero-overlay"></div>
  <div class="hero-content">
    <h1>Welcome to AccessTech</h1>
    <p>Your Gateway to a Seamless Electronic Marketplace</p>
    <a href="#mission" class="btn-hero">Learn More</a>
  </div>
</section>

<!-- MISSION -->
<section class="split-section" id="mission">
  <div class="split-image">
    <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=1000&auto=format&fit=crop" alt="Our Mission"/>
  </div>
  <div class="split-content">
    <h2 class="split-title">Our Mission</h2>
    <p class="split-desc">To provide a reliable and user-friendly platform where sellers can showcase their electronic devices and buyers can access a wide range of products effortlessly.</p>
  </div>
</section>

<!-- VISION -->
<section class="vision-section" id="vision">
  <div class="vision-img">
    <img src="https://images.unsplash.com/photo-1593642632559-0c6d3fc62b89?w=1000&auto=format&fit=crop" alt="Our Vision"/>
  </div>
  <div class="vision-content">
    <div class="vision-card">
      <h2 class="split-title">Our Vision</h2>
      <p class="split-desc">To become the leading online marketplace for electronic devices, fostering trust, transparency, and convenience for all users.</p>
      <a href="products.php" class="btn-learn">Discover More</a>
      <div class="vision-stats">
        <div class="stat-item-v"><span class="stat-num-v">10K+</span><span class="stat-label-v">Products</span></div>
        <div class="stat-div"></div>
        <div class="stat-item-v"><span class="stat-num-v">50K+</span><span class="stat-label-v">Customers</span></div>
        <div class="stat-div"></div>
        <div class="stat-item-v"><span class="stat-num-v">98%</span><span class="stat-label-v">Satisfaction</span></div>
      </div>
    </div>
  </div>
</section>

<!-- CONTACT & LOCATION -->
<section class="section" id="contact" style="background:#1a2540;">
  <div class="section-header">
    <h2>Contact &amp; Location</h2>
    <p>We're Here to Assist You – Visit or Reach Out Anytime</p>
  </div>

  <?php if ($flash): ?>
    <div class="flash <?= e($flash['type']) ?>" style="max-width:1100px;margin:0 auto 20px;"><?= e($flash['message']) ?></div>
  <?php endif; ?>

  <div style="display:grid; grid-template-columns:1fr 1.4fr 1fr; gap:36px; max-width:1300px; margin:0 auto;">

    <!-- FORM -->
    <div style="display:flex;flex-direction:column;gap:16px;">
      <form method="POST" action="contact-submit.php">
        <input type="text"    name="full_name" class="form-input" placeholder="Name" style="margin-bottom:12px;" required/>
        <input type="email"   name="email"     class="form-input" placeholder="Email" style="margin-bottom:12px;" required/>
        <textarea             name="message"   class="form-input" rows="5" placeholder="Message" style="margin-bottom:12px;" required></textarea>
        <button type="submit" class="btn-submit btn-full">Submit</button>
      </form>
    </div>

    <!-- MAP -->
    <div style="border-radius:5px;overflow:hidden;border:1px solid #3a4a6a;">
      <iframe title="AccessTech Location"
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d255149.43968689388!2d29.9019!3d-1.9437!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x19dca4258ed8e797%3A0xf32b36a5411d0bc8!2sKigali%2C%20Rwanda!5e0!3m2!1sen!2srw!4v1680000000000"
        width="100%" height="320" style="border:0;display:block;" allowfullscreen loading="lazy"></iframe>
    </div>

    <!-- INFO PANEL -->
    <div style="display:flex;flex-direction:column;gap:20px;">
      <?php $infos = [['📍','KG11 Ave, Kimihurura<br>Gasabo, Kigali Rwanda'],['🕐','Mon–Fri 10am–5pm, Sat 1pm–5pm'],['📱','0794032087'],['✉','ndihoalain350@gmail.com']]; ?>
      <?php foreach ($infos as [$icon,$text]): ?>
      <div style="display:flex;align-items:flex-start;gap:14px;padding:14px 16px;border-radius:8px;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.06);">
        <span style="font-size:20px;"><?= $icon ?></span>
        <span style="font-size:15px;color:#c8d8f0;line-height:1.6;"><?= $text ?></span>
      </div>
      <?php endforeach; ?>
    </div>

  </div>
</section>

<footer class="site-footer">&copy; <?= date('Y') ?> AccessTech. All rights reserved.</footer>
</body>
</html>