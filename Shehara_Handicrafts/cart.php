<!--connect file-->
<?php
include('includes/connect.php');
include('functions/common_function.php');
session_start();

// Restrict access to logged-in users
if (!isset($_SESSION['username'])) {
  echo "<script>alert('Please log in to access the cart.');</script>";
  echo "<script>window.location.href = './users_area/user_login.php';</script>";
  exit();
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sheara Handicrafts-Cart Details</title>
  <!--boostrapt CSS file-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
  <!--font awesome link-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!--css file-->
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      overflow-x: hidden;
    }

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

    .modern-userbar-section {
      background: none;
    }

    .modern-userbar {
      background: linear-gradient(90deg, #f8fafc 60%, #e3e6f3 100%);
      border-radius: 1.5rem;
      box-shadow: 0 2px 16px rgba(102, 16, 242, 0.07);
      min-height: 64px;
      transition: box-shadow 0.18s;
    }

    .modern-userbar:hover {
      box-shadow: 0 4px 24px rgba(102, 16, 242, 0.13);
    }

    .userbar-avatar {
      width: 48px;
      height: 48px;
      background: linear-gradient(135deg, #0dcaf0 0%, #6610f2 100%);
      color: #fff;
      font-size: 2rem;
      box-shadow: 0 2px 8px rgba(13, 202, 240, 0.10);
    }

    .userbar-welcome {
      font-size: 1.18rem;
      letter-spacing: 0.03em;
      display: flex;
      align-items: center;
    }

    .btn-userbar {
      border-radius: 2rem;
      font-weight: 600;
      letter-spacing: 0.02em;
      box-shadow: 0 2px 8px rgba(13, 202, 240, 0.08);
      font-size: 1.08rem;
    }

    @media (max-width: 767px) {
      .modern-userbar {
        border-radius: 1rem;
        min-height: 48px;
        padding: 1rem 0.5rem;
        flex-direction: column !important;
        gap: 1rem !important;
      }

      .userbar-avatar {
        width: 38px;
        height: 38px;
        font-size: 1.3rem;
      }

      .userbar-welcome {
        font-size: 1rem;
      }
    }

    .footer-modern {
      background: linear-gradient(90deg, #0dcaf0 0%, #6610f2 100%);
      color: #fff;
      border-radius: 2rem 2rem 0 0;
      box-shadow: 0 -2px 24px rgba(102, 16, 242, 0.10);
      font-size: 1.08em;
      letter-spacing: 0.02em;
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

    @media (max-width: 767px) {
      .footer-modern {
        border-radius: 1.2rem 1.2rem 0 0;
        font-size: 1em;
        padding: 1.2rem 0;
      }
    }

    /* Cart Table Modern */
    .modern-cart-table {
      background: #fff;
      border-radius: 1.5rem;
      box-shadow: 0 4px 24px rgba(102, 16, 242, 0.08);
      overflow: hidden;
    }

    .modern-cart-table th {
      background: linear-gradient(90deg, #0dcaf0 0%, #6610f2 100%);
      color: #fff;
      font-weight: 600;
      border: none;
      font-size: 1.1rem;
      letter-spacing: 0.03em;
    }

    .modern-cart-table td {
      vertical-align: middle;
      font-size: 1.08rem;
      border: none;
      background: #f8fafc;
    }

    .modern-cart-table tr {
      border-bottom: 1px solid #e3e6f3;
    }

    .modern-cart-table tr:last-child {
      border-bottom: none;
    }

    .cart_img {
      width: 80px;
      height: 80px;
      object-fit: contain;
      border-radius: 1rem;
      box-shadow: 0 2px 8px rgba(13, 202, 240, 0.08);
      background: #fff;
    }

    .quantity-control {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 0.3rem;
    }

    .quantity-control .btn {
      border-radius: 50%;
      width: 32px;
      height: 32px;
      font-size: 1.1rem;
      background: linear-gradient(90deg, #0dcaf0 0%, #6610f2 100%);
      color: #fff;
      border: none;
      transition: background 0.18s, color 0.18s;
    }

    .quantity-control .btn:disabled {
      background: #e3e6f3;
      color: #aaa;
    }

    .quantity-value {
      font-weight: 600;
      font-size: 1.1rem;
      color: #6610f2;
      margin: 0 6px;
    }

    .modern-cart-actions .btn,
    .modern-cart-actions button {
      border-radius: 2rem;
      font-weight: 600;
      letter-spacing: 0.02em;
      font-size: 1.08rem;
      margin-right: 0.5rem;
      margin-bottom: 0.5rem;
      box-shadow: 0 2px 8px rgba(13, 202, 240, 0.08);
      border: none;
      padding: 10px 28px;
    }

    .modern-cart-actions .bg-info {
      background: linear-gradient(90deg, #0dcaf0 0%, #6610f2 100%) !important;
      color: #fff !important;
    }

    .modern-cart-actions .bg-info:hover {
      background: linear-gradient(90deg, #6610f2 0%, #0dcaf0 100%) !important;
      color: #fff !important;
    }

    .modern-cart-actions .bg-danger {
      background: linear-gradient(90deg, #ff416c 0%, #ff4b2b 100%) !important;
      color: #fff !important;
    }

    .modern-cart-actions .bg-danger:hover {
      background: linear-gradient(90deg, #ff4b2b 0%, #ff416c 100%) !important;
      color: #fff !important;
    }

    .modern-cart-actions .bg-secondary {
      background: linear-gradient(90deg, #6610f2 0%, #0dcaf0 100%) !important;
      color: #fff !important;
    }

    .modern-cart-actions .bg-secondary:hover {
      background: linear-gradient(90deg, #0dcaf0 0%, #6610f2 100%) !important;
      color: #fff !important;
    }
  </style>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Include jQuery -->
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
    <?php
    cart();
    ?>
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

    <!--fourth child-table-->
    <div class="container">
      <div class="row">
        <form action="" method="post">
          <table class="table table-bordered text-center modern-cart-table">
            <thead>
              <tr>
                <th>Product Title</th>
                <th>Product Image</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Remove</th>
              </tr>
            </thead>
            <tbody>
              <!--php code to display dynamic data -->
              <?php
              $get_ip_add = getIPAddress();
              $total_price = 0;

              $cart_query = "SELECT cd.*, p.product_title, p.product_image, p.product_price, p.product_quantity 
                             FROM cart_details cd 
                             JOIN products p ON cd.products_product_id = p.product_id 
                             WHERE cd.ip_address = '$get_ip_add' AND p.status='true'";
              $result = mysqli_query($con, $cart_query);

              while ($row = mysqli_fetch_array($result)) {
                $product_id = $row['products_product_id'];
                $current_quantity = $row['quantity'];
                $product_title = $row['product_title'];
                $product_image = $row['product_image'];
                $product_price = $row['product_price'];
                $stock_quantity = $row['product_quantity'];
                $subtotal = $product_price * $current_quantity;
                $total_price += $subtotal;

                // Highlight low stock products
                $quantity_class = $stock_quantity < 5 ? 'text-danger' : 'text-success';
              ?>
                <tr>
                  <td><?php echo $product_title ?></td>
                  <td><img src="./admin area/<?php echo $product_image ?>" alt="" class="cart_img"></td>
                  <td>
                    <div class="quantity-control" data-product-id="<?php echo $product_id ?>">
                      <button type="button" class="btn decrement-btn" <?php echo $stock_quantity == 0 ? 'disabled' : ''; ?>>-</button>
                      <span class="quantity-value"><?php echo $current_quantity ?></span>
                      <button type="button" class="btn increment-btn" <?php echo $current_quantity >= $stock_quantity ? 'disabled' : ''; ?>>+</button>
                      <p class="<?php echo $quantity_class; ?>">Stock: <?php echo $stock_quantity; ?></p>
                    </div>
                  </td>
                  <td class="subtotal"><?php echo $subtotal ?>/-</td>
                  <td><input type="checkbox" name="removeitem[]" value="<?php echo $product_id ?>"></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
          <!--subtotal-->
          <div class="d-flex mb-5 modern-cart-actions flex-wrap align-items-center">
            <h4 class="px-3">Subtotal:<strong class="text-info" id="total-price"><?php echo $total_price ?>/-</strong></h4>
            <a href="index.php">
              <button type="button" class="bg-info">Continue Shopping</button>
            </a>

            <?php
            // Only show checkout and remove buttons if cart is not empty
            if ($total_price > 0) {
              echo "
              <button type='submit' name='remove_cart' class='bg-danger'>Remove Selected</button>
              <a href='checkout.php'>
                <button type='button' class='bg-secondary text-light'>Chekout</button>
              </a>
              ";
            }
            ?>
          </div>
        </form>
        <!--function to remove item -->
        <?php
        if (isset($_POST['remove_cart'])) {
          if (!empty($_POST['removeitem'])) {
            foreach ($_POST['removeitem'] as $remove_id) {
              $delete_query = "DELETE FROM cart_details WHERE products_product_id = $remove_id";
              $run_delete = mysqli_query($con, $delete_query);
            }
            if ($run_delete) {
              echo "<script>window.open('cart.php', '_self')</script>";
            }
          } else {
            echo "<script>alert('No items selected to remove.');</script>";
          }
        }
        ?>
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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>

  <script>
    $(document).ready(function() {
      // Handle increment and decrement buttons
      $('.increment-btn').on('click', function() {
        const $control = $(this).closest('.quantity-control');
        const productId = $control.data('product-id');
        const $quantityValue = $control.find('.quantity-value');
        const $stockInfo = $control.find('p');
        const stockQuantity = parseInt($stockInfo.text().split(': ')[1]);
        let quantity = parseInt($quantityValue.text());

        if (quantity < stockQuantity) {
          quantity++;
          $quantityValue.text(quantity);

          // Disable increment button if reaching stock limit
          if (quantity >= stockQuantity) {
            $(this).prop('disabled', true);
          }
          // Enable decrement button
          $control.find('.decrement-btn').prop('disabled', false);

          updateQuantity(productId, quantity, $control);
        } else {
          alert('Cannot add more items. Stock limit reached!');
        }
      });

      $('.decrement-btn').on('click', function() {
        const $control = $(this).closest('.quantity-control');
        const productId = $control.data('product-id');
        const $quantityValue = $control.find('.quantity-value');
        let quantity = parseInt($quantityValue.text());

        if (quantity > 1) {
          quantity--;
          $quantityValue.text(quantity);

          // Enable increment button
          $control.find('.increment-btn').prop('disabled', false);

          updateQuantity(productId, quantity, $control);
        } else {
          alert('Quantity must be at least 1.');
        }
      });

      function updateQuantity(productId, quantity, $control) {
        const $row = $control.closest('tr');
        const $stockInfo = $control.find('p');
        const stockQuantity = parseInt($stockInfo.text().split(': ')[1]);

        // Check if quantity exceeds stock
        if (quantity > stockQuantity) {
          alert('Cannot add more items. Stock limit reached!');
          return;
        }

        $.ajax({
          url: 'update_cart_quantity.php',
          method: 'POST',
          data: {
            product_id: productId,
            quantity: quantity
          },
          success: function(response) {
            const data = JSON.parse(response);
            if (data.success) {
              // Update subtotal and total price
              $row.find('.subtotal').text(data.subtotal + '/-');
              $('#total-price').text(data.total_price + '/-');

              // Update stock display
              if (data.stock_quantity !== undefined) {
                $stockInfo.text('Stock: ' + data.stock_quantity);
                if (data.stock_quantity < 5) {
                  $stockInfo.removeClass('text-success').addClass('text-danger');
                } else {
                  $stockInfo.removeClass('text-danger').addClass('text-success');
                }
              }
            } else {
              alert(data.message || 'Failed to update quantity.');
            }
          },
          error: function() {
            alert('Error updating quantity. Please try again.');
          }
        });
      }
    });
  </script>
</body>

</html>