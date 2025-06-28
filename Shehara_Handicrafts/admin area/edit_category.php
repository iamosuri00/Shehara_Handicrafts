<?php
session_start();
include('../includes/connect.php');

// Restrict access to logged-in admins
if (!isset($_SESSION['admin_username'])) {
    echo "<script>alert('Please log in as admin to access this page.');</script>";
    echo "<script>window.location.href = 'admin_login.php';</script>";
    exit();
}

if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];
    $get_category = "SELECT * FROM categories WHERE category_id = $category_id";
    $result = mysqli_query($con, $get_category);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $category_title = $row['category_title'];
    } else {
        echo "<script>alert('Category not found!');</script>";
        echo "<script>window.location.href = 'http://localhost/shehara%20handicrafts/admin%20area/index.php?view_categories';</script>";
        exit();
    }
}

if (isset($_POST['update_category'])) {
    $category_title = trim($_POST['category_title']);
    $errors = [];

    // Server-side validation
    if (empty($category_title)) {
        $errors['category_title'] = "Category title is required.";
    }

    if (empty($errors)) {
        $update_category = "UPDATE categories SET category_title = '$category_title' WHERE category_id = $category_id";
        $result_update = mysqli_query($con, $update_category);

        if ($result_update) {
            echo "<script>alert('Category updated successfully!');</script>";
            echo "<script>window.location.href = 'http://localhost/shehara%20handicrafts/admin%20area/index.php?view_categories';</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body class="bg-light">
    <div class="container mt-3">
        <div class="card shadow rounded-4 p-4">
            <h1 class="text-center gradient-text mb-4">Edit Category</h1>
            <form action="" method="post" id="editCategoryForm">
                <div class="form-outline mb-4 w-50 m-auto">
                    <label for="category_title" class="form-label">Category Title</label>
                    <input type="text" name="category_title" id="category_title" class="form-control" value="<?php echo htmlspecialchars($category_title); ?>" required>
                    <small class="text-danger"><?php echo isset($errors['category_title']) ? $errors['category_title'] : ''; ?></small>
                </div>

                <div class="form-outline mb-4 w-50 m-auto">
                    <input type="submit" name="update_category" class="btn btn-info mb-3 px-3" value="Update Category">
                </div>
            </form>
        </div>
    </div>
</body>

</html>