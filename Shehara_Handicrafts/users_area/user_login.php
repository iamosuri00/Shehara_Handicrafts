<?php
@session_start();
include('../includes/connect.php');
include('../functions/common_function.php');

$errors = [];

if (isset($_POST['user_login'])) {
    $email = trim($_POST['email']);
    $user_password = $_POST['user_password'];

    // Validate email
    if (empty($email)) {
        $errors['email'] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format.";
    }

    // Validate password
    if (empty($user_password)) {
        $errors['password'] = "Password is required.";
    }

    if (empty($errors)) {
        $select_query = "SELECT * FROM `user_table` WHERE user_email='$email'";
        $result = mysqli_query($con, $select_query);
        $row_count = mysqli_num_rows($result);
        $row_data = mysqli_fetch_assoc($result);
        $user_ip = getIPAddress();

        // Cart item
        $select_query_cart = "SELECT * FROM `cart_details` WHERE ip_address='$user_ip'";
        $select_cart = mysqli_query($con, $select_query_cart);
        $row_count_cart = mysqli_num_rows($select_cart);

        if ($row_count > 0) {
            if ($row_data['status'] === 'deactivated') {
                $errors['email'] = "Your account is deactivated. Please contact support.";
            } elseif (password_verify($user_password, $row_data['user_password'])) {
                // Store user details in session
                $_SESSION['username'] = $row_data['first_name'] . " " . $row_data['last_name'];
                $_SESSION['user_image'] = $row_data['user_image'];
                $_SESSION['user_email'] = $row_data['user_email'];
                $_SESSION['user_id'] = $row_data['user_id'];

                if ($row_count == 1 && $row_count_cart == 0) {
                    echo "<script>window.location.href = '../index.php';</script>";
                } else {
                    echo "<script>alert('Login successful');</script>";
                    echo "<script>window.location.href = '../index.php';</script>";
                }
            } else {
                $errors['password'] = "Invalid password.";
            }
        } else {
            $errors['email'] = "No account found with this email.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User -Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <link rel="stylesheet" href="../style.css">
    <style>
      body { overflow-x: hidden; }
      .modern-header-section {
        background: linear-gradient(120deg, #f8fafc 60%, #e3e6f3 100%);
        border-radius: 2rem;
        box-shadow: 0 6px 32px rgba(102,16,242,0.07);
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
      }
      .modern-header-title {
        font-size: 2.2rem;
        letter-spacing: 0.04em;
        line-height: 1.1;
      }
      .gradient-text {
        background: linear-gradient(90deg, #0dcaf0 0%, #6610f2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
      }
      .modern-header-img-wrapper {
        position: relative;
        z-index: 1;
      }
      .modern-header-img {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 2rem;
        border: 6px solid #fff;
        position: relative;
        z-index: 2;
      }
      .modern-header-img-bg {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 140px;
        height: 140px;
        background: radial-gradient(circle, #0dcaf0 0%, #6610f2 100%);
        opacity: 0.13;
        border-radius: 50%;
        transform: translate(-50%, -50%);
        z-index: 1;
      }
      .modern-card {
        background: #fff;
        border-radius: 1.5rem;
        box-shadow: 0 8px 32px rgba(102,16,242,0.10), 0 1.5px 6px rgba(13,202,240,0.08);
        padding: 2rem 2.5rem;
        margin: 0 auto;
        max-width: 420px;
      }
      .btn-modern-cta {
        background: linear-gradient(90deg, #0dcaf0 0%, #6610f2 100%);
        color: #fff;
        border: none;
        font-weight: 600;
        border-radius: 2rem;
        box-shadow: 0 2px 8px rgba(13,202,240,0.10);
        transition: box-shadow 0.18s, transform 0.18s;
      }
      .btn-modern-cta:hover, .btn-modern-cta:focus {
        background: linear-gradient(90deg, #6610f2 0%, #0dcaf0 100%);
        color: #fff;
        box-shadow: 0 4px 16px rgba(102,16,242,0.14);
        transform: translateY(-2px) scale(1.03);
      }
      .footer-modern {
        background: linear-gradient(90deg, #0dcaf0 0%, #6610f2 100%);
        color: #fff;
        border-radius: 2rem 2rem 0 0;
        box-shadow: 0 -2px 24px rgba(102,16,242,0.10);
        font-size: 1.08em;
        letter-spacing: 0.02em;
        margin-top: 3rem;
      }
      .footer-modern .text-gradient {
        background: linear-gradient(90deg, #ffe082 0%, #fff 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
      }
      .footer-link {
        color: #fff;
        font-size: 1.3em;
        transition: color 0.18s, transform 0.18s;
        display: inline-block;
      }
      .footer-link:hover {
        color: #ffe082;
        transform: scale(1.15) rotate(-8deg);
        text-decoration: none;
      }
      .footer-modern .small {
        opacity: 0.85;
      }
      @media (max-width: 767px) {
        .modern-header-section { border-radius: 0.7rem; }
        .modern-header-title { font-size: 1.3rem; }
        .modern-header-img { width: 70px; height: 70px; }
        .modern-header-img-bg { width: 80px; height: 80px; }
        .modern-card { padding: 1.2rem 0.7rem; }
      }
    </style>
</head>

<body>
  <header class="modern-header-section mb-4">
    <div class="container py-4">
      <div class="row align-items-center">
        <div class="col-lg-7 text-lg-start text-center mb-4 mb-lg-0">
          <h1 class="fw-bold mb-3 modern-header-title">
            <span class="gradient-text">Shehara Handicrafts</span>
            <span class="d-inline-block ms-2"><i class="fa-solid fa-gift"></i></span>
          </h1>
          <p class="lead modern-header-desc mb-0">
            Login to your account and enjoy shopping!
          </p>
        </div>
        <div class="col-lg-5 text-center">
          <div class="modern-header-img-wrapper d-inline-block">
            <img src="../images/logo.jpg" alt="Handicrafts" class="modern-header-img shadow-lg rounded-4">
            <div class="modern-header-img-bg"></div>
          </div>
        </div>
      </div>
    </div>
  </header>
  <main>
    <div class="modern-card">
      <h2 class="text-center mb-4 gradient-text">User Login</h2>
      <form action="" method="post">
        <div class="form-outline mb-4">
          <label for="email" class="form-label">Email</label>
          <input type="email" id="email" class="form-control" placeholder="Enter your Email" autocomplete="off" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required />
          <small class="text-danger"><?php echo isset($errors['email']) ? $errors['email'] : ''; ?></small>
        </div>
        <div class="form-outline mb-4">
          <label for="user_password" class="form-label">Password</label>
          <input type="password" id="user_password" class="form-control" placeholder="Enter your password" autocomplete="off" name="user_password" required />
          <small class="text-danger"><?php echo isset($errors['password']) ? $errors['password'] : ''; ?></small>
        </div>
        <div class="mt-4 pt-2 text-center">
          <input type="submit" value="Login" class="btn btn-modern-cta px-4 py-2" name="user_login">
          <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="user_registration.php" class="text-primary">Register</a></p>
          <p class="small fw-bold mt-2 pt-1 mb-0">Admin Login? <a href="../admin area/admin_login.php" class="text-primary">Admin Login</a></p>
        </div>
      </form>
    </div>
  </main>
  <footer class="footer-modern mt-5">
    <div class="container py-4">
      <div class="row align-items-center">
        <div class="col-md-6 text-md-start text-center mb-2 mb-md-0">
          <span class="fw-bold fs-5 text-gradient">Shehara Handicrafts</span>
          <span class="ms-2 text-light small">| Crafted with passion &amp; tradition</span>
        </div>
        <div class="col-md-6 text-md-end text-center">
          <a href="#" class="footer-link mx-2"><i class="fab fa-facebook-f"></i></a>
          <a href="#" class="footer-link mx-2"><i class="fab fa-instagram"></i></a>
          <a href="#" class="footer-link mx-2"><i class="fab fa-whatsapp"></i></a>
          <span class="ms-3 text-light small">&copy; <?php echo date('Y'); ?> All rights reserved.</span>
        </div>
      </div>
    </div>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>