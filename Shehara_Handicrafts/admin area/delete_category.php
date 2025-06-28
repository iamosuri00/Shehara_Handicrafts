<?php
include('../includes/connect.php'); // Ensure the database connection is included

if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];

    // Delete query
    $delete_category = "DELETE FROM categories WHERE category_id = $category_id";
    $result = mysqli_query($con, $delete_category);

    if ($result) {
        echo "<script>alert('Category deleted successfully!');</script>";
        echo "<script>window.location.href = 'http://localhost/shehara%20handicrafts/admin%20area/index.php?view_categories';</script>";
    } else {
        echo "<script>alert('Failed to delete category.');</script>";
        echo "<script>window.location.href = 'http://localhost/shehara%20handicrafts/admin%20area/index.php?view_categories';</script>";
    }
} else {
    echo "<script>alert('Invalid category ID.');</script>";
    echo "<script>window.location.href = 'http://localhost/shehara%20handicrafts/admin%20area/index.php?view_categories';</script>";
}
