<?php
session_start();
include('../includes/connect.php');
include('../functions/common_function.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Registration</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
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
      max-width: 480px;
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
            Create your account and join our creative community!
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
      <h2 class="text-center mb-4 gradient-text">New User Registration</h2>
      <form action="" method="post" enctype="multipart/form-data" id="registrationForm">
        <div class="form-outline mb-4">
          <label for="fName" class="form-label">First Name</label>
          <input type="text" id="fName" class="form-control" name="fName" placeholder="Enter your First Name" value="<?php echo isset($_POST['fName']) ? htmlspecialchars($_POST['fName']) : ''; ?>" required />
          <small class="text-danger" id="fNameError"></small>
        </div>
        <div class="form-outline mb-4">
          <label for="lName" class="form-label">Last Name</label>
          <input type="text" id="lName" class="form-control" name="lName" placeholder="Enter your Last Name" value="<?php echo isset($_POST['lName']) ? htmlspecialchars($_POST['lName']) : ''; ?>" required />
          <small class="text-danger" id="lNameError"></small>
        </div>

        <div class="form-outline mb-4">
          <label for="user_email" class="form-label">Email</label>
          <input type="email" id="user_email" class="form-control" name="user_email" placeholder="Enter your email" value="<?php echo isset($_POST['user_email']) ? htmlspecialchars($_POST['user_email']) : ''; ?>" required />
          <small class="text-danger" id="emailError"></small>
        </div>

        <div class="form-outline mb-4">
          <label for="user_image" class="form-label">User Image</label>
          <input type="file" id="user_image" class="form-control" name="user_image" required oninput="validateField('user_image')" />
          <small class="text-danger" id="imageError"></small>
        </div>

        <div class="form-outline mb-4">
          <label for="user_password" class="form-label">Password</label>
          <input type="password" id="user_password" class="form-control" name="user_password" placeholder="Enter your password" required oninput="validateField('user_password')" />
          <small class="text-danger" id="passwordError"></small>
        </div>

        <div class="form-outline mb-4">
          <label for="conf_user_password" class="form-label">Confirm Password</label>
          <input type="password" id="conf_user_password" class="form-control" name="conf_user_password" placeholder="Confirm your password" required oninput="validateField('conf_user_password')" />
          <small class="text-danger" id="confirmPasswordError"></small>
        </div>

        <div class="form-outline mb-4">
          <label for="user_address" class="form-label">Address</label>
          <input type="text" id="user_address" class="form-control" name="user_address" placeholder="Enter your address" value="<?php echo isset($_POST['user_address']) ? htmlspecialchars($_POST['user_address']) : ''; ?>" required oninput="validateField('user_address')" />
          <small class="text-danger" id="addressError"></small>
        </div>

        <div class="form-outline mb-4">
          <label for="user_contact" class="form-label">Contact</label>
          <input type="text" id="user_contact" class="form-control" name="user_contact" placeholder="Enter your mobile number" value="<?php echo isset($_POST['user_contact']) ? htmlspecialchars($_POST['user_contact']) : ''; ?>" required oninput="validateField('user_contact')" />
          <small class="text-danger" id="contactError"></small>
        </div>

        <div class="mt-4 pt-2 text-center">
          <input type="submit" value="Register" class="btn btn-modern-cta px-4 py-2" name="user_register">
          <p class="small fw-bold mt-2 pt-1 mb-0">Already have an account? <a href="user_login.php" class="text-primary">Login</a></p>
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

  <!-- Client-side JavaScript validation -->
  <script>
    function validateField(field) {
      let isValid = true;
      const fName = document.getElementById("fName").value.trim();
      const lName = document.getElementById("lName").value.trim();
      const email = document.getElementById("user_email").value.trim();
      const password = document.getElementById("user_password").value;
      const confirmPassword = document.getElementById("conf_user_password").value;
      const address = document.getElementById("user_address").value.trim();
      const contact = document.getElementById("user_contact").value.trim();
      const image = document.getElementById("user_image").value;

      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      const slMobileRegex = /^07[01245678]\d{7}$/;
      const nameRegex = /^[A-Za-z]+$/;

      // Clear only the relevant error
      if (field === 'fName') {
        document.getElementById("fNameError").textContent = "";
        if (!nameRegex.test(fName)) {
          document.getElementById("fNameError").textContent = "First name can only contain letters.";
          isValid = false;
        }
      }
      if (field === 'lName') {
        document.getElementById("lNameError").textContent = "";
        if (!nameRegex.test(lName)) {
          document.getElementById("lNameError").textContent = "Last name can only contain letters.";
          isValid = false;
        }
      }
      if (field === 'user_email') {
        document.getElementById("emailError").textContent = "";
        if (!emailRegex.test(email)) {
          document.getElementById("emailError").textContent = "Invalid email format.";
          isValid = false;
        }
      }
      if (field === 'user_image') {
        document.getElementById("imageError").textContent = "";
        if (!image) {
          document.getElementById("imageError").textContent = "Please upload a user image.";
          isValid = false;
        }
      }
      if (field === 'user_password') {
        document.getElementById("passwordError").textContent = "";
        if (password.length < 6) {
          document.getElementById("passwordError").textContent = "Password must be at least 6 characters.";
          isValid = false;
        }
      }
      if (field === 'conf_user_password') {
        document.getElementById("confirmPasswordError").textContent = "";
        if (password !== confirmPassword) {
          document.getElementById("confirmPasswordError").textContent = "Passwords do not match.";
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
      if (field === 'user_contact') {
        document.getElementById("contactError").textContent = "";
        if (!/^\d{10}$/.test(contact)) {
          document.getElementById("contactError").textContent = "Contact number must be exactly 10 digits.";
          isValid = false;
        } else if (!slMobileRegex.test(contact)) {
          document.getElementById("contactError").textContent = "Enter a valid Sri Lankan mobile number (e.g., 0712345678).";
          isValid = false;
        }
      }
      return isValid;
    }

    // Attach oninput for all fields
    document.getElementById("fName").oninput = function() { validateField('fName'); };
    document.getElementById("lName").oninput = function() { validateField('lName'); };
    document.getElementById("user_email").oninput = function() { validateField('user_email'); };
    // ...existing code for user_image, user_password, conf_user_password, user_address, user_contact already has oninput...

    document.getElementById("registrationForm").addEventListener("submit", function(e) {
      let isValid = true;
      // Validate all fields before submit
      if (!validateField('fName')) isValid = false;
      if (!validateField('lName')) isValid = false;
      if (!validateField('user_email')) isValid = false;
      if (!validateField('user_image')) isValid = false;
      if (!validateField('user_password')) isValid = false;
      if (!validateField('conf_user_password')) isValid = false;
      if (!validateField('user_address')) isValid = false;
      if (!validateField('user_contact')) isValid = false;
      if (!isValid) e.preventDefault();
    });
  </script>
</body>

</html>

<!-- PHP registration logic -->
<?php
if (isset($_POST['user_register'])) {
  $errors = [];

  $fName = trim($_POST['fName']);
  $lName = trim($_POST['lName']);
  $user_email = trim($_POST['user_email']);
  $user_password = $_POST['user_password'];
  $conf_user_password = $_POST['conf_user_password'];
  $user_address = trim($_POST['user_address']);
  $user_contact = trim($_POST['user_contact']);
  $user_image = $_FILES['user_image']['name'];
  $user_image_tmp = $_FILES['user_image']['tmp_name'];
  $user_ip = getIPAddress();

  $image_folder = "user_images";
  $user_image_path = $image_folder . "/" . basename($user_image);

  // Server-side validations
  if (!preg_match('/^[A-Za-z]+$/', $fName)) $errors[] = "First name can only contain letters.";
  if (!preg_match('/^[A-Za-z]+$/', $lName)) $errors[] = "Last name can only contain letters.";
  if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email format.";
  if (strlen($user_password) < 6) $errors[] = "Password must be at least 6 characters.";
  if ($user_password !== $conf_user_password) $errors[] = "Passwords do not match.";
  if (!preg_match('/^\d{10}$/', $user_contact)) $errors[] = "Contact must be exactly 10 digits.";
  if (!preg_match('/^07[01245678]\d{7}$/', $user_contact)) $errors[] = "Enter a valid Sri Lankan mobile number with correct prefix.";
  if (empty($user_image)) $errors[] = "Please upload a user image.";

  // Check for duplicate email
  $check_query = "SELECT * FROM user_table WHERE user_email = '$user_email'";
  $check_result = mysqli_query($con, $check_query);
  if (mysqli_num_rows($check_result) > 0) {
    $errors[] = "Email already exists.";
  }

  if (!empty($errors)) {
    foreach ($errors as $error) {
      echo "<script>alert('$error');</script>";
    }
  } else {
    move_uploaded_file($user_image_tmp, "./$user_image_path");

    $hash_password = password_hash($user_password, PASSWORD_DEFAULT);
    $insert_query = "INSERT INTO user_table (first_name, last_name, user_email, user_password, user_image, user_ip, user_address, user_mobile, registration_date) 
                    VALUES ('$fName', '$lName', '$user_email', '$hash_password', '$user_image_path', '$user_ip', '$user_address', '$user_contact', NOW())";
    mysqli_query($con, $insert_query);

    $_SESSION['username'] = $fName;
    echo "<script>alert('Registration successful. Redirecting to login page.'); window.open('../users_area/user_login.php','_self');</script>";
  }
}
?>