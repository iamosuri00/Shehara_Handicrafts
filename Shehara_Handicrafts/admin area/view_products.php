<?php
include('../includes/connect.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Restrict access to logged-in admins
if (!isset($_SESSION['admin_username'])) {
    echo "<script>alert('Please log in as admin to access this page.');</script>";
    echo "<script>window.location.href = 'admin_login.php';</script>";
    exit();
}

// Handle activate/deactivate actions
if (isset($_GET['toggle_status']) && isset($_GET['product_id'])) {
    $product_id = intval($_GET['product_id']);
    $new_status = ($_GET['toggle_status'] === 'activate') ? 'true' : 'false';
    mysqli_query($con, "UPDATE products SET status='$new_status' WHERE product_id='$product_id'");
    echo "<script>window.location.href='http://localhost/shehara%20handicrafts/admin%20area/index.php?view_products';</script>";
    exit();
}

// Handle delete product
if (isset($_GET['delete_product'])) {
    $product_id = intval($_GET['delete_product']);
    
    // Start transaction
    mysqli_begin_transaction($con);
    
    try {
        // Delete related records first
        mysqli_query($con, "DELETE FROM order_items WHERE products_product_id = $product_id");
        mysqli_query($con, "DELETE FROM product_reviews WHERE product_id = $product_id");
        mysqli_query($con, "DELETE FROM cart_details WHERE products_product_id = $product_id");
        // Delete the product
        mysqli_query($con, "DELETE FROM products WHERE product_id = $product_id");
        
        // Commit transaction
        mysqli_commit($con);
        
        echo "<script>alert('Product deleted successfully!');</script>";
    } catch (Exception $e) {
        // Rollback transaction on error
        mysqli_rollback($con);
        echo "<script>alert('Error deleting product: " . $e->getMessage() . "');</script>";
    }
    
    echo "<script>window.location.href='http://localhost/shehara%20handicrafts/admin%20area/index.php?view_products';</script>";
    exit();
}
?>
<div class="container my-4">
  <div class="card shadow rounded-4 p-4">
    <h3 class="text-center text-gradient mb-4">All Products</h3>
    <div class="table-responsive">
      <table class="table modern-table align-middle mb-0">
        <thead>
          <tr>
            <th class="bg-gradient-primary text-white">#</th>
            <th class="bg-gradient-primary text-white">Product Title</th>
            <th class="bg-gradient-primary text-white">Image</th>
            <th class="bg-gradient-primary text-white">Price</th>
            <th class="bg-gradient-primary text-white">Quantity</th>
            <th class="bg-gradient-primary text-white">Status</th>
            <th class="bg-gradient-primary text-white">Edit</th>
            <th class="bg-gradient-primary text-white">Delete</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $get_products = "SELECT * FROM products";
          $result = mysqli_query($con, $get_products);
          $number = 0;
          while ($row = mysqli_fetch_assoc($result)) {
              $product_id = $row['product_id'];
              $product_title = $row['product_title'];
              $product_image = $row['product_image'];
              $product_price = $row['product_price'];
              $product_quantity = $row['product_quantity'];
              $status = $row['status'];
              $number++;
              $status_badge = $status === 'true'
                ? "<span class='badge bg-success bg-opacity-75 px-3 py-2'>Active</span>"
                : "<span class='badge bg-danger bg-opacity-75 px-3 py-2'>Inactive</span>";
              echo "
              <tr>
                  <td class='fw-bold text-gradient'>$number</td>
                  <td>$product_title</td>
                  <td><img src='../admin area/$product_image' class='product_img rounded shadow' style='width: 70px; height: 70px; object-fit:cover;'/></td>
                  <td>LKR $product_price.00</td>
                  <td>$product_quantity</td>
                  <td>$status_badge</td>
                  <td><a href='edit_product.php?product_id=$product_id' class='btn btn-outline-success btn-sm'><i class='fa-solid fa-pen-to-square'></i></a></td>
                  <td><a href='view_products.php?delete_product=$product_id' class='btn btn-outline-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this product?\");'><i class='fa-solid fa-trash'></i></a></td>
              </tr>
              ";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>