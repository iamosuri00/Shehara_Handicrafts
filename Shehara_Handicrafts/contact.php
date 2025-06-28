<?php
// ...existing includes if needed...
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Contact Us - Shehara Handicrafts</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <style>
    body { background: #f8fafc; }
    .modern-header-section {
      background: linear-gradient(120deg, #f8fafc 60%, #e3e6f3 100%);
      border-radius: 2rem;
      box-shadow: 0 6px 32px rgba(102,16,242,0.07);
      margin-bottom: 2rem;
      position: relative;
      overflow: hidden;
    }
    .modern-header-title {
      font-size: 2.2rem;
      letter-spacing: 0.04em;
      line-height: 1.1;
    }
    .gradient-text {
      background: linear-gradient(90deg, #0dcaf0 0%, #6610f2 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    .modern-header-img-wrapper {
      position: relative;
      z-index: 1;
    }
    .modern-header-img {
      width: 120px;
      height: 120px;
      object-fit: cover;
      border-radius: 2rem;
      border: 6px solid #fff;
      position: relative;
      z-index: 2;
    }
    .modern-header-img-bg {
      position: absolute;
      top: 50%;
      left: 50%;
      width: 140px;
      height: 140px;
      background: radial-gradient(circle, #0dcaf0 0%, #6610f2 100%);
      opacity: 0.13;
      border-radius: 50%;
      transform: translate(-50%, -50%);
      z-index: 1;
    }
    .contact-card {
      background: #fff;
      border-radius: 1.5rem;
      box-shadow: 0 8px 32px rgba(102,16,242,0.10), 0 1.5px 6px rgba(13,202,240,0.08);
      padding: 2.5rem 2rem;
      margin: 0 auto;
      max-width: 900px;
    }
    .contact-section-title {
      font-size: 1.5rem;
      font-weight: 600;
      color: #6610f2;
      margin-bottom: 1.2rem;
      letter-spacing: 0.03em;
    }
    .contact-detail-icon {
      font-size: 1.5rem;
      color: #0dcaf0;
      margin-right: 0.7rem;
    }
    .footer-modern {
      background: linear-gradient(90deg, #0dcaf0 0%, #6610f2 100%);
      color: #fff;
      border-radius: 2rem 2rem 0 0;
      box-shadow: 0 -2px 24px rgba(102,16,242,0.10);
      font-size: 1.08em;
      letter-spacing: 0.02em;
      margin-top: 3rem;
    }
    .footer-link {
      color: #fff;
      font-size: 1.3em;
      transition: color 0.18s, transform 0.18s;
      display: inline-block;
    }
    .footer-link:hover {
      color: #ffe082;
      transform: scale(1.15) rotate(-8deg);
      text-decoration: none;
    }
    @media (max-width: 767px) {
      .modern-header-section { border-radius: 0.7rem; }
      .modern-header-title { font-size: 1.3rem; }
      .modern-header-img { width: 70px; height: 70px; }
      .modern-header-img-bg { width: 80px; height: 80px; }
      .contact-card { padding: 1.2rem 0.7rem; }
    }
  </style>
</head>
<body>
  <!-- navbar (first child section from index.php) -->
  <div class="container-fluid p-0">
    <nav class="navbar navbar-expand-lg modern-navbar mb-2">
      <div class="container-fluid">
        <img src="./images/logo.jpg" alt="" class="logo">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="display_all.php">Products</a>
            </li>
            <li class="nav-item">
              <?php
              session_start();
              if (isset($_SESSION['username'])) {
              ?>
                <a class="nav-link" href="./users_area/profile.php">My Account</a>
              <?php
              } else {
              ?>
                <a class="nav-link" href="./users_area/user_login.php">Login</a>
              <?php
              }
              ?>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="contact.php">Contact</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="cart.php"><i class="fa-solid fa-cart-shopping"></i><sup><?php if(function_exists('cart_item')) cart_item(); ?></sup></a>
              </a>
            </li>
          </ul>
          <form class="d-flex" action="search_product.php" method="get">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search_data">
            <input type="submit" value="Search" class="btn btn-outline-light" name="search_data_product">
          </form>
        </div>
      </div>
    </nav>
  </div>
  <!-- Modern header -->
  <header class="modern-header-section mb-4">
    <div class="container py-4">
      <div class="row align-items-center">
        <div class="col-lg-7 text-lg-start text-center mb-4 mb-lg-0">
          <h1 class="fw-bold mb-3 modern-header-title">
            <span class="gradient-text">Contact Us</span>
            <span class="d-inline-block ms-2"><i class="fa-solid fa-envelope"></i></span>
          </h1>
          <p class="lead modern-header-desc mb-0">
            We're here to help! Reach out to us for any inquiries, feedback, or support.
          </p>
        </div>
        <div class="col-lg-5 text-center">
          <div class="modern-header-img-wrapper d-inline-block">
            <img src="./images/logo.jpg" alt="Handicrafts" class="modern-header-img shadow-lg rounded-4">
            <div class="modern-header-img-bg"></div>
          </div>
        </div>
      </div>
    </div>
  </header>

  <main>
    <div class="contact-card mb-5">
      <div class="row">
        <div class="col-md-6 mb-4 mb-md-0 d-flex flex-column justify-content-center">
          <div class="contact-section-title">About Shehara Handicrafts</div>
          <p>
            Shehara Handicrafts is dedicated to bringing you the finest handcrafted products, blending tradition with modern design. Our artisans pour their passion and skill into every piece, ensuring quality and uniqueness.
          </p>
          <div class="contact-section-title mt-4">Our Vision</div>
          <p>
            To be the leading platform for authentic Sri Lankan handicrafts, empowering local artisans and sharing their stories with the world.
          </p>
          <div class="contact-section-title mt-4">Our Mission</div>
          <p>
            To preserve and promote traditional craftsmanship, deliver exceptional value to our customers, and support sustainable livelihoods for artisan communities.
          </p>
          <div class="mt-4 d-none d-md-block">
            <img src="images/l2.png" alt="Artisans at work" class="img-fluid rounded-4 shadow" style="max-height:180px;object-fit:cover;">
          </div>
        </div>
        <div class="col-md-6">
          <div class="mb-4">
            <img src="images/l1.jpg" alt="Handicraft Display" class="img-fluid rounded-4 shadow mb-3" style="width:100%;max-height:180px;object-fit:cover;">
          </div>
          <div class="contact-section-title">Contact Details</div>
          <ul class="list-unstyled mb-4">
            <li class="mb-3"><i class="fa fa-map-marker-alt contact-detail-icon"></i>123, Main Street, Colombo, Sri Lanka</li>
            <li class="mb-3"><i class="fa fa-phone contact-detail-icon"></i>+94 77 123 4567</li>
            <li class="mb-3"><i class="fa fa-envelope contact-detail-icon"></i>info@sheharahandicrafts.lk</li>
            <li class="mb-3"><i class="fab fa-whatsapp contact-detail-icon"></i>+94 77 123 4567</li>
            <li class="mb-3"><i class="fab fa-facebook contact-detail-icon"></i> <a href="#" class="text-decoration-none">/SheharaHandicrafts</a></li>
            <li class="mb-3"><i class="fab fa-instagram contact-detail-icon"></i> <a href="#" class="text-decoration-none">@shehara_handicrafts</a></li>
          </ul>
          <div class="contact-section-title">Business Hours</div>
          <p>Monday - Saturday: 9:00 AM - 6:00 PM<br>Sunday: Closed</p>
          <div class="mt-4 d-none d-md-block">
            <img src="images/l3.webp" alt="Handicraft Gallery" class="img-fluid rounded-4 shadow" style="max-height:120px;object-fit:cover;">
          </div>
        </div>
      </div>
    </div>
  </main>

  <footer class="footer-modern mt-5">
    <div class="container py-4">
      <div class="row align-items-center">
        <div class="col-md-6 text-md-start text-center mb-2 mb-md-0">
          <span class="fw-bold fs-5 gradient-text">Shehara Handicrafts</span>
          <span class="ms-2 text-light small">| Crafted with passion &amp; tradition</span>
        </div>
        <div class="col-md-6 text-md-end text-center">
          <a href="#" class="footer-link mx-2"><i class="fab fa-facebook-f"></i></a>
          <a href="#" class="footer-link mx-2"><i class="fab fa-instagram"></i></a>
          <a href="#" class="footer-link mx-2"><i class="fab fa-whatsapp"></i></a>
          <span class="ms-3 text-light small">&copy; <?php echo date('Y'); ?> All rights reserved.</span>
        </div>
      </div>
    </div>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
</body>
</html>
