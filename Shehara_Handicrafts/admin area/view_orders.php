<?php
include('../includes/connect.php');

// Restrict access to logged-in admins
if (!isset($_SESSION['admin_username'])) {
    echo "<script>alert('Please log in as admin to access this page.');</script>";
    echo "<script>window.location.href = 'admin_login.php';</script>";
    exit();
}
?>
<div class="container my-4">
  <div class="card shadow rounded-4 p-4">
    <h3 class="text-center text-gradient mb-4">All Orders</h3>
    <div class="table-responsive">
      <table class="table modern-table align-middle mb-0">
        <thead>
          <tr>
            <th class="bg-gradient-primary text-white">#</th>
            <th class="bg-gradient-primary text-white">User ID</th>
            <th class="bg-gradient-primary text-white">Total Price</th>
            <th class="bg-gradient-primary text-white">Billing Name</th>
            <th class="bg-gradient-primary text-white">Order Date</th>
            <th class="bg-gradient-primary text-white">Payment Status</th>
            <th class="bg-gradient-primary text-white">View Details</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $get_orders = "SELECT * FROM orders ORDER BY order_date DESC";
          $result = mysqli_query($con, $get_orders);
          $number = 0;

          // Handle order delete request
          if (isset($_POST['delete_order_id'])) {
              $delete_order_id = mysqli_real_escape_string($con, $_POST['delete_order_id']);
              // Delete order items first
              mysqli_query($con, "DELETE FROM order_items WHERE order_order_id='$delete_order_id'");
              // Then delete the order
              $delete_result = mysqli_query($con, "DELETE FROM orders WHERE order_id='$delete_order_id'");
              if ($delete_result) {
                  echo "<script>window.location.href=window.location.href;</script>";
                  exit();
              } else {
                  echo "<div class='alert alert-danger'>Failed to delete order. Please try again.</div>";
              }
          }

          while ($row = mysqli_fetch_assoc($result)) {
              $order_id = $row['order_id'];
              $user_id = $row['user_table_user_id'];
              $total_price = $row['total_price'];
              $billing_name = $row['billing_name'];
              $order_date = $row['order_date'];
              $payment_status = $row['payment_status'];
              $number++;
              $status_badge = $payment_status === 'Paid'
                ? "<span class='badge bg-success bg-opacity-75 px-3 py-2'>Paid</span>"
                : "<span class='badge bg-warning text-dark bg-opacity-75 px-3 py-2'>$payment_status</span>";
              echo "
              <tr>
                  <td class='fw-bold text-gradient'>$number</td>
                  <td>$user_id</td>
                  <td>Rs. $total_price/-</td>
                  <td>$billing_name</td>
                  <td>$order_date</td>
                  <td>$status_badge</td>
                  <td>
                    <button type='button' class='btn btn-outline-primary btn-sm toggle-details' data-target='order{$order_id}'><i class='fa-solid fa-eye'></i> View</button>
                    <form method='post' style='display:inline;' onsubmit=\"return confirm('Are you sure you want to delete this order?');\">
                      <input type='hidden' name='delete_order_id' value='$order_id'>
                      <button type='submit' class='btn btn-outline-danger btn-sm'><i class='fa fa-trash'></i></button>
                    </form>
                  </td>
              </tr>
              <tr class='order-details-row' id='order{$order_id}' style='display:none;'>
                <td colspan='7'>
                  <strong>Billing Name:</strong> $billing_name<br>
                  <strong>Order Date:</strong> $order_date<br>
                  <strong>User ID:</strong> $user_id<br>
                  <strong>Total Price:</strong> Rs. $total_price/-<br>
                  <strong>Status:</strong> $payment_status<br>
                  <!-- Add more details as needed -->
                </td>
              </tr>
              ";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.toggle-details').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var targetId = this.getAttribute('data-target');
      var row = document.getElementById(targetId);
      if (row.style.display === 'none' || row.style.display === '') {
        row.style.display = 'table-row';
        this.innerHTML = "<i class='fa-solid fa-eye-slash'></i> Hide";
      } else {
        row.style.display = 'none';
        this.innerHTML = "<i class='fa-solid fa-eye'></i> View";
      }
    });
  });
});
</script>
