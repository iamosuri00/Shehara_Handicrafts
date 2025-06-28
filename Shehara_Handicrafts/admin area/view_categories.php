<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include('../includes/connect.php');

// Restrict access to logged-in admins
if (!isset($_SESSION['admin_username'])) {
    echo "<script>alert('Please log in as admin to access this page.');</script>";
    echo "<script>window.location.href = 'admin_login.php';</script>";
    exit();
}

// Handle delete category
if (isset($_GET['delete_category'])) {
    $category_id = intval($_GET['delete_category']);
    
    // Start transaction
    mysqli_begin_transaction($con);
    
    try {
        // First get all products in this category
        $get_products = "SELECT product_id FROM products WHERE categories_category_id = $category_id";
        $result = mysqli_query($con, $get_products);
        
        // Delete related records for each product
        while ($row = mysqli_fetch_assoc($result)) {
            $product_id = $row['product_id'];
            
            // Delete from cart_details
            mysqli_query($con, "DELETE FROM cart_details WHERE products_product_id = $product_id");
            
            // Delete from order_items
            mysqli_query($con, "DELETE FROM order_items WHERE products_product_id = $product_id");
            
            // Delete from product_reviews
            mysqli_query($con, "DELETE FROM product_reviews WHERE product_id = $product_id");
        }
        
        // Delete all products in this category
        mysqli_query($con, "DELETE FROM products WHERE categories_category_id = $category_id");
        
        // Finally delete the category
        mysqli_query($con, "DELETE FROM categories WHERE category_id = $category_id");
        
        // Commit transaction
        mysqli_commit($con);
        
        echo "<script>alert('Category and all related products deleted successfully!');</script>";
    } catch (Exception $e) {
        // Rollback transaction on error
        mysqli_rollback($con);
        echo "<script>alert('Error deleting category: " . $e->getMessage() . "');</script>";
    }
    
    echo "<script>window.location.href='http://localhost/shehara%20handicrafts/admin%20area/index.php?view_categories';</script>";
    exit();
}
?>
<div class="container my-4">
  <div class="card shadow rounded-4 p-4">
    <h3 class="text-center text-gradient mb-4">All Categories</h3>
    <div class="table-responsive">
      <table class="table modern-table align-middle mb-0">
        <thead>
          <tr>
            <th class="bg-gradient-primary text-white">#</th>
            <th class="bg-gradient-primary text-white">Category Title</th>
            <th class="bg-gradient-primary text-white">Edit</th>
            <th class="bg-gradient-primary text-white">Delete</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $get_categories = "SELECT * FROM categories";
          $result = mysqli_query($con, $get_categories);
          $number = 0;
          while ($row = mysqli_fetch_assoc($result)) {
              $category_id = $row['category_id'];
              $category_title = $row['category_title'];
              $number++;
              echo "
              <tr>
                  <td class='fw-bold text-gradient'>$number</td>
                  <td>$category_title</td>
                  <td><a href='edit_category.php?category_id=$category_id' class='btn btn-outline-success btn-sm'><i class='fa-solid fa-pen-to-square'></i></a></td>
                  <td><a href='view_categories.php?delete_category=$category_id' class='btn btn-outline-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this category? This will also delete all products in this category and their related data.\");'><i class='fa-solid fa-trash'></i></a></td>
              </tr>
              ";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>