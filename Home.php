<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>AccessTech</title>
  <style>
   
*, *::before, *::after {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: 'DM Sans', sans-serif;
  background: #000;
}

/* ===== NAVBAR ===== */
.navbar {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  z-index: 100;
  background: #0a0a0a;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 32px;
  height: 70px;
}

/* Brand / Logo */
.nav-brand {
  display: flex;
  align-items: center;
  gap: 12px;
  flex-shrink: 0;
}

.logo-box {
  background: #fff;
  border: 2px solid #ccc;
  padding: 4px 8px;
  display: flex;
  flex-direction: column;
  align-items: center;
  line-height: 1.1;
}

.logo-icon {
  font-size: 18px;
  font-weight: 700;
  color: #1a6bb5;
}

.logo-sub {
  font-size: 7px;
  font-weight: 600;
  color: #333;
  letter-spacing: 0.5px;
  white-space: nowrap;
}

.brand-name {
  font-size: 22px;
  font-weight: 700;
  color: #fff;
  letter-spacing: 2px;
  font-style: italic;
}

/* Nav Links */
.nav-links {
  list-style: none;
  display: flex;
  align-items: center;
  gap: 28px;
}

.nav-links a {
  text-decoration: none;
  color: #ccc;
  font-size: 14px;
  font-weight: 500;
  transition: color 0.2s;
}

.nav-links a:hover {
  color: #fff;
}

.nav-links a.active {
  color: #fff;
  text-decoration: underline;
  text-underline-offset: 4px;
}

/* Submit Button */
.btn-submit {
  background: #1a6bb5;
  color: #fff;
  border: none;
  padding: 10px 28px;
  font-size: 15px;
  font-weight: 600;
  border-radius: 4px;
  cursor: pointer;
  transition: background 0.2s;
  flex-shrink: 0;
}

.btn-submit:hover {
  background: #155a9a;
}

/* ===== HERO ===== */
.hero {
  position: relative;
  width: 100%;
  height: 100vh;
  min-height: 600px;
  background-image: url('https://images.unsplash.com/photo-1531297484001-80022131f5a1?w=1600&auto=format&fit=crop');
  background-size: cover;
  background-position: center;
  display: flex;
  align-items: flex-end;
  padding-bottom: 120px;
}

.hero-overlay {
  position: absolute;
  inset: 0;
  background: rgba(0, 0, 0, 0.45);
}

.hero-content {
  position: relative;
  z-index: 2;
  padding: 0 60px;
  max-width: 780px;
}

.hero-title {
  font-family: 'Bangers', cursive;
  font-size: clamp(52px, 7vw, 90px);
  color: #fff;
  line-height: 1.05;
  letter-spacing: 2px;
  text-shadow: 2px 3px 10px rgba(0,0,0,0.4);
  margin-bottom: 18px;
}

.hero-sub {
  font-size: 18px;
  color: #eee;
  font-weight: 400;
  margin-bottom: 36px;
  text-shadow: 1px 1px 6px rgba(0,0,0,0.5);
}

/* Shop Now Button */
.btn-shop {
  display: inline-block;
  background: #fff;
  color: #111;
  text-decoration: none;
  font-size: 16px;
  font-weight: 700;
  padding: 14px 40px;
  border-radius: 4px;
  transition: background 0.2s, color 0.2s;
}

.btn-shop:hover {
  background: #e8e8e8;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 900px) {
  .nav-links {
    gap: 16px;
  }

  .nav-links a {
    font-size: 12px;
  }
}

@media (max-width: 700px) {
  .nav-links {
    display: none;
  }

  .hero-content {
    padding: 0 28px;
  }
}

  </style>
  <link rel="stylesheet" href="style.css" />
  <link href="https://fonts.googleapis.com/css2?family=Bangers&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet"/>
</head>
<body>


  <nav class="navbar">
    <div class="nav-brand">
      <div class="logo-box">
        <span class="logo-icon">A↗</span>
        <span class="logo-sub">Access TECH</span>
      </div>
      <span class="brand-name">ACCESSTECH</span>
    </div>
    <ul class="nav-links">
     <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>AccessTech – Cart & Checkout</title>
  <link rel="stylesheet" href="cart-style.css" />
  <link href="https://fonts.googleapis.com/css2?family=IM+Fell+English:ital@0;1&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>
