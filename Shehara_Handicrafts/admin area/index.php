<!----connect file--->
<?php
session_start();
include('../includes/connect.php');

// Restrict access to logged-in admins
if (!isset($_SESSION['admin_username'])) {
    echo "<script>alert('Please log in as admin to access this page.');</script>";
    echo "<script>window.location.href = 'admin_login.php';</script>";
    exit();
}
include('../functions/common_function.php');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!--bootstrap css link-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">

    <!-- font awesome link-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!--css file-->
    <link rel="stylesheet" href="../style.css">
    <style>
.admin_image{
  width:100px;
  object-fit:contain;
}
.footer{
    position:absolute;
    bottom:0;
}
body{
    overflow-x:hidden;
    
}
.product_img{
   width :10%;
   object-fit:contain;
}
      .modern-navbar {
        background: linear-gradient(90deg, #fff 0%, #f8fafc 100%);
        border-radius: 2rem;
        box-shadow: 0 6px 32px rgba(102,16,242,0.07);
        padding: 0.7rem 0;
        margin-bottom: 1.5rem;
        position: relative;
        z-index: 10;
      }
      .modern-navbar .logo {
        height: 56px;
        border-radius: 16px;
        margin-right: 20px;
        box-shadow: 0 2px 12px rgba(13,202,240,0.10);
        transition: transform 0.18s;
      }
      .modern-navbar .logo:hover {
        transform: scale(1.09) rotate(-2deg);
        box-shadow: 0 4px 18px rgba(13,202,240,0.18);
      }
      .modern-navbar .navbar-nav .nav-link {
        color: #6610f2 !important;
        font-weight: 600;
        letter-spacing: 0.03em;
        border-radius: 1.2rem;
        margin-right: 6px;
        transition: background 0.18s, color 0.18s;
        padding: 10px 22px !important;
        font-size: 1.08rem;
      }
      .modern-navbar .navbar-nav .nav-link.active,
      .modern-navbar .navbar-nav .nav-link:hover {
        background: linear-gradient(90deg, #0dcaf0 0%, #6610f2 100%);
        color: #fff !important;
        box-shadow: 0 2px 8px rgba(102,16,242,0.10);
      }
      .modern-navbar .btn-outline-light {
        border-radius: 2rem;
        border: 1.5px solid #6610f2;
        color: #6610f2;
        font-weight: 500;
        background: #fff;
        transition: background 0.18s, color 0.18s, border 0.18s;
      }
      .modern-navbar .btn-outline-light:hover,
      .modern-navbar .btn-outline-light:focus {
        background: linear-gradient(90deg, #0dcaf0 0%, #6610f2 100%);
        color: #fff;
        border-color: #0dcaf0;
      }
      .modern-navbar .form-control[type="search"] {
        border-radius: 2rem;
        border: 1.5px solid #e3e6f3;
        background: #f8fafc;
        color: #6610f2;
        transition: background 0.18s, border 0.18s, color 0.18s;
      }
      .modern-navbar .form-control[type="search"]:focus {
        background: #fff;
        color: #222;
        border: 1.5px solid #6610f2;
      }
      @media (max-width: 991px) {
        .modern-navbar {
          border-radius: 1rem;
          padding: 0.5rem 0;
        }
        .modern-navbar .logo {
          height: 38px;
        }
        .modern-navbar .navbar-nav .nav-link {
          padding: 8px 12px !important;
          font-size: 1rem;
        }
      }
        </style>
</head>
<body>
    <!--navbar-->
    <div class="container-fluid p-0">
        <!--first child-->
        <nav class="navbar navbar-expand-lg modern-navbar mb-2">
            <div class="container-fluid">
              <img src="../images/logo.jpg" alt="" class="logo">
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar" aria-controls="adminNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="adminNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                  <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Dashboard</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="index.php?view_products">Products</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="index.php?view_categories">Categories</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="index.php?view_orders">Orders</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="index.php?view_users">Users</a>
                  </li>
                </ul>
                <span class="navbar-text fw-bold text-gradient me-3">
                  <i class="fa fa-user-shield me-2"></i>Welcome <?php echo htmlspecialchars($_SESSION["admin_username"]); ?>
                </span>
                <a href="logout.php" class="btn btn-modern-cta px-4 py-2">Logout</a>
              </div>
            </div>
        </nav>

        <!-- Modern header -->
        <header class="modern-header-section mb-4">
          <div class="container py-4">
            <div class="row align-items-center">
              <div class="col-lg-7 text-lg-start text-center mb-4 mb-lg-0">
                <h1 class="fw-bold mb-3 modern-header-title">
                  <span class="gradient-text">Admin Dashboard</span>
                  <span class="d-inline-block ms-2"><i class="fa-solid fa-user-shield"></i></span>
                </h1>
                <p class="lead modern-header-desc mb-0">
                  Manage products, categories, orders, and users for Shehara Handicrafts.
                </p>
              </div>
              <div class="col-lg-5 text-center">
                <div class="modern-header-img-wrapper d-inline-block">
                  <img src="../images/logo.jpg" alt="Handicrafts" class="modern-header-img shadow-lg rounded-4">
                  <div class="modern-header-img-bg"></div>
                </div>
              </div>
            </div>
          </div>
        </header>

        <!--third child-->
        <div class="container my-3">
          <div class="row g-4">
            <div class="col-12 col-lg-3">
              <div class="card shadow rounded-4 p-3 h-100 admin-sidebar">
                <div class="text-center mb-3">
                  <img src="../images/admin.png" alt="" class="admin_image rounded-circle shadow mb-2" style="width:90px;height:90px;">
                  <div class="fw-bold text-gradient fs-5"><?php echo htmlspecialchars($_SESSION["admin_username"]); ?></div>
                </div>
                <div class="d-grid gap-2">
                  <a href="insert_product.php" class="btn btn-modern-cta mb-2"><i class="fa fa-plus me-2"></i>Insert Products</a>
                  <a href="index.php?view_products" class="btn btn-outline-modern-cta mb-2">View Products</a>
                  <a href="index.php?insert_category" class="btn btn-modern-cta mb-2"><i class="fa fa-plus me-2"></i>Insert Categories</a>
                  <a href="index.php?view_categories" class="btn btn-outline-modern-cta mb-2">View Categories</a>
                  <a href="index.php?view_orders" class="btn btn-outline-modern-cta mb-2">All Orders</a>
                  <a href="index.php?view_users" class="btn btn-outline-modern-cta mb-2">List Users</a>
                  <a href="logout.php" class="btn btn-danger mb-2">Log Out</a>
                </div>
              </div>
            </div>
            <div class="col-12 col-lg-9">
              <div class="admin-content-area">
                <?php  
                if (isset($_GET['insert_category'])) {
                    include('insert_categories.php');
                }
                if (isset($_GET['view_products'])) {
                    include('view_products.php');
                }
                if (isset($_GET['edit_products'])) {
                    include('edit_products.php');
                }
                if (isset($_GET['delete_product'])) {
                    include('delete_product.php');
                }
                if (isset($_GET['view_categories'])) {
                    include('view_categories.php');
                }
                if (isset($_GET['view_orders'])) {
                    include('view_orders.php');
                }
                if (isset($_GET['view_users'])) {
                    include('view_users.php');
                }
                ?>
              </div>
            </div>
          </div>
        </div>

        <!--last child(footer)-->
        <footer class="footer-modern mt-5">
          <div class="container py-4">
            <div class="row align-items-center">
              <div class="col-md-6 text-md-start text-center mb-2 mb-md-0">
                <span class="fw-bold fs-5 text-gradient">Shehara Handicrafts</span>
                <span class="ms-2 text-light small">| Admin Panel</span>
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
    </div>

    <style>
      .admin-sidebar {
        background: linear-gradient(120deg, #f8fafc 60%, #e3e6f3 100%);
        border-radius: 1.5rem;
        min-height: 400px;
      }
      .admin-content-area {
        min-height: 400px;
      }
      .btn-modern-cta {
        background: linear-gradient(90deg, #0dcaf0 0%, #6610f2 100%);
        color: #fff;
        border: none;
        font-weight: 600;
        border-radius: 2rem;
        box-shadow: 0 2px 8px rgba(13,202,240,0.10);
        transition: box-shadow 0.18s, transform 0.18s;
      }
      .btn-modern-cta:hover, .btn-modern-cta:focus {
        background: linear-gradient(90deg, #6610f2 0%, #0dcaf0 100%);
        color: #fff;
        box-shadow: 0 4px 16px rgba(102,16,242,0.14);
        transform: translateY(-2px) scale(1.03);
      }
      .btn-outline-modern-cta {
        background: transparent;
        color: #6610f2;
        border: 2px solid #6610f2;
        font-weight: 600;
        border-radius: 2rem;
        transition: background 0.18s, color 0.18s, border 0.18s, transform 0.18s;
      }
      .btn-outline-modern-cta:hover, .btn-outline-modern-cta:focus {
        background: #6610f2;
        color: #fff;
        border-color: #6610f2;
        transform: translateY(-2px) scale(1.03);
      }
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
      .footer-modern {
        background: linear-gradient(90deg, #0dcaf0 0%, #6610f2 100%);
        color: #fff;
        border-radius: 2rem 2rem 0 0;
        box-shadow: 0 -2px 24px rgba(102,16,242,0.10);
        font-size: 1.08em;
        letter-spacing: 0.02em;
        margin-top: 3rem;
      }
      .footer-modern .text-gradient {
        background: linear-gradient(90deg, #ffe082 0%, #fff 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
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
      .footer-modern .small {
        opacity: 0.85;
      }
      @media (max-width: 991px) {
        .modern-navbar {
          border-radius: 1rem;
          padding: 0.5rem 0;
        }
        .modern-navbar .logo {
          height: 38px;
        }
        .modern-navbar .navbar-nav .nav-link {
          padding: 8px 12px !important;
          font-size: 1rem;
        }
        .admin-sidebar {
          margin-bottom: 2rem;
        }
      }
      @media (max-width: 767px) {
        .modern-header-section { border-radius: 0.7rem; }
        .modern-header-title { font-size: 1.3rem; }
        .modern-header-img { width: 70px; height: 70px; }
        .modern-header-img-bg { width: 80px; height: 80px; }
        .admin-sidebar { border-radius: 1rem; }
      }
    </style>
    <!--bootstrap js link-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>