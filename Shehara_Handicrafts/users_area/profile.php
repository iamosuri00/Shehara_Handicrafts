<!--connect file-->
<?php
include('../includes/connect.php');
include('../functions/common_function.php');
session_start();

// Check if user is NOT logged in, then redirect to login
if (!isset($_SESSION["username"])) {
  echo "<script>window.open('./user_login.php','_self')</script>";
  exit();
}
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
  <link rel="stylesheet" href="../style.css">
  <style>
    body {
      overflow-x: hidden;
    }

    .modern-header-section {
      background: linear-gradient(120deg, #f8fafc 60%, #e3e6f3 100%);
      border-radius: 2rem;
      box-shadow: 0 6px 32px rgba(102, 16, 242, 0.07);
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

    .profile-sidebar {
      background: linear-gradient(180deg, #6610f2 0%, #0dcaf0 100%);
      border-radius: 1.5rem 0 0 1.5rem;
      box-shadow: 0 2px 16px rgba(102, 16, 242, 0.07);
      min-height: 100vh;
      padding-top: 2rem;
      padding-bottom: 2rem;
    }

    .profile_img {
      width: 90%;
      margin: 1.5rem auto 1rem auto;
      display: block;
      height: 120px;
      object-fit: cover;
      border-radius: 1rem;
      box-shadow: 0 2px 8px rgba(13, 202, 240, 0.08);
      background: #fff;
    }

    .profile-sidebar .nav-link {
      color: #fff !important;
      font-weight: 500;
      border-radius: 8px;
      padding: 10px 0;
      background: rgba(255, 255, 255, 0.04);
      margin: 0 4px 10px 4px;
      transition: background 0.18s, color 0.18s, transform 0.18s;
    }

    .profile-sidebar .nav-link:hover,
    .profile-sidebar .nav-link.active {
      background: #ffe082;
      color: #6610f2 !important;
      transform: scale(1.04);
      font-weight: 600;
    }

    .profile-sidebar .nav-item.bg-info {
      background: linear-gradient(90deg, #0dcaf0 0%, #6610f2 100%) !important;
      color: #fff !important;
      border-radius: 1rem !important;
      margin-bottom: 1.5rem;
      box-shadow: 0 2px 8px rgba(13, 202, 240, 0.10);
    }

    .profile-sidebar .nav-item.bg-info h4 {
      color: #fff !important;
      font-weight: 700;
      letter-spacing: 0.03em;
    }

    .footer-modern {
      background: linear-gradient(90deg, #0dcaf0 0%, #6610f2 100%);
      color: #fff;
      border-radius: 2rem 2rem 0 0;
      box-shadow: 0 -2px 24px rgba(102, 16, 242, 0.10);
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
      .profile-sidebar {
        border-radius: 1rem 1rem 0 0;
        min-height: auto;
      }

      .profile_img {
        height: 80px;
      }
    }

    @media (max-width: 767px) {
      .modern-header-section {
        border-radius: 0.7rem;
      }

      .modern-header-title {
        font-size: 1.3rem;
      }

      .modern-header-img {
        width: 70px;
        height: 70px;
      }

      .modern-header-img-bg {
        width: 80px;
        height: 80px;
      }
    }
  </style>

</head>

<body>
  <!-- first child: Modern Navbar -->
  <nav class="navbar navbar-expand-lg modern-navbar mb-2">
    <div class="container-fluid">
      <img src="../images/logo.jpg" alt="" class="logo">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="../index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../display_all.php">Products</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="profile.php">My Account</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../contact.php">Contact</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../cart.php"><i class="fa-solid fa-cart-shopping"></i><sup><?php cart_item(); ?></sup></a>
          </li>
        </ul>
        <form class="d-flex" action="../search_product.php" method="get">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search_data">
          <input type="submit" value="Search" class="btn btn-outline-light" name="search_data_product">
        </form>
      </div>
    </div>
  </nav>
  <!-- Modern header -->
  <header class="modern-header-section mb-4">
    <div class="container py-4">
      <div class="row align-items-center">
        <div class="col-lg-7 text-lg-start text-center mb-4 mb-lg-0">
          <h1 class="fw-bold mb-3 modern-header-title">
            <span class="gradient-text">My Profile</span>
            <span class="d-inline-block ms-2"><i class="fa-solid fa-user"></i></span>
          </h1>
          <p class="lead modern-header-desc mb-0">
            Welcome to your profile dashboard! Manage your account, orders, and more.
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
  <!-- Profile layout -->
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-2 profile-sidebar d-flex flex-column align-items-center">
        <ul class="navbar-nav w-100 text-center">
          <li class="nav-item bg-info">
            <a class="nav-link text-light" href="#">
              <h4>Your Profile</h4>
            </a>
          </li>
          <?php
          $user_id = $_SESSION['user_id'];
          $user_image_query = "SELECT * FROM user_table WHERE user_id='$user_id'";
          $user_image_result = mysqli_query($con, $user_image_query);
          $row_image = mysqli_fetch_array($user_image_result);
          $user_image = $row_image['user_image'];
          ?>
          <li class="nav-item">
            <img src='../users_area/<?php echo htmlspecialchars($user_image); ?>' 
                 class='profile_img my-4 rounded-circle shadow border border-3 border-primary'
                 alt='Profile Image'
                 style="width: 140px; height: 140px; object-fit: cover; background: #fff; box-shadow: 0 4px 24px rgba(13,202,240,0.15);">
          </li>
          <li class="nav-item">
            <a class="nav-link" href="profile.php?edit_account">Edit Account</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="profile.php?my_orders">Orders History</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="profile.php?delete_account">Delete Account</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
          </li>
        </ul>
      </div>
      <div class="col-md-10 text-center">
        <?php
        // Include the appropriate file based on the query parameter
        if (isset($_GET['edit_account'])) {
          include('edit_account.php');
        }

        if (isset($_GET['delete_account'])) {
            // Check if user has items in cart
            $check_cart_query = "SELECT * FROM cart_details WHERE user_table_user_id = '$user_id'";
            $check_cart_result = mysqli_query($con, $check_cart_query);
            
            if (mysqli_num_rows($check_cart_result) > 0) {
                echo "<div class='alert alert-warning'>
                    <h4>Cannot Delete Account</h4>
                    <p>You have items in your cart. Please clear your cart before deleting your account.</p>
                    <a href='../cart.php' class='btn btn-primary'>Go to Cart</a>
                </div>";
            } else {
                // Confirm deletion
                echo "
                <div class='alert alert-danger'>
                    <h3>Are you sure you want to delete your account?</h3>
                    <p class='text-muted'>This action cannot be undone. All your data will be permanently deleted.</p>
                    <form method='post'>
                        <button type='submit' name='confirm_delete' class='btn btn-danger'>Yes, Delete Account</button>
                        <a href='profile.php' class='btn btn-secondary'>Cancel</a>
                    </form>
                </div>
                ";

                // Handle account deletion
                if (isset($_POST['confirm_delete'])) {
                    // Start transaction
                    mysqli_begin_transaction($con);
                    
                    try {
                        // Get all orders by this user
                        $get_orders = "SELECT order_id FROM orders WHERE user_table_user_id = '$user_id'";
                        $orders_result = mysqli_query($con, $get_orders);
                        
                        if (!$orders_result) {
                            throw new Exception("Error fetching orders: " . mysqli_error($con));
                        }
                        
                        // Delete order items for each order
                        while ($order = mysqli_fetch_assoc($orders_result)) {
                            $order_id = $order['order_id'];
                            $delete_order_items = mysqli_query($con, "DELETE FROM order_items WHERE order_order_id = '$order_id'");
                            if (!$delete_order_items) {
                                throw new Exception("Error deleting order items: " . mysqli_error($con));
                            }
                        }
                        
                        // Delete orders
                        $delete_orders = mysqli_query($con, "DELETE FROM orders WHERE user_table_user_id = '$user_id'");
                        if (!$delete_orders) {
                            throw new Exception("Error deleting orders: " . mysqli_error($con));
                        }
                        
                        // Delete product reviews
                        $delete_reviews = mysqli_query($con, "DELETE FROM product_reviews WHERE user_id = '$user_id'");
                        if (!$delete_reviews) {
                            throw new Exception("Error deleting reviews: " . mysqli_error($con));
                        }
                        
                        // Delete cart items
                        $delete_cart = mysqli_query($con, "DELETE FROM cart_details WHERE user_table_user_id = '$user_id'");
                        if (!$delete_cart) {
                            throw new Exception("Error deleting cart items: " . mysqli_error($con));
                        }
                        
                        // Finally delete the user
                        $delete_user = mysqli_query($con, "DELETE FROM user_table WHERE user_id = '$user_id'");
                        if (!$delete_user) {
                            throw new Exception("Error deleting user: " . mysqli_error($con));
                        }
                        
                        // Commit transaction
                        mysqli_commit($con);
                        
                        // Clear session and redirect
                        session_destroy();
                        echo "<script>alert('Your account has been deleted successfully.');</script>";
                        echo "<script>window.location.href = '../index.php';</script>";
                    } catch (Exception $e) {
                        // Rollback transaction on error
                        mysqli_rollback($con);
                        
                        // Log the error
                        error_log("Account deletion error for user $user_id: " . $e->getMessage());
                        
                        // Show error message
                        echo "<div class='alert alert-danger'>
                            <h4>Error Deleting Account</h4>
                            <p>There was a problem deleting your account. Please try again later.</p>
                            <p class='text-muted small'>Error: " . htmlspecialchars($e->getMessage()) . "</p>
                        </div>";
                    }
                }
            }
        }

        if (isset($_GET['my_orders'])) {
          include('my_orders.php');
        }
        ?>
      </div>
    </div>
  </div>
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
  <!--boostrapt js file-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>

</html>