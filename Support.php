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
  <title>AccessTech – Support</title>
  <link rel="stylesheet" href="assets/style.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@700&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet"/>
</head>
<body>
<?php require 'includes/navbar.php'; ?>

<!-- HERO -->
<section class="page-hero">
  <img class="hero-bg" src="https://images.unsplash.com/photo-1521791136064-7986c2920216?w=1400&q=80" alt="Support"/>
  <div class="hero-overlay"></div>
  <div class="hero-content">
    <h1 style="font-family:'Caveat',cursive;font-size:3.4rem;letter-spacing:2px;">We're Here to Help You</h1>
    <p>Providing assistance and resources to ensure a seamless experience for our users</p>
    <a href="#faq" class="btn-hero">View FAQs ↓</a>
  </div>
</section>

<!-- FAQ SECTION -->
<section class="section" id="faq">
  <div class="section-header">
    <h2 style="font-family:'Caveat',cursive;font-size:2.8rem;letter-spacing:2px;">Frequently Asked Questions</h2>
    <p>Find quick answers to the most common questions about our products, ordering, and support.</p>
  </div>

  <div class="faq-list">
    <?php
    $faqs = [
      ['How do I place an order on AccessTech?', 'Browse our Products page, select the item you need, and click "View Product." Add it to your cart, then navigate to Cart & Checkout, review your items, and click "Proceed to Checkout." You must be logged in as a customer to complete your order.'],
      ['What payment methods do you accept?', 'We accept all major credit and debit cards (Visa, Mastercard, Amex), PayPal, and mobile payment options. All transactions are encrypted and processed securely.'],
      ['How long does shipping take?', 'Standard shipping takes 3–5 business days. Express shipping (1–2 business days) is available at checkout. We provide a tracking number via email once your order is dispatched.'],
      ['Can I return or exchange a product?', 'Yes! We offer a 30-day return and exchange policy. Items must be in their original condition. Contact our team at ndihoalain350@gmail.com to start a return.'],
      ['How do I track my order?', 'Once your order ships, you\'ll receive a confirmation email with a tracking link. You can also log in and visit "My Orders" to view real-time delivery updates.'],
      ['Do your products come with a warranty?', 'All products sold on AccessTech come with the manufacturer\'s standard warranty. Most items include a 12-month warranty covering hardware defects.'],
      ['How can I sell on AccessTech?', 'Register for a Seller account, log in, and use the Seller Dashboard to upload your products. An admin will review and approve your listing before it goes live.'],
      ['How can I contact the AccessTech support team?', 'You can reach us via email at ndihoalain350@gmail.com or by calling 0794032087. We aim to respond to all queries within 24 hours.'],
    ];
    $first = true;
    foreach ($faqs as [$q, $a]):
    ?>
    <div class="faq-item <?= $first ? 'open' : '' ?>">
      <button class="faq-question" onclick="toggleFaq(this)">
        <span><?= e($q) ?></span>
        <span class="faq-icon">&#8964;</span>
      </button>
      <div class="faq-answer"><p><?= e($a) ?></p></div>
    </div>
    <?php $first = false; endforeach; ?>
  </div>
</section>

<!-- GET IN TOUCH FORM -->
<section class="section" style="background:#141c2e;">
  <div class="section-header">
    <h2 style="font-family:'Caveat',cursive;letter-spacing:2px;">Get in Touch</h2>
    <p>Have questions or need assistance? Fill out the form below and our support team will get back to you promptly.</p>
  </div>

  <?php if ($flash): ?>
    <div class="flash <?= e($flash['type']) ?>" style="max-width:480px;margin:0 auto 20px;"><?= e($flash['message']) ?></div>
  <?php endif; ?>

  <div style="max-width:480px; margin:0 auto; display:flex; flex-direction:column; gap:14px;">
    <form method="POST" action="contact-submit.php">
      <input type="text"  name="full_name" class="form-input" placeholder="Name" style="margin-bottom:12px;" required/>
      <input type="email" name="email"     class="form-input" placeholder="Email" style="margin-bottom:12px;" required/>
      <textarea           name="message"   class="form-input" rows="5" placeholder="Message" style="margin-bottom:12px;" required></textarea>
      <button type="submit" class="btn-submit btn-full">Submit</button>
    </form>
  </div>

  <!-- Contact info cards -->
  <div style="display:flex; gap:24px; justify-content:center; flex-wrap:wrap; margin-top:40px;">
    <?php $cards = [['📧','Email','ndihoalain350@gmail.com'],['📞','Phone','0794032087'],['📍','Location','Kigali, Rwanda'],['🕐','Hours','Mon–Fri · 9am–6pm']]; ?>
    <?php foreach ($cards as [$ico,$lbl,$val]): ?>
    <div style="background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.1);border-radius:12px;padding:20px 28px;text-align:center;min-width:150px;">
      <span style="font-size:1.6rem;display:block;margin-bottom:8px;"><?= $ico ?></span>
      <h4 style="color:#7eb8e0;font-size:.78rem;font-weight:600;text-transform:uppercase;letter-spacing:1px;margin-bottom:5px;"><?= $lbl ?></h4>
      <p style="color:#dce8f5;font-size:.9rem;"><?= e($val) ?></p>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<footer class="site-footer">&copy; <?= date('Y') ?> AccessTech. All rights reserved.</footer>

<script>
function toggleFaq(btn) {
  const item = btn.closest('.faq-item');
  const isOpen = item.classList.contains('open');
  document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('open'));
  if (!isOpen) item.classList.add('open');
}
</script>
</body>
</html>