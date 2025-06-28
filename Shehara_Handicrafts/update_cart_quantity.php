<?php
include('includes/connect.php');
include('functions/common_function.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit();
}

if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $product_id = $_POST['product_id'];
    $quantity = (int)$_POST['quantity'];
    $user_id = $_SESSION['user_id'];
    $ip_address = $_SERVER['REMOTE_ADDR'];

    // Get current stock quantity
    $stock_query = "SELECT product_quantity FROM products WHERE product_id = $product_id";
    $stock_result = mysqli_query($con, $stock_query);
    $stock_data = mysqli_fetch_assoc($stock_result);
    $stock_quantity = $stock_data['product_quantity'];

    // Check if requested quantity exceeds stock
    if ($quantity > $stock_quantity) {
        echo json_encode([
            'success' => false,
            'message' => 'Cannot add more items. Stock limit reached!',
            'stock_quantity' => $stock_quantity
        ]);
        exit();
    }

    // Update cart quantity
    $update_query = "UPDATE cart_details SET quantity = $quantity 
                    WHERE products_product_id = $product_id 
                    AND user_table_user_id = $user_id 
                    AND ip_address = '$ip_address'";
    
    if (mysqli_query($con, $update_query)) {
        // Calculate new subtotal and total
        $price_query = "SELECT p.product_price 
                       FROM products p 
                       JOIN cart_details cd ON p.product_id = cd.products_product_id 
                       WHERE cd.products_product_id = $product_id 
                       AND cd.user_table_user_id = $user_id 
                       AND cd.ip_address = '$ip_address'";
        $price_result = mysqli_query($con, $price_query);
        $price_data = mysqli_fetch_assoc($price_result);
        $subtotal = $price_data['product_price'] * $quantity;

        // Calculate total cart price
        $total_query = "SELECT SUM(p.product_price * cd.quantity) as total 
                       FROM cart_details cd 
                       JOIN products p ON cd.products_product_id = p.product_id 
                       WHERE cd.user_table_user_id = $user_id 
                       AND cd.ip_address = '$ip_address'";
        $total_result = mysqli_query($con, $total_query);
        $total_data = mysqli_fetch_assoc($total_result);
        $total_price = $total_data['total'];

        echo json_encode([
            'success' => true,
            'subtotal' => $subtotal,
            'total_price' => $total_price,
            'stock_quantity' => $stock_quantity
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to update quantity',
            'stock_quantity' => $stock_quantity
        ]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>
