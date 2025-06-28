<?php
include('../includes/connect.php');
include('../functions/common_function.php');

if (!isset($_SESSION["username"])) {
  echo "<script>window.open('./user_login.php','_self')</script>";
  exit();
}
$user_id = $_SESSION['user_id'];
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Order History - Shehara Handicrafts</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
  <link rel="stylesheet" href="../style.css">
  <style>
    /* ...copy the same styles from profile.php for header, sidebar, etc... */
    body { overflow-x: hidden; }
    .modern-header-section { background: linear-gradient(120deg, #f8fafc 60%, #e3e6f3 100%); border-radius: 2rem; box-shadow: 0 6px 32px rgba(102, 16, 242, 0.07); margin-bottom: 2rem; position: relative; overflow: hidden; }
    .modern-header-title { font-size: 2.2rem; letter-spacing: 0.04em; line-height: 1.1; }
    .gradient-text { background: linear-gradient(90deg, #0dcaf0 0%, #6610f2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
    .modern-header-img-wrapper { position: relative; z-index: 1; }
    .modern-header-img { width: 120px; height: 120px; object-fit: cover; border-radius: 2rem; border: 6px solid #fff; position: relative; z-index: 2; }
    .modern-header-img-bg { position: absolute; top: 50%; left: 50%; width: 140px; height: 140px; background: radial-gradient(circle, #0dcaf0 0%, #6610f2 100%); opacity: 0.13; border-radius: 50%; transform: translate(-50%, -50%); z-index: 1; }
    .profile-sidebar { background: linear-gradient(180deg, #6610f2 0%, #0dcaf0 100%); border-radius: 1.5rem 0 0 1.5rem; box-shadow: 0 2px 16px rgba(102, 16, 242, 0.07); min-height: 100vh; padding-top: 2rem; padding-bottom: 2rem; }
    .profile_img { width: 90%; margin: 1.5rem auto 1rem auto; display: block; height: 120px; object-fit: cover; border-radius: 1rem; box-shadow: 0 2px 8px rgba(13, 202, 240, 0.08); background: #fff; }
    .profile-sidebar .nav-link { color: #fff !important; font-weight: 500; border-radius: 8px; padding: 10px 0; background: rgba(255, 255, 255, 0.04); margin: 0 4px 10px 4px; transition: background 0.18s, color 0.18s, transform 0.18s; }
    .profile-sidebar .nav-link:hover, .profile-sidebar .nav-link.active { background: #ffe082; color: #6610f2 !important; transform: scale(1.04); font-weight: 600; }
    .profile-sidebar .nav-item.bg-info { background: linear-gradient(90deg, #0dcaf0 0%, #6610f2 100%) !important; color: #fff !important; border-radius: 1rem !important; margin-bottom: 1.5rem; box-shadow: 0 2px 8px rgba(13, 202, 240, 0.10); }
    .profile-sidebar .nav-item.bg-info h4 { color: #fff !important; font-weight: 700; letter-spacing: 0.03em; }
    /* ...add responsive styles as in profile.php... */
  </style>
</head>
<body>
  <!-- Modern header -->
  <header class="modern-header-section mb-4">
    <div class="container py-4">
      <div class="row align-items-center">
        <div class="col-lg-7 text-lg-start text-center mb-4 mb-lg-0">
          <h1 class="fw-bold mb-3 modern-header-title">
            <span class="gradient-text">Order History</span>
            <span class="d-inline-block ms-2"><i class="fa-solid fa-box"></i></span>
          </h1>
          <p class="lead modern-header-desc mb-0">
            View all your past orders and their details.
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
  <!-- Profile layout (sidebar + main) -->
  <div class="container-fluid">
    <div class="row">
      
      <div class="col-md-10 text-center">
        <h2 class="mb-4 gradient-text">Your Orders</h2>
        <?php
        // Handle order delete request
        if (isset($_POST['delete_order_id'])) {
          $delete_order_id = mysqli_real_escape_string($con, $_POST['delete_order_id']);
          // Delete order items first (to maintain referential integrity)
          mysqli_query($con, "DELETE FROM order_items WHERE order_order_id='$delete_order_id'");
          // Then delete the order
          $delete_result = mysqli_query($con, "DELETE FROM orders WHERE order_id='$delete_order_id' AND user_table_user_id='$user_id'");
          if ($delete_result) {
            echo "<div class='alert alert-success'>Order $delete_order_id deleted successfully.</div>";
          } else {
            echo "<div class='alert alert-danger'>Failed to delete order. Please try again.</div>";
          }
        }

        $orders_query = "SELECT * FROM orders WHERE user_table_user_id='$user_id' ORDER BY order_date DESC";
        $orders_result = mysqli_query($con, $orders_query);
        if (mysqli_num_rows($orders_result) > 0) {
          echo "<div class='table-responsive'><table class='table table-bordered table-hover align-middle'>
                  <thead class='table-primary'>
                    <tr>
                      <th>Order ID</th>
                      <th>Date</th>
                      <th>Total</th>
                      <th>Status</th>
                      <th>Details</th>
                      <th>Delete</th>
                    </tr>
                  </thead>
                  <tbody>";
          while ($order = mysqli_fetch_assoc($orders_result)) {
            $order_id = $order['order_id'];
            echo "<tr>
                    <td>{$order['order_id']}</td>
                    <td>" . date('Y-m-d', strtotime($order['order_date'])) . "</td>
                    <td>Rs. {$order['total_price']}/-</td>
                    <td>{$order['payment_status']}</td>
                    <td>
                      <button class='btn btn-outline-info btn-sm toggle-details' data-target='order{$order_id}'>View</button>
                    </td>
                    <td>
                      <form method='post' onsubmit=\"return confirm('Are you sure you want to delete this order?');\" style='display:inline;'>
                        <input type='hidden' name='delete_order_id' value='{$order['order_id']}'>
                        <button type='submit' class='btn btn-outline-danger btn-sm'><i class='fa fa-trash'></i></button>
                      </form>
                    </td>
                  </tr>
                  <tr class='order-details-row' id='order{$order_id}' style='display:none;'>
                    <td colspan='6'>
                      <strong>Billing Name:</strong> {$order['billing_name']}<br>
                      <strong>Billing Address:</strong> {$order['billing_address']}<br>
                      <strong>Billing Email:</strong> {$order['billing_email']}<br>
                      <strong>Billing Phone:</strong> {$order['billing_phone']}<br>
                      <strong>Items:</strong>
                      <ul class='list-unstyled'>";
            $items_query = "SELECT oi.*, p.product_title FROM order_items oi JOIN products p ON oi.products_product_id = p.product_id WHERE oi.order_order_id='$order_id'";
            $items_result = mysqli_query($con, $items_query);
            while ($item = mysqli_fetch_assoc($items_result)) {
              echo "<li>{$item['product_title']} x {$item['quantity']} (Rs. {$item['subtotal']}/-)</li>";
            }
            echo "      </ul>
                    </td>
                  </tr>";
          }
          echo "    </tbody>
                </table></div>";
        } else {
          echo "<div class='alert alert-info'>You have not placed any orders yet.</div>";
        }
        ?>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Toggle order details show/hide
    document.addEventListener('DOMContentLoaded', function () {
      document.querySelectorAll('.toggle-details').forEach(function (btn) {
        btn.addEventListener('click', function () {
          var targetId = this.getAttribute('data-target');
          var row = document.getElementById(targetId);
          if (row.style.display === 'none' || row.style.display === '') {
            row.style.display = 'table-row';
            this.textContent = 'Hide';
          } else {
            row.style.display = 'none';
            this.textContent = 'View';
          }
        });
      });
    });
  </script>
</body>
</html>
