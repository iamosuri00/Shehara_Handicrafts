<?php
session_start();
include('../includes/connect.php');

// Restrict access to logged-in admins
if (!isset($_SESSION['admin_username'])) {
    echo "<script>alert('Please log in as admin to access this page.');</script>";
    echo "<script>window.location.href = 'admin_login.php';</script>";
    exit();
}

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $get_product = "SELECT * FROM products WHERE product_id = $product_id";
    $result = mysqli_query($con, $get_product);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        $product_title = $row['product_title'];
        $description = $row['product_description'];
        $product_keywords = $row['product_keywords'];
        $product_category = $row['categories_category_id'];
        $product_price = $row['product_price'];
        $product_quantity = $row['product_quantity'];
        $product_image = $row['product_image'];
    } else {
        echo "<script>alert('Product not found!');</script>";
        echo "<script>window.location.href = 'view_products.php';</script>";
        exit();
    }
}

if (isset($_POST['update_product'])) {
    $product_title = trim($_POST['product_title']);
    $description = trim($_POST['description']);
    $product_keywords = trim($_POST['product_keywords']);
    $product_category = $_POST['product_category'];
    $product_price = trim($_POST['product_price']);
    $product_quantity = trim($_POST['product_quantity']);
    $new_product_image = $_FILES['product_image']['name'];
    $temp_image = $_FILES['product_image']['tmp_name'];

    $errors = [];

    // Server-side validations
    if (empty($product_title)) {
        $errors['product_title'] = "Product title is required.";
    }
    if (empty($description)) {
        $errors['description'] = "Description is required.";
    }
    if (empty($product_keywords)) {
        $errors['product_keywords'] = "Product keywords are required.";
    }
    if (empty($product_category)) {
        $errors['product_category'] = "Please select a category.";
    }
    if (empty($product_price) || !is_numeric($product_price)) {
        $errors['product_price'] = "Valid product price is required.";
    }
    if (empty($product_quantity) || !is_numeric($product_quantity) || $product_quantity <= 0) {
        $errors['product_quantity'] = "Valid product quantity is required.";
    }

    if (empty($errors)) {
        if (!empty($new_product_image)) {
            // New image uploaded
            $image_folder = "product_images";
            $product_image_path = $image_folder . "/" . $new_product_image;
            move_uploaded_file($temp_image, "../$product_image_path");
        } else {
            // No new image uploaded, retain the existing image
            $product_image_path = $product_image;
        }

        // Update query
        $update_product = "UPDATE products SET 
            product_title = '$product_title', 
            product_description = '$description', 
            product_keywords = '$product_keywords', 
            categories_category_id = '$product_category', 
            product_image = '$product_image_path', 
            product_price = '$product_price', 
            product_quantity = '$product_quantity', 
            date = NOW() 
            WHERE product_id = $product_id";

        $result_update = mysqli_query($con, $update_product);

        if ($result_update) {
            echo "<script>alert('Product updated successfully!');</script>";
            echo "<script>window.location.href = 'http://localhost/shehara%20handicrafts/admin%20area/index.php?view_products';</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body class="bg-light">
    <div class="container mt-3">
        <div class="card shadow rounded-4 p-4">
            <h1 class="text-center gradient-text mb-4">Edit Product</h1>
            <form action="" method="post" enctype="multipart/form-data" id="editProductForm">
                <div class="form-outline mb-4 w-50 m-auto">
                    <label for="product_title" class="form-label">Product Title</label>
                    <input type="text" name="product_title" id="product_title" class="form-control" value="<?php echo htmlspecialchars($product_title); ?>" required>
                    <small class="text-danger"><?php echo isset($errors['product_title']) ? $errors['product_title'] : ''; ?></small>
                </div>

                <div class="form-outline mb-4 w-50 m-auto">
                    <label for="description" class="form-label">Description</label>
                    <input type="text" name="description" id="description" class="form-control" value="<?php echo htmlspecialchars($description); ?>" required>
                    <small class="text-danger"><?php echo isset($errors['description']) ? $errors['description'] : ''; ?></small>
                </div>

                <div class="form-outline mb-4 w-50 m-auto">
                    <label for="product_keywords" class="form-label">Product Keywords</label>
                    <input type="text" name="product_keywords" id="product_keywords" class="form-control" value="<?php echo htmlspecialchars($product_keywords); ?>" required>
                    <small class="text-danger"><?php echo isset($errors['product_keywords']) ? $errors['product_keywords'] : ''; ?></small>
                </div>

                <div class="form-outline mb-4 w-50 m-auto">
                    <label for="product_category" class="form-label">Category</label>
                    <select name="product_category" class="form-select" required>
                        <option value="<?php echo $product_category; ?>">Select: <?php echo htmlspecialchars($product_category); ?></option>
                        <?php
                        $select_query = "SELECT * FROM categories";
                        $result_query = mysqli_query($con, $select_query);
                        while ($row = mysqli_fetch_assoc($result_query)) {
                            $category_title = $row['category_title'];
                            $category_id = $row['category_id'];
                            $selected = $product_category == $category_id ? 'selected' : '';
                            echo "<option value='$category_id' $selected>$category_title</option>";
                        }
                        ?>
                    </select>
                    <small class="text-danger"><?php echo isset($errors['product_category']) ? $errors['product_category'] : ''; ?></small>
                </div>

                <div class="form-outline mb-4 w-50 m-auto">
                    <label for="product_image" class="form-label">Product Image</label>
                    <input type="file" name="product_image" id="product_image" class="form-control">
                    <img src="../admin area/<?php echo $product_image; ?>" class="mt-3" style="width: 100px; height: 100px;" alt="Product Image">
                </div>

                <div class="form-outline mb-4 w-50 m-auto">
                    <label for="product_price" class="form-label">Product Price (LKR)</label>
                    <div class="input-group">
                        <span class="input-group-text">LKR</span>
                        <input type="number" name="product_price" id="product_price" class="form-control" value="<?php echo htmlspecialchars($product_price); ?>" required oninput="formatPrice(this)" placeholder="0000.00">
                    </div>
                    <small class="text-danger"><?php echo isset($errors['product_price']) ? $errors['product_price'] : ''; ?></small>
                </div>
            

                <div class="form-outline mb-4 w-50 m-auto">
                    <label for="product_quantity" class="form-label">Product Quantity</label>
                    <input type="number" min="1" name="product_quantity" id="product_quantity" class="form-control" value="<?php echo htmlspecialchars($product_quantity); ?>" required>
                    <small class="text-danger"><?php echo isset($errors['product_quantity']) ? $errors['product_quantity'] : ''; ?></small>
                </div>

                <div class="form-outline mb-4 w-50 m-auto">
                    <input type="submit" name="update_product" class="btn btn-info mb-3 px-3" value="Update Product">
                </div>
            </form>
        </div>
    </div>
    <script>
        function formatPrice(input) {
            // Remove any non-numeric characters
            let value = input.value.replace(/[^\d]/g, '');
            
            // Update the input value with just the numbers
            input.value = value;
        }

        // Add event listener for price input
        document.getElementById("product_price").addEventListener('input', function() {
            formatPrice(this);
        });
    </script>
</body>

</html>
