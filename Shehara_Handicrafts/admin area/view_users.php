<?php
include('../includes/connect.php');

// Restrict access to logged-in admins
if (!isset($_SESSION['admin_username'])) {
    echo "<script>alert('Please log in as admin to access this page.');</script>";
    echo "<script>window.location.href = 'admin_login.php';</script>";
    exit();
}
?>
<div class="container my-4">
  <div class="card shadow rounded-4 p-4">
    <h3 class="text-center text-gradient mb-4">All Users</h3>
    <div class="table-responsive">
      <table class="table modern-table align-middle mb-0">
        <thead>
          <tr>
            <th class="bg-gradient-primary text-white">#</th>
            <th class="bg-gradient-primary text-white">Full Name</th>
            <th class="bg-gradient-primary text-white">Email</th>
            <th class="bg-gradient-primary text-white">Phone</th>
            <th class="bg-gradient-primary text-white">Status</th>
            <th class="bg-gradient-primary text-white">Registration Date</th>
            <th class="bg-gradient-primary text-white">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $get_users = "SELECT * FROM user_table ORDER BY registration_date DESC";
          $result = mysqli_query($con, $get_users);
          $number = 0;

          while ($row = mysqli_fetch_assoc($result)) {
              $user_id = $row['user_id'];
              $full_name = $row['first_name'] . ' ' . $row['last_name'];
              $email = $row['user_email'];
              $phone = $row['user_mobile'];
              $status = $row['status'];
              $registration_date = $row['registration_date'];
              $number++;
              $status_badge = $status === 'active'
                ? "<span class='badge bg-success bg-opacity-75 px-3 py-2'>Active</span>"
                : "<span class='badge bg-danger bg-opacity-75 px-3 py-2'>Deactivated</span>";
              $activate_btn = "<button type='submit' name='activate_user' class='btn btn-outline-success btn-sm me-1'" . ($status === 'active' ? ' disabled' : '') . "><i class='fa fa-check'></i> Activate</button>";
              $deactivate_btn = "<button type='submit' name='deactivate_user' class='btn btn-outline-danger btn-sm'" . ($status === 'deactivated' ? ' disabled' : '') . "><i class='fa fa-ban'></i> Deactivate</button>";
              echo "
              <tr>
                  <td class='fw-bold text-gradient'>$number</td>
                  <td>$full_name</td>
                  <td>$email</td>
                  <td>$phone</td>
                  <td>$status_badge</td>
                  <td>$registration_date</td>
                  <td>
                      <form method='post' class='d-inline'>
                          <input type='hidden' name='user_id' value='$user_id'>
                          $activate_btn
                          $deactivate_btn
                      </form>
                  </td>
              </tr>
              ";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php
// Handle user activation
if (isset($_POST['activate_user'])) {
    $user_id = $_POST['user_id'];
    $activate_query = "UPDATE user_table SET status = 'active' WHERE user_id = '$user_id'";
    $activate_result = mysqli_query($con, $activate_query);

    if ($activate_result) {
        echo "<script>alert('User activated successfully.');</script>";
        echo "<script>window.location.href = 'http://localhost/shehara%20handicrafts/admin%20area/index.php?view_users';</script>";
    } else {
        echo "<script>alert('Failed to activate user. Please try again.');</script>";
    }
}

// Handle user deactivation
if (isset($_POST['deactivate_user'])) {
    $user_id = $_POST['user_id'];
    $deactivate_query = "UPDATE user_table SET status = 'deactivated' WHERE user_id = '$user_id'";
    $deactivate_result = mysqli_query($con, $deactivate_query);

    if ($deactivate_result) {
        echo "<script>alert('User deactivated successfully.');</script>";
        echo "<script>window.location.href = 'http://localhost/shehara%20handicrafts/admin%20area/index.php?view_users';</script>";
    } else {
        echo "<script>alert('Failed to deactivate user. Please try again.');</script>";
    }
}
?>
