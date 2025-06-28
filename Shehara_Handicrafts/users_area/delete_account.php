<?php
include('../includes/connect.php');

$username = $_SESSION['username'] ?? null;

// Get user ID
if ($username) {
    $get_user = "SELECT * FROM user_table WHERE username='$username'";
    $result = mysqli_query($con, $get_user);
    $row_fetch = mysqli_fetch_assoc($result);
    $user_id = $row_fetch['user_id'];
} else {
    echo "<script>alert('User not logged in'); window.location.href='user_login.php';</script>";
    exit();
}

// If user confirms deletion
if (isset($_POST['delete'])) {
    $delete_query = "DELETE FROM user_table WHERE user_id = $user_id";
    $result_delete = mysqli_query($con, $delete_query);
    if ($result_delete) {
        session_destroy();
        echo "<script>alert('Account deactivated successfully');</script>";
        echo "<script>window.location.href='../user_login.php';</script>";
    }
}

// If user cancels
if (isset($_POST['dont_delete'])) {
    echo "<script>window.location.href='profile.php';</script>";
}
?>

<h3 class="text-center text-danger">Are you sure you want to deactivate your account?</h3>
<form action="" method="post" class="text-center mt-4">
    <input type="submit" name="deactivate" value="Yes, Deactivate" class="btn btn-danger px-4 me-3">
    <input type="submit" name="dont_deactivate" value="No, Cancel" class="btn btn-secondary px-4">
</form>
