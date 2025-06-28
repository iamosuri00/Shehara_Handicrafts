<?php
// Including the connection file
//include('./includes/connect.php');

// Function to get products
if (!function_exists('getproducts')) {
    function getproducts()
    {
        global $con;
        if (!isset($_GET['category'])) {
            $select_query = "SELECT * FROM `products` ORDER BY RAND() LIMIT 0,6";
            $result_query = mysqli_query($con, $select_query);

            while ($row = mysqli_fetch_assoc($result_query)) {
                $product_id = $row['product_id'];
                $product_title = $row['product_title'];
                $product_description = $row['product_description'];
                $product_image = $row['product_image'];
                $product_price = $row['product_price'];

                echo "<div class='col-md-4 mb-2'>
                        <div class='card'>
                            <img src='./admin area/$product_image' class='card-img-top' alt='$product_title'>
                            <div class='card-body'>
                                <h5 class='card-title'>$product_title</h5>
                                <p class='card-text'>$product_description</p>
                                <p class='card-text'>Price: $product_price/-</p>
                                <a href='index.php?add_to_cart=$product_id' class='btn btn-info'>Add to cart</a>
                                <a href='#' class='btn btn-secondary'>View more</a>
                            </div>
                        </div>
                      </div>";
            }
        }
    }
}

//user profile

// Get all products
if (!function_exists('get_all_products')) {
    function get_all_products()
    {
        global $con;
        if (!isset($_GET['category'])) {
            $select_query = "SELECT * FROM `products` ORDER BY RAND()";
            $result_query = mysqli_query($con, $select_query);

            while ($row = mysqli_fetch_assoc($result_query)) {
                $product_id = $row['product_id'];
                $product_title = $row['product_title'];
                $product_description = $row['product_description'];
                $product_image = $row['product_image'];
                $product_price = $row['product_price'];

                echo "<div class='col-md-4 mb-2'>
                        <div class='card'>
                            <img src='./admin area/$product_image' class='card-img-top' alt='$product_title'>
                            <div class='card-body'>
                                <h5 class='card-title'>$product_title</h5>
                                <p class='card-text'>$product_description</p>
                                <p class='card-text'>Price: $product_price/-</p>
                                <a href='index.php?add_to_cart=$product_id' class='btn btn-info'>Add to cart</a>
                                <a href='#' class='btn btn-secondary'>View more</a>
                            </div>
                        </div>
                      </div>";
            }
        }
    }
}

// Get unique category products
if (!function_exists('get_unique_categories')) {
    function get_unique_categories()
    {
        global $con;

        if (isset($_GET['category'])) {
            $category_id = $_GET['category'];
            $select_query = "SELECT * FROM `products` WHERE category_id='$category_id'";
            $result_query = mysqli_query($con, $select_query);

            while ($row = mysqli_fetch_assoc($result_query)) {
                $product_id = $row['product_id'];
                $product_title = $row['product_title'];
                $product_description = $row['product_description'];
                $product_image1 = $row['product_image'];
                $product_price = $row['product_price'];

                echo "<div class='col-md-4 mb-2'>
                        <div class='card'>
                            <img src='./admin area/$product_image1' class='card-img-top' alt='$product_title'>
                            <div class='card-body'>
                                <h5 class='card-title'>$product_title</h5>
                                <p class='card-text'>$product_description</p>
                                <p class='card-text'>Price: $product_price/-</p>
                                <a href='index.php?add_to_cart=$product_id' class='btn btn-info'>Add to cart</a>
                                <a href='#' class='btn btn-secondary'>View More</a>
                            </div>
                        </div>
                      </div>";
            }
        }
    }
}

// Function to get categories
if (!function_exists('getcategories')) {
    function getcategories()
    {
        global $con;
        $select_categories = "SELECT * FROM categories";
        $result_categories = mysqli_query($con, $select_categories);

        while ($row_data = mysqli_fetch_assoc($result_categories)) {
            $category_title = $row_data['category_title'];
            $category_id = $row_data['category_id'];
            echo "<li class='nav-item'>
                    <a href='index.php?category=$category_id' class='nav-link text-light'>$category_title</a>
                  </li>";
        }
    }
}

