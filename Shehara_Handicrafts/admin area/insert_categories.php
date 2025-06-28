<?php
include('../includes/connect.php');

if (isset($_POST["insert_cat"])) {
    $category_title = trim($_POST['cat_title']);

    if ($category_title == '') {
        echo "<script>alert('Category title cannot be empty');</script>";
    } else {
        // Check for duplicates
        $select_query = "SELECT * FROM categories WHERE category_title = '$category_title'";
        $result_select = mysqli_query($con, $select_query);
        $number = mysqli_num_rows($result_select);

        if ($number > 0) {
            echo "<script>alert('This category already exists in the database');</script>";
        } else {
            // Insert query
            $insert_query = "INSERT INTO categories (category_title) VALUES ('$category_title')";
            $result = mysqli_query($con, $insert_query);

            if ($result) {
                echo "<script>alert('Category has been added successfully');</script>";
            } else {
                echo "<script>alert('Failed to add category');</script>";
            }
        }
    }
}
?>

<!-- HTML -->
<h2 class="text-center">Insert Categories</h2>

<form action="" method="post" class="mb-2">
    <div class="input-group w-90 mb-2">
        <span class="input-group-text bg-info" id="basic-addon1"><i class="fa-solid fa-receipt"></i></span>
        <input type="text" class="form-control" name="cat_title" placeholder="Insert category" required>
    </div>

    <div class="input-group w-10 mb-2 m-auto">
        <input type="submit" class="bg-info border-0 p-2 my-3" name="insert_cat" value="Insert Category">
    </div>
</form>