</head>
<body>

  <!-- ===== NAVBAR ===== -->
  <nav class="navbar">
    <div class="nav-brand">
      <div class="logo-box">
        <span class="logo-icon">A↗</span>
        <span class="logo-sub">Access TECH</span>
      </div>
      <span class="brand-name">ACCESSTECH</span>
    </div>
    <ul class="nav-links">
      <li><a href="Home.html" class="active">Home</a></li>
      <li><a href="Products.html">Products</a></li>
      <li><a href="About Us.html">About Us</a></li>
      <li><a href="Support.html">Support</a></li>
      <li><a href="Carts&Checkout.html"> Carts&Checkout</a></li>
      <li><a href="Join Our Community.html">Join Our Community</a></li>
    </ul>
    <button class="btn-submit-nav">Submit</button>
  </nav>
        </thead>
          <tr class="cart-row">
            <td class="product-cell">
              <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=80&auto=format&fit=crop" alt="Smart Watch" />
              <span>Smart Watch Series 5</span>
            </td>
            <td>523,485 frw</td>
            <td>
              <div class="qty-wrap">
                <button class="qty-btn" onclick="changeQty(this,-1)">−</button>
                <input type="number" class="qty-input" value="1" min="1" />
                <button class="qty-btn" onclick="changeQty(this,1)">+</button>
              </div>
            </td>
            <td class="row-total">513,485 frw</td>
            <td><button class="btn-remove" onclick="removeRow(this)">✕</button></td>
          </tr>
        </tbody>
      </table>
    <button class="btn-submit">Submit</button>
  </nav>
  <section class="hero">
    <div class="hero-overlay"></div>
    <div class="hero-content">
      <h1 class="hero-title">Access the Latest Electronics</h1>
      <p class="hero-sub">Discover a wide range of electronic devices for every need</p>
      <a href="#" class="btn-shop">Shop Now</a>
    </div>
  </section>

</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>AccessTech – Featured Electronics</title>
  <style>

*, *::before, *::after {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: 'DM Sans', sans-serif;
  background: #141c2e;
}


.featured-section {
  background: #141c2e;
  padding: 70px 48px 80px;
  text-align: center;
}

.featured-title {
  font-family: 'IM Fell English', serif;
  font-style: italic;
  font-size: clamp(32px, 4vw, 56px);
  color: #fff;
  margin-bottom: 16px;
  letter-spacing: 0.5px;
}

.featured-sub {
  font-family: 'IM Fell English', serif;
  font-style: italic;
  font-size: 16px;
  color: #b0bdd4;
  letter-spacing: 0.4px;
  margin-bottom: 52px;
}

.products-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 0;
  border: 1px solid #3a4560;
  border-right: none;
  border-bottom: none;
}


.product-card {
  background: #1e2840;
  border-right: 1px solid #3a4560;
  border-bottom: 1px solid #3a4560;
  overflow: hidden;
  cursor: pointer;
}


.card-img-wrap {
  position: relative;
  width: 100%;
  height: 420px;
  overflow: hidden;
}

.card-img-wrap img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
  transition: transform 0.4s ease;
  filter: brightness(0.82);
}

.product-card:hover .card-img-wrap img {
  transform: scale(1.04);
  filter: brightness(0.65);
}

.card-img-wrap::after {
  content: 'VIEW PRODUCT';
  position: absolute;
  inset: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #fff;
  font-size: 13px;
  font-weight: 700;
  letter-spacing: 2px;
  background: rgba(0, 0, 0, 0.35);
  opacity: 0;
  transition: opacity 0.3s ease;
}

.product-card:hover .card-img-wrap::after {
  opacity: 1;
}

.card-info {
  padding: 20px 20px 24px;
  text-align: left;
  background: #1e2840;
}

.card-name {
  font-size: 15px;
  font-weight: 400;
  color: #d0d8ea;
  margin-bottom: 8px;
  line-height: 1.4;
}

.card-price {
  font-size: 18px;
  font-weight: 700;
  color: #2d72d9;
}

@media (max-width: 900px) {
  .products-grid {
    grid-template-columns: repeat(2, 1fr);
  }

  .card-img-wrap {
    height: 280px;
  }
}