// Search product function
if (!function_exists('search_product')) {
    function search_product()
    {
        global $con;
        if (isset($_GET['search_data_product'])) {
            $search_data_value = $_GET['search_data'];
            $search_query = "SELECT * FROM `products` WHERE product_keywords LIKE '%$search_data_value%'";
            $result_query = mysqli_query($con, $search_query);
            $num_of_rows = mysqli_num_rows($result_query);

            if ($num_of_rows == 0) {
                echo "<h2 class='text-center text-danger'>No results match. No products found in this category!</h2>";
            }

            while ($row = mysqli_fetch_assoc($result_query)) {
                $product_id = $row['product_id'];
                $product_title = $row['product_title'];
                $product_description = $row['product_description'];
                $product_image = $row['product_image'];
                $product_price = $row['product_price'];

                echo "<div class='col-md-4 mb-2'>
                        <div class='card'>
                            <img src='./admin area/$product_image' class='card-img-top' alt='$product_title'>
                            <div class='card-body'>
                                <h5 class='card-title'>$product_title</h5>
                                <p class='card-text'>$product_description</p>
                                <p class='card-text'>Price: $product_price/-</p>
                                <a href='index.php?add_to_cart=$product_id' class='btn btn-info'>Add to cart</a>
                                <a href='#' class='btn btn-secondary'>View more</a>
                            </div>
                        </div>
                      </div>";
            }
        }
    }
}

// Get IP address function
if (!function_exists('getIPAddress')) {
    function getIPAddress()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
}

// Cart function
if (!function_exists('cart')) {
    function cart()
    {
        global $con;

        // Check if the "Add to Cart" button is clicked
        if (isset($_GET['add_to_cart'])) {
            $get_ip_add = getIPAddress();
            $get_product_id = $_GET['add_to_cart'];

            // Ensure the user is logged in to retrieve the user_id
            if (!isset($_SESSION['user_id'])) {
                echo "<script>alert('Please log in to add items to the cart.');</script>";
                echo "<script>window.open('./users_area/user_login.php', '_self');</script>";
                exit();
            }

            $user_id = $_SESSION['user_id'];

            // Check if the product is already in the cart
            $select_query = "SELECT * FROM `cart_details` WHERE ip_address='$get_ip_add' AND products_product_id=$get_product_id AND user_table_user_id=$user_id";
            $result_query = mysqli_query($con, $select_query);
            $num_of_rows = mysqli_num_rows($result_query);

            if ($num_of_rows > 0) {
                echo "<script>alert('This item is already in the cart');</script>";
                echo "<script>window.open('index.php', '_self');</script>";
            } else {
                // Insert the product into the cart
                $insert_query = "INSERT INTO `cart_details` (products_product_id, ip_address, quantity, user_table_user_id) 
                                 VALUES ($get_product_id, '$get_ip_add', 1, $user_id)";
                mysqli_query($con, $insert_query);
                echo "<script>alert('Item is added to cart');</script>";
                echo "<script>window.open('index.php', '_self');</script>";
            }
        }
    }
}

// Cart item function
if (!function_exists('cart_item')) {
    function cart_item()
    {
        global $con;
        $get_ip_add = getIPAddress();

        // Check if user is logged in
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];

            $select_query = "SELECT * FROM `cart_details` WHERE user_table_user_id='$user_id' AND ip_address='$get_ip_add'";
            $result_query = mysqli_query($con, $select_query);
            $count_cart_items = mysqli_num_rows($result_query);

            echo $count_cart_items;
        } else {
            // If user is not logged in, return 0
            echo 0;
        }
    }
}

// Total cart price function
if (!function_exists('total_cart_price')) {
    function total_cart_price()
    {
        global $con;
        $get_ip_add = getIPAddress();
        $total_price = 0;

        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
            $cart_query = "SELECT * FROM `cart_details` WHERE user_table_user_id='$user_id' AND ip_address='$get_ip_add'";
            $result = mysqli_query($con, $cart_query);

            while ($row = mysqli_fetch_array($result)) {
                $product_id = $row['products_product_id'];
                $select_products = "SELECT * FROM `products` WHERE product_id=$product_id";
                $result_products = mysqli_query($con, $select_products);

                while ($row_product_price = mysqli_fetch_array($result_products)) {
                    $product_price = $row_product_price['product_price'];
                    $total_price += (float)$product_price;
                }
            }

            echo $total_price;
        } else {
            // If user is not logged in, return 0
            echo 0;
        }
    }
}
