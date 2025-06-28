<?php
include('../includes/connect.php');
include_once('../functions/common_function.php');

// Check if user is NOT logged in, then redirect to login
if (!isset($_SESSION["user_email"])) {
    echo "<script>window.open('./user_login.php','_self')</script>";
    exit();
}

$user_id = $_SESSION['user_id'];
$get_user = "SELECT * FROM user_table WHERE user_id='$user_id'";
$result = mysqli_query($con, $get_user);
$row_fetch = mysqli_fetch_assoc($result);

$user_id = $row_fetch['user_id'];
$user_fname = $row_fetch['first_name'];
$user_lname = $row_fetch['last_name'];
$user_email = $row_fetch['user_email'];
$user_address = $row_fetch['user_address'];
$user_mobile = $row_fetch['user_mobile'];
$user_image = $row_fetch['user_image'];

$errors = [];

if (isset($_POST['user_update'])) {
    $update_id = $user_id;
    $user_fname = trim($_POST['first_name']);
    $user_lname = trim($_POST['last_name']);
    $user_address = trim($_POST['user_address']);
    $user_mobile = trim($_POST['user_mobile']);

    // Server-side validations
    if (!preg_match('/^[A-Za-z]+$/', $user_fname)) {
        $errors['first_name'] = "First name can only contain letters.";
    }
    if (!preg_match('/^[A-Za-z]+$/', $user_lname)) {
        $errors['last_name'] = "Last name can only contain letters.";
    }
    if (empty($user_address)) {
        $errors['user_address'] = "Address is required.";
    }
    if (!preg_match('/^07[01245678]\d{7}$/', $user_mobile)) {
        $errors['user_mobile'] = "Enter a valid Sri Lankan mobile number (e.g., 0712345678).";
    }

    if (empty($errors)) {
        if ($_FILES['user_image']['name'] != '') {
            // New image uploaded
            $image_folder = "user_images";
            $user_image = $_FILES['user_image']['name'];
            $user_image_tmp = $_FILES['user_image']['tmp_name'];
            $user_image_path = $image_folder . "/" . $user_image;
            move_uploaded_file($user_image_tmp, "./$user_image_path");
        } else {
            // No new image uploaded, keep the existing image
            $user_image_path = $user_image;
        }

        $update_data = "UPDATE user_table 
                        SET first_name='$user_fname', last_name='$user_lname', user_image='$user_image_path', 
                            user_address='$user_address', user_mobile='$user_mobile' 
                        WHERE user_id=$update_id";
        $result_query_update = mysqli_query($con, $update_data);

        if ($result_query_update) {
            echo "<script>alert('Account updated successfully!');</script>";
            echo "<script>window.open('profile.php','_self');</script>";
        }
    }
}
?>

<h3 class="text-start text-success mb-4 ms-5">Edit Account</h3>
<form action="" method="post" enctype="multipart/form-data" class="text-start ms-5" id="editAccountForm" style="max-width: 500px;">
    <div class="form-outline mb-4">
        <label for="first_name" class="form-label">First Name</label>
        <input type="text" name="first_name" id="first_name" class="form-control" value="<?php echo htmlspecialchars($user_fname); ?>" required oninput="validateEditField('first_name')">
        <small class="text-danger" id="firstNameError"><?php echo isset($errors['first_name']) ? $errors['first_name'] : ''; ?></small>
    </div>
    <div class="form-outline mb-4">
        <label for="last_name" class="form-label">Last Name</label>
        <input type="text" name="last_name" id="last_name" class="form-control" value="<?php echo htmlspecialchars($user_lname); ?>" required oninput="validateEditField('last_name')">
        <small class="text-danger" id="lastNameError"><?php echo isset($errors['last_name']) ? $errors['last_name'] : ''; ?></small>
    </div>
    <div class="form-outline mb-4">
        <label for="user_email" class="form-label">Email</label>
        <input type="email" name="user_email" id="user_email" class="form-control" value="<?php echo htmlspecialchars($user_email); ?>" readonly>
    </div>
    <div class="form-outline mb-4 d-flex align-items-center">
        <label for="user_image" class="form-label me-2 my-auto">User Image</label>
        <input type="file" name="user_image" id="user_image" class="form-control">
        <img src="../users_area/<?php echo htmlspecialchars($user_image); ?>" class="edit_image ms-2" alt="" style="width:100px; height:100px;">
    </div>
    <div class="form-outline mb-4">
        <label for="user_address" class="form-label">Address</label>
        <input type="text" name="user_address" id="user_address" class="form-control" value="<?php echo htmlspecialchars($user_address); ?>" required oninput="validateEditField('user_address')">
        <small class="text-danger" id="addressError"><?php echo isset($errors['user_address']) ? $errors['user_address'] : ''; ?></small>
    </div>
    <div class="form-outline mb-4">
        <label for="user_mobile" class="form-label">Contact</label>
        <input type="text" name="user_mobile" id="user_mobile" class="form-control" value="<?php echo htmlspecialchars($user_mobile); ?>" required oninput="validateEditField('user_mobile')">
        <small class="text-danger" id="mobileError"><?php echo isset($errors['user_mobile']) ? $errors['user_mobile'] : ''; ?></small>
    </div>
    <input type="submit" value="Update" name="user_update" class="btn btn-info px-4 mb-3">
</form>

<script>
    function validateEditField(field) {
        let isValid = true;
        const firstName = document.getElementById("first_name").value.trim();
        const lastName = document.getElementById("last_name").value.trim();
        const address = document.getElementById("user_address").value.trim();
        const mobile = document.getElementById("user_mobile").value.trim();

        const nameRegex = /^[A-Za-z]+$/;
        const slMobileRegex = /^07[01245678]\d{7}$/;

        if (field === 'first_name') {
            document.getElementById("firstNameError").textContent = "";
            if (!nameRegex.test(firstName)) {
                document.getElementById("firstNameError").textContent = "First name can only contain letters.";
                isValid = false;
            }
        }
        if (field === 'last_name') {
            document.getElementById("lastNameError").textContent = "";
            if (!nameRegex.test(lastName)) {
                document.getElementById("lastNameError").textContent = "Last name can only contain letters.";
                isValid = false;
            }
        }
        if (field === 'user_address') {
            document.getElementById("addressError").textContent = "";
            if (address.length < 1) {
                document.getElementById("addressError").textContent = "Address is required.";
                isValid = false;
            }
        }
        if (field === 'user_mobile') {
            document.getElementById("mobileError").textContent = "";
            if (!slMobileRegex.test(mobile)) {
                document.getElementById("mobileError").textContent = "Enter a valid Sri Lankan mobile number (e.g., 0712345678).";
                isValid = false;
            }
        }
        return isValid;
    }

    document.getElementById("first_name").oninput = function() { validateEditField('first_name'); };
    document.getElementById("last_name").oninput = function() { validateEditField('last_name'); };
    document.getElementById("user_address").oninput = function() { validateEditField('user_address'); };
    document.getElementById("user_mobile").oninput = function() { validateEditField('user_mobile'); };

    document.getElementById("editAccountForm").addEventListener("submit", function(e) {
        let isValid = true;
        if (!validateEditField('first_name')) isValid = false;
        if (!validateEditField('last_name')) isValid = false;
        if (!validateEditField('user_address')) isValid = false;
        if (!validateEditField('user_mobile')) isValid = false;
        if (!isValid) e.preventDefault();
    });
</script>