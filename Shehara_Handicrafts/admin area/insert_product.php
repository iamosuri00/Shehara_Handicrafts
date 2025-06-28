<?php
session_start();
include('../includes/connect.php');

// Restrict access to logged-in admins
if (!isset($_SESSION['admin_username'])) {
    echo "<script>alert('Please log in as admin to access this page.');</script>";
    echo "<script>window.location.href = 'admin_login.php';</script>";
    exit();
}

$errors = [];

if (isset($_POST['insert_product'])) {
    $product_title = trim($_POST['product_title']);
    $description = trim($_POST['description']);
    $product_keywords = trim($_POST['product_keywords']);
    $product_category = $_POST['product_category'];
    $product_price = trim($_POST['product_price']);
    $product_quantity = trim($_POST['product_quantity']); // New quantity field
    $product_status = 'true';

    $image_folder = "product_images";
    $product_image1 = $_FILES['product_image1']['name'];
    $temp_image1 = $_FILES['product_image1']['tmp_name'];
    $product_image_path = $image_folder . "/" . $product_image1;

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
    if (empty($product_image1)) {
        $errors['product_image1'] = "Product image is required.";
    }

    // Always set product status to 'true' (active) on insert
    $product_status = 'true';

    if (empty($errors)) {
        move_uploaded_file($temp_image1, "./$product_image_path");

        // Insert query
        $insert_products = "INSERT INTO products (product_title, product_description, product_keywords, categories_category_id, product_image, product_price, product_quantity, date, status)
        VALUES ('$product_title','$description','$product_keywords','$product_category','$product_image_path','$product_price', '$product_quantity', NOW(), '$product_status')";

        $result_query = mysqli_query($con, $insert_products);
        if ($result_query) {
            echo "<script>alert('Successfully inserted the product');</script>";
            echo "<script>window.location.href = 'http://localhost/shehara%20handicrafts/admin%20area/index.php?view_products';</script>";
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Insert Products - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="../style.css">
</head>

<body class="bg-light">
    <div class="container mt-3">
        <div class="card shadow rounded-4 p-4">
            <h1 class="text-center gradient-text mb-4">Insert Products</h1>
            <form action="" method="post" enctype="multipart/form-data" id="insertProductForm">
                <div class="form-outline mb-4 w-50 m-auto">
                    <label for="product_title" class="form-label">Product Title</label>
                    <input type="text" name="product_title" id="product_title" class="form-control" value="<?php echo isset($_POST['product_title']) ? htmlspecialchars($_POST['product_title']) : ''; ?>" required oninput="validateProductField('product_title')">
                    <small class="text-danger" id="productTitleError"><?php echo isset($errors['product_title']) ? $errors['product_title'] : ''; ?></small>
                </div>
                <div class="form-outline mb-4 w-50 m-auto">
                    <label for="description" class="form-label">Description</label>
                    <input type="text" name="description" id="description" class="form-control" value="<?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?>" required oninput="validateProductField('description')">
                    <small class="text-danger" id="descriptionError"><?php echo isset($errors['description']) ? $errors['description'] : ''; ?></small>
                </div>
                <div class="form-outline mb-4 w-50 m-auto">
                    <label for="product_keywords" class="form-label">Product Keywords</label>
                    <input type="text" name="product_keywords" id="product_keywords" class="form-control" value="<?php echo isset($_POST['product_keywords']) ? htmlspecialchars($_POST['product_keywords']) : ''; ?>" required oninput="validateProductField('product_keywords')">
                    <small class="text-danger" id="keywordsError"><?php echo isset($errors['product_keywords']) ? $errors['product_keywords'] : ''; ?></small>
                </div>
                <div class="form-outline mb-4 w-50 m-auto">
                    <label for="product_category" class="form-label">Category</label>
                    <select name="product_category" class="form-select" required onchange="validateProductField('product_category')">
                        <option value="">Select a Category</option>
                        <?php
                        $select_query = "SELECT * FROM categories";
                        $result_query = mysqli_query($con, $select_query);
                        while ($row = mysqli_fetch_assoc($result_query)) {
                            $category_title = $row['category_title'];
                            $category_id = $row['category_id'];
                            $selected = isset($_POST['product_category']) && $_POST['product_category'] == $category_id ? 'selected' : '';
                            echo "<option value='$category_id' $selected>$category_title</option>";
                        }
                        ?>
                    </select>
                    <small class="text-danger" id="categoryError"><?php echo isset($errors['product_category']) ? $errors['product_category'] : ''; ?></small>
                </div>
                <div class="form-outline mb-4 w-50 m-auto">
                    <label for="product_image1" class="form-label">Product Image</label>
                    <input type="file" name="product_image1" id="product_image1" class="form-control" required oninput="validateProductField('product_image1')">
                    <small class="text-danger" id="imageError"><?php echo isset($errors['product_image1']) ? $errors['product_image1'] : ''; ?></small>
                </div>
                <div class="form-outline mb-4 w-50 m-auto">
                    <label for="product_price" class="form-label">Product Price (LKR)</label>
                    <div class="input-group">
                        <span class="input-group-text">LKR</span>
                        <input type="number" name="product_price" id="product_price" class="form-control" value="<?php echo isset($_POST['product_price']) ? htmlspecialchars($_POST['product_price']) : ''; ?>" required oninput="formatPrice(this)" placeholder="0000.00">
                    </div>
                    <small class="text-danger" id="priceError"><?php echo isset($errors['product_price']) ? $errors['product_price'] : ''; ?></small>
                </div>
                <div class="form-outline mb-4 w-50 m-auto">
                    <label for="product_quantity" class="form-label">Product Quantity</label>
                    <input type="number" min="1" name="product_quantity" id="product_quantity" class="form-control" value="<?php echo isset($_POST['product_quantity']) ? htmlspecialchars($_POST['product_quantity']) : ''; ?>" required oninput="validateProductField('product_quantity')">
                    <small class="text-danger" id="quantityError"><?php echo isset($errors['product_quantity']) ? $errors['product_quantity'] : ''; ?></small>
                </div>
                <div class="form-outline mb-4 w-50 m-auto">
                    <input type="submit" name="insert_product" class="btn btn-info mb-3 px-3" value="Insert Product">
                    <a href="../admin area/index.php?view_products">
                        <button type="button" class="bg-secondary px-3 py-2 border-0 mx-3">View Products</button>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function validateProductField(field) {
            let isValid = true;
            const productTitle = document.getElementById("product_title").value.trim();
            const description = document.getElementById("description").value.trim();
            const productKeywords = document.getElementById("product_keywords").value.trim();
            const productCategory = document.querySelector("select[name='product_category']").value;
            const productPrice = document.getElementById("product_price").value.replace(/[^\d.]/g, '');
            const productQuantity = document.getElementById("product_quantity").value.trim();
            const productImage = document.getElementById("product_image1").value;

            if (field === 'product_title') {
                document.getElementById("productTitleError").textContent = "";
                if (productTitle.length < 1) {
                    document.getElementById("productTitleError").textContent = "Product title is required.";
                    isValid = false;
                }
            }
            if (field === 'description') {
                document.getElementById("descriptionError").textContent = "";
                if (description.length < 1) {
                    document.getElementById("descriptionError").textContent = "Description is required.";
                    isValid = false;
                }
            }
            if (field === 'product_keywords') {
                document.getElementById("keywordsError").textContent = "";
                if (productKeywords.length < 1) {
                    document.getElementById("keywordsError").textContent = "Product keywords are required.";
                    isValid = false;
                }
            }
            if (field === 'product_category') {
                document.getElementById("categoryError").textContent = "";
                if (productCategory === "") {
                    document.getElementById("categoryError").textContent = "Please select a category.";
                    isValid = false;
                }
            }
            if (field === 'product_price') {
                document.getElementById("priceError").textContent = "";
                if (productPrice.length < 1 || isNaN(parseFloat(productPrice)) || parseFloat(productPrice) <= 0) {
                    document.getElementById("priceError").textContent = "Valid product price is required.";
                    isValid = false;
                }
            }
            if (field === 'product_quantity') {
                document.getElementById("quantityError").textContent = "";
                if (productQuantity.length < 1 || isNaN(productQuantity) || productQuantity <= 0) {
                    document.getElementById("quantityError").textContent = "Valid product quantity is required.";
                    isValid = false;
                }
            }
            if (field === 'product_image1') {
                document.getElementById("imageError").textContent = "";
                if (productImage.length < 1) {
                    document.getElementById("imageError").textContent = "Product image is required.";
                    isValid = false;
                }
            }
            return isValid;
        }

        function formatPrice(input) {
            // Remove any non-numeric characters
            let value = input.value.replace(/[^\d]/g, '');
            
            // Update the input value with just the numbers
            input.value = value;
            validateProductField('product_price');
        }

        document.getElementById("product_title").oninput = function() { validateProductField('product_title'); };
        document.getElementById("description").oninput = function() { validateProductField('description'); };
        document.getElementById("product_keywords").oninput = function() { validateProductField('product_keywords'); };
        document.querySelector("select[name='product_category']").onchange = function() { validateProductField('product_category'); };
        document.getElementById("product_price").oninput = function() { validateProductField('product_price'); };
        document.getElementById("product_quantity").oninput = function() { validateProductField('product_quantity'); };
        document.getElementById("product_image1").oninput = function() { validateProductField('product_image1'); };

        document.getElementById("insertProductForm").addEventListener("submit", function(e) {
            let isValid = true;
            if (!validateProductField('product_title')) isValid = false;
            if (!validateProductField('description')) isValid = false;
            if (!validateProductField('product_keywords')) isValid = false;
            if (!validateProductField('product_category')) isValid = false;
            if (!validateProductField('product_price')) isValid = false;
            if (!validateProductField('product_quantity')) isValid = false;
            if (!validateProductField('product_image1')) isValid = false;
            if (!isValid) e.preventDefault();
        });
    </script>
</body>

</html>