@media (max-width: 560px) {
  .products-grid {
    grid-template-columns: 1fr;
  }

  .featured-section {
    padding: 48px 20px 60px;
  }

  .card-img-wrap {
    height: 240px;
  }
}

  </style>
  <link rel="stylesheet" href="featured-style.css" />
  <link href="https://fonts.googleapis.com/css2?family=IM+Fell+English:ital@0;1&family=DM+Sans:wght@400;600;700&display=swap" rel="stylesheet"/>
</head>
<body>


  <section class="featured-section">
    <h2 class="featured-title">Our Featured Electronics</h2>
    <p class="featured-sub">Discover top-rated gadgets and devices selected for quality and popularity.</p>

    <div class="products-grid">

      <div class="product-card">
        <div class="card-img-wrap">
          <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=600&auto=format&fit=crop" alt="Wireless Headphones" />
        </div>
        <div class="card-info">
          <p class="card-name">Wireless Noise-Canceling Headphones</p>
          <p class="card-price">292,787 frw</p>
        </div>
      </div>

   
      <div class="product-card">
        <div class="card-img-wrap">
          <img src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=600&auto=format&fit=crop" alt="Smartphone X200" />
        </div>
        <div class="card-info">
          <p class="card-name">Smartphone X200</p>
          <p class="card-price">1,023,360 frw</p>
        </div>
      </div>

    
      <div class="product-card">
        <div class="card-img-wrap">
          <img src="https://images.unsplash.com/photo-1593784991095-a205069470b6?w=600&auto=format&fit=crop" alt="4K Ultra HD Smart TV" />
        </div>
        <div class="card-info">
          <p class="card-name">4K Ultra HD Smart TV</p>
          <p class="card-price">1,322690 frw</p>
        </div>
      </div>

      
      <div class="product-card">
        <div class="card-img-wrap">
          <img src="https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=600&auto=format&fit=crop" alt="Laptop Pro" />
        </div>
        <div class="card-info">
          <p class="card-name">Laptop Pro 15" – Core i7</p>
          <p class="card-price">1,249.00 frw</p>
        </div>
      </div>

      
      <div class="product-card">
        <div class="card-img-wrap">
          <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=600&auto=format&fit=crop" alt="Smart Watch" />
        </div>
        <div class="card-info">
          <p class="card-name">Smart Watch Series 5</p>
          <p class="card-price">510,936 frw</p>
        </div>
      </div>


      <div class="product-card">
        <div class="card-img-wrap">
          <img src="https://images.unsplash.com/photo-1585386959984-a4155224a1ad?w=600&auto=format&fit=crop" alt="Wireless Earbuds" />
        </div>
        <div class="card-info">
          <p class="card-name">True Wireless Earbuds</p>
          <p class="card-price">189,796 frw</p>
        </div>
      </div>

    </div>
  </section>

</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>AccessTech – Committed to Excellence</title>
</head>
  <link rel="stylesheet" href="excellence-style.css" />
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>
</head>
<body>

  <!-- ===== SPLIT SECTION ===== -->
  <section class="split-section">

    <!-- LEFT: Full image -->
    <div class="split-image">
      <img
        src="https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=1000&auto=format&fit=crop"
        alt="Laptop on desk"
      />
    </div>

    <!-- RIGHT: Text panel -->
    <div class="split-content">
      <h2 class="split-title">Committed to Excellence</h2>
      <p class="split-desc">
        At AccessTech, we prioritize quality, security, and customer satisfaction
        to ensure a trusted shopping experience for all users.
      </p>
      <a href="#" class="btn-learn">Learn More</a>
    </div>

  </section>

</body>
</html>

  <link rel="stylesheet" href="excellence-style.css" />
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>
</head>
<body>

  <!-- ===== SPLIT SECTION ===== -->
  <section class="split-section">

    <!-- LEFT: Full image -->
    <div class="split-image">
      <img
        src="https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=1000&auto=format&fit=crop"
        alt="Laptop on desk"
      />
    </div>

    <!-- RIGHT: Text panel -->
    <div class="split-content">
      <h2 class="split-title">Committed to Excellence</h2>
      <p class="split-desc">
        At AccessTech, we prioritize quality, security, and customer satisfaction
        to ensure a trusted shopping experience for all users.
      </p>
      <a href="#" class="btn-learn">Learn More</a>
    </div>

  </section>

</body>
</html>
