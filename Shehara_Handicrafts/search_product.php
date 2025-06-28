<!--connect file-->
<?php
include('includes/connect.php');
include('functions/common_function.php');
session_start();
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sheara Handicrafts</title>
  <!--boostrapt CSS file-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
  <!--font awesome link-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!--css file-->
  <link rel="stylesheet" href="style.css">
  <style>
    /* Modern Beautiful First Child Section (copy from display_all.php or index.php) */
    .modern-navbar {
      background: linear-gradient(90deg, #fff 0%, #f8fafc 100%);
      border-radius: 2rem;
      box-shadow: 0 6px 32px rgba(102, 16, 242, 0.07);
      padding: 0.7rem 0;
      margin-bottom: 1.5rem;
      position: relative;
      z-index: 10;
    }

    .modern-navbar .logo {
      height: 56px;
      border-radius: 16px;
      margin-right: 20px;
      box-shadow: 0 2px 12px rgba(13, 202, 240, 0.10);
      transition: transform 0.18s;
    }

    .modern-navbar .logo:hover {
      transform: scale(1.09) rotate(-2deg);
      box-shadow: 0 4px 18px rgba(13, 202, 240, 0.18);
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
      box-shadow: 0 2px 8px rgba(102, 16, 242, 0.10);
    }

    .modern-navbar .fa-cart-shopping {
      color: #0dcaf0;
      margin-right: 2px;
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

    /* Add any other modern styles you want from display_all.php */
    /* ... */
  </style>
</head>

<body>
  <!-- navbar -->
  <div class="container-fluid p-0">
    <!-- first child -->
    <nav class="navbar navbar-expand-lg modern-navbar mb-2">
      <div class="container-fluid">
        <img src="./images/logo.jpg" alt="" class="logo">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="display_all.php">Products</a>
            </li>
            <li class="nav-item">
              <?php
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
              <a class="nav-link" href="contact.php">Contact</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="cart.php"><i class="fa-solid fa-cart-shopping"></i><sup><?php cart_item(); ?></sup></a>
              </a>
            </li>
            <!-- <li class="nav-item">
              <a class="nav-link" href="#">Total Price: <?php total_cart_price(); ?>/-</a>
            </li> -->
          </ul>
          <form class="d-flex" action="search_product.php" method="get">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search_data">
            <input type="submit" value="Search" class="btn btn-outline-light" name="search_data_product">
          </form>
        </div>
      </div>
    </nav>

    <!--calling cart function-->
    <?php cart(); ?>

    <!--second child-->
    <section class="modern-userbar-section my-3">
      <div class="container-fluid px-4">
        <div class="modern-userbar d-flex flex-column flex-md-row align-items-center justify-content-between gap-3 py-3 px-4 rounded-4 shadow">
          <div class="d-flex align-items-center gap-3">
            <div class="userbar-avatar d-flex align-items-center justify-content-center rounded-circle me-2">
              <i class="fa fa-user-circle fa-2x"></i>
            </div>
            <div>
              <?php
              if (!isset($_SESSION['username'])) {
                echo "<span class='userbar-welcome gradient-text fw-bold fs-5'>Welcome Guest</span>";
              } else {
                echo "<span class='userbar-welcome gradient-text fw-bold fs-5'>Welcome " . htmlspecialchars($_SESSION['username']) . "</span>";
              }
              ?>
            </div>
          </div>
          <div>
            <?php
            if (!isset($_SESSION['username'])) {
              echo "<a class='btn btn-modern-cta btn-userbar px-4 py-2' href='./users_area/user_login.php'><i class='fa fa-sign-in-alt me-2'></i>Login</a>";
            } else {
              echo "<a class='btn btn-modern-cta btn-userbar px-4 py-2' href='./users_area/logout.php'><i class='fa fa-sign-out-alt me-2'></i>Logout</a>";
            }
            ?>
          </div>
        </div>
      </div>
    </section>

    <!--third child-->
    <header class="modern-header-section mb-4">
      <div class="container py-5">
        <div class="row align-items-center">
          <div class="col-lg-7 text-lg-start text-center mb-4 mb-lg-0">
            <h1 class="display-4 fw-bold mb-3 modern-header-title">
              <span class="gradient-text">Shehara Handicrafts</span>
              <span class="d-inline-block ms-2"><i class="fa-solid fa-gift"></i></span>
            </h1>
            <p class="lead modern-header-desc mb-4">
              Discover unique, handcrafted treasures made with love and tradition.<br>
              <span class="fw-semibold text-primary">Feel the story in every piece.</span>
            </p>
            <a href="display_all.php" class="btn btn-modern-cta px-4 py-2 me-2 mb-2">
              <i class="fa fa-store me-2"></i>Shop Now
            </a>
            <a href="#categories" class="btn btn-outline-modern-cta px-4 py-2 mb-2">
              <i class="fa fa-layer-group me-2"></i>Browse Categories
            </a>
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

    <!--fourth child-->
    <div class="row px-1">
      <div class="col-md-10">
        <!--products-->
        <div class="row text-center">
          <?php
          // Show products by search or by category
          if (isset($_GET['category_id'])) {
            $category_id = intval($_GET['category_id']);
            $get_products = "SELECT * FROM products WHERE categories_category_id = $category_id AND status='true'";
            $result = mysqli_query($con, $get_products);
            if (mysqli_num_rows($result) == 0) {
              echo "<h4 class='text-center my-4'>No products found in this category.</h4>";
            }
            while ($row = mysqli_fetch_assoc($result)) {
              $product_id = $row['product_id'];
              $product_title = $row['product_title'];
              $product_image = $row['product_image'];
              $product_price = $row['product_price'];
              $product_quantity = $row['product_quantity'];

              // Highlight low stock products
              $quantity_class = $product_quantity < 5 ? 'text-danger' : 'text-success';

              // Fetch average rating and review count
              $review_sql = "SELECT AVG(rating) as avg_rating, COUNT(*) as review_count FROM product_reviews WHERE product_id = $product_id AND status = 'approved'";
              $review_result = mysqli_query($con, $review_sql);
              $review_data = mysqli_fetch_assoc($review_result);
              $avg_rating = $review_data['avg_rating'] ? round($review_data['avg_rating'], 1) : 0;
              $review_count = $review_data['review_count'];

              // Modern beautiful card design with reviews
              echo "
              <div class='col-md-4 mb-4'>
                  <div class='card product-modern-card h-100 border-0 shadow-lg rounded-4 position-relative overflow-hidden'>
                      <div class='product-img-wrapper'>
                        <img src='./admin area/$product_image' class='card-img-top rounded-top-4' alt='$product_title'>";
              if ($product_quantity < 5) {
                echo "<span class='badge bg-danger position-absolute top-0 end-0 m-3 px-3 py-2 fs-6 shadow'>Low Stock</span>";
              }
              echo "
                      </div>
                      <div class='card-body d-flex flex-column'>
                          <h5 class='card-title fw-bold mb-2 text-gradient'>$product_title</h5>
                          <p class='card-text text-primary fs-5 mb-1'>Rs. $product_price/-</p>
                          <span class='card-text $quantity_class mb-2'>Stock: $product_quantity</span>
                          <div class='mb-2'>
                            <span class='text-warning'>";
              // Display stars
              for ($i = 1; $i <= 5; $i++) {
                if ($i <= floor($avg_rating)) {
                  echo "<i class='fa fa-star'></i>";
                } elseif ($i - $avg_rating < 1) {
                  echo "<i class='fa fa-star-half-alt'></i>";
                } else {
                  echo "<i class='fa-regular fa-star'></i>";
                }
              }
              echo "</span>
                            <span class='ms-1 text-muted small'>($avg_rating / 5, $review_count review" . ($review_count == 1 ? "" : "s") . ")</span>
                          </div>";
              // Disable "Add to Cart" button if quantity is 0
              if ($product_quantity > 0) {
                  $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
                  $ip_address = getIPAddress();
                  $check_cart_query = "SELECT * FROM cart_details WHERE products_product_id = $product_id AND user_table_user_id = $user_id AND ip_address = '$ip_address'";
                  $check_cart_result = mysqli_query($con, $check_cart_query);
                  if (mysqli_num_rows($check_cart_result) > 0) {
                      echo "<a href='cart.php' class='btn btn-modern-cart mt-auto w-100'>
                              <i class='fa fa-shopping-cart me-2'></i>View Cart
                            </a>";
                  } else {
                      echo "<a href='search_product.php?add_to_cart=$product_id' class='btn btn-modern-cart mt-auto w-100'>
                              <i class='fa fa-cart-plus me-2'></i>Add to Cart
                            </a>";
                  }
              } else {
                  echo "<button class='btn btn-secondary mt-auto w-100' disabled>Out of Stock</button>";
              }
              $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
              echo "
                        <a href='http://localhost:5000/product_reviews?product_id=$product_id&user_id=$user_id' class='btn btn-outline-modern-cta mt-2 w-100'>
                          <i class='fa fa-comments me-2'></i>View Reviews / Add Review
                        </a>
                      </div>
                  </div>
              </div>";
            }
          } else {
            // Default: search or show all
            search_product();
            get_unique_categories();
          }
          ?>
        </div>
      </div>
      <div class="col-md-2 bg-secondary p-0 category-modern-sidebar">
        <!--sidenav-->
        <div class="category-beautiful-box py-4 px-2 h-100 d-flex flex-column align-items-center">
          <div class="category-header-beautiful mb-4 w-100 text-center rounded-4 shadow-sm py-3 px-2">
            <h4 class="mb-0" style="font-size:1.5rem;letter-spacing:0.03em;">
              <i class="fa-solid fa-layer-group me-2"></i>Categories
            </h4>
          </div>
          <ul class="navbar-nav w-100">
            <?php
            // Custom category links for search by category
            $cat_query = "SELECT * FROM categories";
            $cat_result = mysqli_query($con, $cat_query);
            while ($cat_row = mysqli_fetch_assoc($cat_result)) {
              $cat_id = $cat_row['category_id'];
              $cat_title = $cat_row['category_title'];
              echo "<li class='nav-item'>
                      <a class='nav-link' href='search_product.php?category_id=$cat_id'>$cat_title</a>
                    </li>";
            }
            ?>
          </ul>
        </div>
      </div>
    </div>

    <!--last child(footer)-->
    <footer class="footer-modern mt-5">
      <div class="container py-4">
        <div class="row align-items-center">
          <div class="col-md-6 text-md-start text-center mb-2 mb-md-0">
            <span class="fw-bold fs-5 text-gradient">Shehara Handicrafts</span>
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
  </div>
  <!--boostrapt js file-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>