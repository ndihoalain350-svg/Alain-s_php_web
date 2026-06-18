<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>AccessTech – Cart & Checkout</title>
  <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@700&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet"/>
  <style>
    /* ── RESET ── */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'DM Sans', sans-serif;
      background: #f0f2f5;
      color: #1a1a2e;
    }

    /* ════════════════════════════
       NAVBAR
    ════════════════════════════ */
    .navbar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      background: #0d0d0d;
      padding: 0 36px;
      height: 68px;
      position: sticky;
      top: 0;
      z-index: 200;
      gap: 24px;
    }

    /* Logo block */
    .navbar .logo-block {
      display: flex;
      align-items: center;
      gap: 10px;
      text-decoration: none;
      flex-shrink: 0;
    }
    .navbar .logo-icon {
      width: 52px;
      height: 52px;
      background: #fff;
      border-radius: 4px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 4px;
    }
    .navbar .logo-icon .at-badge {
      background: #1a3c8f;
      color: #fff;
      font-size: 0.62rem;
      font-weight: 700;
      padding: 1px 5px;
      border-radius: 3px;
      letter-spacing: 0.5px;
      margin-bottom: 2px;
    }
    .navbar .logo-icon .at-sub {
      color: #555;
      font-size: 0.45rem;
      text-align: center;
      line-height: 1.2;
    }
    .navbar .logo-text {
      color: #fff;
      font-size: 1.35rem;
      font-weight: 700;
      letter-spacing: 1.5px;
      font-style: italic;
      font-family: 'DM Sans', sans-serif;
    }
    .navbar .logo-text span { color: #4a90d9; }

    /* Nav links */
    .navbar nav {
      display: flex;
      align-items: center;
      gap: 30px;
      flex: 1;
      justify-content: center;
    }
    .navbar nav a {
      color: #ccc;
      text-decoration: none;
      font-size: 0.92rem;
      font-weight: 500;
      white-space: nowrap;
      transition: color 0.2s;
    }
    .navbar nav a:hover { color: #fff; }
    .navbar nav a.active {
      color: #fff;
      text-decoration: underline;
      text-underline-offset: 4px;
    }

    /* Submit button */
    .navbar .btn-submit {
      background: #1a56db;
      color: #fff;
      border: none;
      padding: 10px 24px;
      border-radius: 6px;
      font-size: 0.95rem;
      font-weight: 600;
      cursor: pointer;
      flex-shrink: 0;
      transition: background 0.2s;
    }
    .navbar .btn-submit:hover { background: #1447c0; }

    /* ════════════════════════════
       HERO SECTION
    ════════════════════════════ */
    .hero {
      position: relative;
      height: 420px;
      overflow: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .hero img.hero-bg {
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      object-position: center 30%;
      filter: brightness(0.45);
    }
    .hero-content {
      position: relative;
      z-index: 2;
      text-align: center;
      padding: 0 24px;
      max-width: 760px;
    }
    .hero-content h1 {
      font-family: 'Caveat', cursive;
      font-size: 3.4rem;
      color: #fff;
      letter-spacing: 2px;
      line-height: 1.1;
      margin-bottom: 16px;
      text-shadow: 0 2px 8px rgba(0,0,0,0.5);
    }
    .hero-content p {
      color: #e0e8f0;
      font-size: 1.05rem;
      line-height: 1.6;
      margin-bottom: 28px;
    }
    .hero-content .btn-hero {
      display: inline-block;
      background: rgba(255,255,255,0.15);
      border: 2px solid rgba(255,255,255,0.6);
      color: #fff;
      padding: 12px 34px;
      border-radius: 6px;
      font-size: 0.95rem;
      font-weight: 600;
      cursor: pointer;
      text-decoration: none;
      backdrop-filter: blur(4px);
      transition: background 0.2s, border-color 0.2s;
    }
    .hero-content .btn-hero:hover {
      background: rgba(255,255,255,0.28);
      border-color: #fff;
    }

    /* Diagonal clip at bottom of hero */
    .hero::after {
      content: '';
      position: absolute;
      bottom: -1px;
      left: 0;
      width: 100%;
      height: 80px;
      background: #0f1b35;
      clip-path: polygon(0 60%, 100% 0, 100% 100%, 0 100%);
      z-index: 3;
    }

    /* ════════════════════════════
       CART SECTION
    ════════════════════════════ */
    .cart-section {
      background:
        /* soft diagonal dot grid for texture */
        radial-gradient(circle, rgba(255,255,255,0.06) 1px, transparent 1px),
        /* main gradient: deep navy → rich indigo → dark teal */
        linear-gradient(155deg, #0f1b35 0%, #1a2c55 40%, #162d45 75%, #0d2233 100%);
      background-size: 28px 28px, 100% 100%;
      padding: 60px 24px 80px;
      position: relative;
    }

    /* Subtle glowing accent blobs for depth */
    .cart-section::before {
      content: '';
      position: absolute;
      top: -80px;
      left: -80px;
      width: 420px;
      height: 420px;
      background: radial-gradient(circle, rgba(74,144,217,0.12) 0%, transparent 70%);
      pointer-events: none;
      z-index: 0;
    }
    .cart-section > * { position: relative; z-index: 1; }
    .cart-section .section-header {
      text-align: center;
      margin-bottom: 48px;
    }
    .cart-section .section-header h2 {
      font-family: 'Caveat', cursive;
      font-size: 2.8rem;
      color: #fff;
      letter-spacing: 2px;
      margin-bottom: 10px;
    }
    .cart-section .section-header p {
      color: #7eb8e0;
      font-size: 0.95rem;
      font-style: italic;
      letter-spacing: 0.5px;
      text-transform: capitalize;
    }

    /* Product grid */
    .products-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 28px;
      max-width: 1100px;
      margin: 0 auto 60px;
    }
    .product-card {
      background: #ffffff;
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 6px 24px rgba(0,0,0,0.3), 0 1px 4px rgba(0,0,0,0.15);
      transition: transform 0.22s, box-shadow 0.22s;
      cursor: pointer;
      border: 1px solid rgba(255,255,255,0.08);
    }
    .product-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 20px 48px rgba(0,0,0,0.4), 0 4px 12px rgba(74,144,217,0.2);
    }
    .product-card img {
      width: 100%;
      height: 230px;
      object-fit: cover;
      display: block;
      background: #dce3ef;
    }
    .product-info {
      padding: 16px 16px 20px;
      text-align: center;
    }
    .product-info h3 {
      font-size: 0.97rem;
      font-weight: 500;
      color: #1a1a2e;
      margin-bottom: 6px;
    }
    .product-info .price {
      color: #1a7f5a;
      font-size: 1.1rem;
      font-weight: 700;
    }
    .product-info .btn-remove {
      display: inline-block;
      margin-top: 10px;
      font-size: 0.78rem;
      color: #888;
      border: 1px solid #ddd;
      border-radius: 4px;
      padding: 4px 12px;
      cursor: pointer;
      background: none;
      transition: color 0.2s, border-color 0.2s;
    }
    .product-info .btn-remove:hover { color: #c0392b; border-color: #c0392b; }

    /* ── ORDER SUMMARY ── */
    .order-summary-wrap {
      max-width: 480px;
      margin: 0 auto;
    }
    .order-summary {
      background: rgba(255,255,255,0.97);
      border-radius: 16px;
      padding: 30px 28px;
      box-shadow: 0 8px 32px rgba(0,0,0,0.28), 0 1px 0 rgba(255,255,255,0.1);
      border: 1px solid rgba(255,255,255,0.15);
    }
    .order-summary h3 {
      font-family: 'Caveat', cursive;
      font-size: 1.6rem;
      color: #1a2444;
      margin-bottom: 20px;
      border-bottom: 2px solid #eef0f7;
      padding-bottom: 12px;
    }
    .summary-row {
      display: flex;
      justify-content: space-between;
      font-size: 0.92rem;
      color: #444;
      margin-bottom: 10px;
    }
    .summary-row.total {
      font-weight: 700;
      font-size: 1.05rem;
      color: #1a2444;
      border-top: 2px solid #eef0f7;
      padding-top: 14px;
      margin-top: 8px;
    }
    .checkout-btn {
      display: block;
      width: 100%;
      margin-top: 22px;
      background: #1a2444;
      color: #fff;
      border: none;
      padding: 15px;
      border-radius: 8px;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      letter-spacing: 0.5px;
      transition: background 0.2s;
    }
    .checkout-btn:hover { background: #2e3f6f; }

    /* ── RESPONSIVE ── */
    @media (max-width: 860px) {
      .products-grid { grid-template-columns: repeat(2, 1fr); }
      .navbar nav { gap: 16px; }
    }
    @media (max-width: 580px) {
      .products-grid { grid-template-columns: 1fr; }
      .hero-content h1 { font-size: 2.2rem; }
      .navbar { padding: 0 16px; }
      .navbar nav { display: none; }
    }
  </style>
</head>
<body>

  <!-- ══════════════════════════════
       NAVBAR
  ══════════════════════════════ -->
  <header class="navbar">
    <a href="#" class="logo-block">
      <div class="logo-icon">
        <div class="at-badge">A↑</div>
        <div class="at-sub">ACCESS<br>TECH</div>
      </div>
      <span class="logo-text">Access<span>Tech</span></span>
    </a>

    <nav>
      <a href="Home.html">Home</a>
      <a href="Products.html">Products</a>
      <a href="About Us.html">About Us</a>
      <a href="Support.html">Support</a>
      <a href="Carts&Checkout.html" class="active">Cart&Checkout</a>
      <a href="Join Our Community">Join Our Community</a>
    </nav>

    <button class="btn-submit">Submit</button>
  </header>

  <!-- ══════════════════════════════
       HERO
  ══════════════════════════════ -->
  <section class="hero">
    <!-- Payment / checkout scene background -->
    <img
      class="hero-bg"
      src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=1400&q=80"
      alt="Person completing a purchase at checkout"
      onerror="this.src='https://images.unsplash.com/photo-1563013544-824ae1b704d3?w=1400&q=80'"
    />
    <div class="hero-content">
      <h1>Complete Your Purchase</h1>
      <p>Review your selected products and proceed seamlessly to payment</p>
      <a href="#cart" class="btn-hero">Go to Cart ↓</a>
    </div>
  </section>

  <!-- ══════════════════════════════
       SHOPPING CART SECTION
  ══════════════════════════════ -->
  <section class="cart-section" id="cart">

    <div class="section-header">
      <h2>Your Shopping Cart</h2>
      <p>Verify the items you've chosen before finalizing your order</p>
    </div>

    <!-- Product Cards -->
    <div class="products-grid">

      <!-- Card 1: Wireless Bluetooth Headphones -->
      <div class="product-card">
        <img
          src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=600&q=80"
          alt="Wireless Bluetooth Headphones"
          onerror="this.src='https://images.unsplash.com/photo-1484704849700-f032a568e944?w=600&q=80'"
        />
        <div class="product-info">
          <h3>Wireless Bluetooth Headphones</h3>
          <span class="price">$59.00</span><br/>
          <button class="btn-remove">Remove</button>
        </div>
      </div>

      <!-- Card 2: Smart LED Display Monitor -->
      <div class="product-card">
        <img
          src="https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?w=600&q=80"
          alt="Smart LED Display Monitor"
          onerror="this.src='https://images.unsplash.com/photo-1593640408182-31c228b556e1?w=600&q=80'"
        />
        <div class="product-info">
          <h3>Smart LED Display Monitor</h3>
          <span class="price">$180.00</span><br/>
          <button class="btn-remove">Remove</button>
        </div>
      </div>

      <!-- Card 3: Portable Power Bank -->
      <div class="product-card">
        <img
          src="https://images.unsplash.com/photo-1585338107954-d7a9e56c0d17?w=600&q=80"
          alt="Portable Power Bank 20000mAh"
          onerror="this.src='https://images.unsplash.com/photo-1618366712010-f4ae9c647dcb?w=600&q=80'"
        />
        <div class="product-info">
          <h3>Portable Power Bank 20000mAh</h3>
          <span class="price">$45.00</span><br/>
          <button class="btn-remove">Remove</button>
        </div>
      </div>

    </div>

    <!-- Order Summary -->
    <div class="order-summary-wrap">
      <div class="order-summary">
        <h3>Order Summary</h3>
        <div class="summary-row"><span>Wireless Headphones</span><span>$59.00</span></div>
        <div class="summary-row"><span>LED Monitor</span><span>$180.00</span></div>
        <div class="summary-row"><span>Power Bank 20000mAh</span><span>$45.00</span></div>
        <div class="summary-row"><span>Shipping</span><span>Free</span></div>
        <div class="summary-row total"><span>Total</span><span>$284.00</span></div>
        <button class="checkout-btn">✔ Proceed to Checkout</button>
      </div>
    </div>

  </section>

</body>
</html>
