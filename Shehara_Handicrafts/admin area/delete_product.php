<?php
session_start();
include('../includes/connect.php');

// Restrict access to logged-in admins
if (!isset($_SESSION['admin_username'])) {
    echo "<script>alert('Please log in as admin to access this page.');</script>";
    echo "<script>window.location.href = 'admin_login.php';</script>";
    exit();
}

if(isset($_GET['delete_product'])){
    $delete_id=$_GET['delete_product'];
    //echo $delete_id;
    //delete query

    $delete_product="Delete from'products' where product_id=$delete_id";
$result_product=mysqli_query($con,$delete_product);
if($result_product){

    echo"<script>alert('product deleted successfully')</script>";
    echo "script>window.open('./index.php','_self')</script>";
}
}

?>