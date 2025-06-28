<?php
include('includes/connect.php');
include('functions/common_function.php');
session_start();

// Get user details if logged in
$user_details = [];
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $user_query = "SELECT * FROM user_table WHERE user_id = $user_id";
    $user_result = mysqli_query($con, $user_query);
    if ($user_result && mysqli_num_rows($user_result) > 0) {
        $user_details = mysqli_fetch_assoc($user_result);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout - Shehara Handicrafts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .checkout-container {
            max-width: 900px;
            margin: 50px auto;
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .section-title {
            font-size: 1.5rem;
            margin-bottom: 20px;
            font-weight: bold;
            color: #343a40;
        }

        .summary-box {
            background-color: #f1f1f1;
            padding: 20px;
            border-radius: 10px;
        }

        .btn-checkout {
            background-color: #198754;
            color: white;
            font-weight: bold;
        }

        .btn-checkout:hover {
            background-color: #157347;
        }

        .item-summary {
            font-size: 0.95rem;
            margin-bottom: 10px;
        }

        .different-address {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            display: none;
        }

        .different-address.show {
            display: block;
        }

        .form-check {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container checkout-container">
        <h2 class="text-center mb-4">Checkout</h2>
        <form action="payment.php" method="post" onsubmit="return validateCheckoutForm()">
            <div class="row">
                <!-- Billing Info -->
                <div class="col-md-6">
                    <h3 class="section-title">Billing Information</h3>
                    
                    <!-- Default Address Section -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">First Name</label>
                            <input type="text" class="form-control" name="billing_first_name" id="billing_first_name" 
                                   value="<?php echo isset($user_details['first_name']) ? htmlspecialchars($user_details['first_name']) : ''; ?>" 
                                   required oninput="validateCheckoutField('first_name')">
                            <small class="text-danger" id="first_name_error"></small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-control" name="billing_last_name" id="billing_last_name" 
                                   value="<?php echo isset($user_details['last_name']) ? htmlspecialchars($user_details['last_name']) : ''; ?>" 
                                   required oninput="validateCheckoutField('last_name')">
                            <small class="text-danger" id="last_name_error"></small>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-control" name="billing_email" id="billing_email" 
                               value="<?php echo isset($user_details['user_email']) ? htmlspecialchars($user_details['user_email']) : ''; ?>" 
                               required oninput="validateCheckoutField('email')">
                        <small class="text-danger" id="email_error"></small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" class="form-control" name="billing_phone" id="billing_phone" 
                               value="<?php echo isset($user_details['user_mobile']) ? htmlspecialchars($user_details['user_mobile']) : ''; ?>" 
                               required oninput="validateCheckoutField('phone')">
                        <small class="text-danger" id="phone_error"></small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea class="form-control" name="billing_address" id="billing_address" rows="3" 
                                  required oninput="validateCheckoutField('address')"><?php echo isset($user_details['user_address']) ? htmlspecialchars($user_details['user_address']) : ''; ?></textarea>
                        <small class="text-danger" id="address_error"></small>
                    </div>

                    <!-- Different Address Option -->
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="different_address" onchange="toggleDifferentAddress()">
                        <label class="form-check-label" for="different_address">
                            Use a different billing address
                        </label>
                    </div>

                    <!-- Different Address Form -->
                    <div id="different_address_form" class="different-address">
                        <h4 class="mb-3">Alternative Billing Address</h4>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">First Name</label>
                                <input type="text" class="form-control" name="alt_billing_first_name" id="alt_billing_first_name">
                                <small class="text-danger" id="alt_first_name_error"></small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Last Name</label>
                                <input type="text" class="form-control" name="alt_billing_last_name" id="alt_billing_last_name">
                                <small class="text-danger" id="alt_last_name_error"></small>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="form-control" name="alt_billing_email" id="alt_billing_email">
                            <small class="text-danger" id="alt_email_error"></small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="text" class="form-control" name="alt_billing_phone" id="alt_billing_phone">
                            <small class="text-danger" id="alt_phone_error"></small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <textarea class="form-control" name="alt_billing_address" id="alt_billing_address" rows="3"></textarea>
                            <small class="text-danger" id="alt_address_error"></small>
                        </div>
                    </div>
                </div>

                <!-- Order Summary + Payment -->
                <div class="col-md-6">
                    <h3 class="section-title">Order Summary</h3>
                    <div class="summary-box mb-3">
                        <?php
                        $get_ip_add = getIPAddress();
                        $total_price = 0;
                        $product_data = [];
                        $checkout_allowed = true;

                        $cart_query = "SELECT cd.*, p.product_title, p.product_price, p.product_quantity 
                                       FROM cart_details cd 
                                       JOIN products p ON cd.products_product_id = p.product_id 
                                       WHERE cd.ip_address='$get_ip_add'";
                        $result = mysqli_query($con, $cart_query);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_array($result)) {
                                $product_title = $row['product_title'];
                                $product_price = $row['product_price'];
                                $current_quantity = $row['quantity'];
                                $stock_quantity = $row['product_quantity'];
                                $subtotal = $product_price * $current_quantity;
                                $total_price += $subtotal;

                                // Check stock availability
                                if ($current_quantity > $stock_quantity) {
                                    echo "<div class='text-danger'>Not enough stock for $product_title. Available: $stock_quantity</div>";
                                    $checkout_allowed = false;
                                }

                                $product_data[] = [
                                    'product_id' => $row['products_product_id'],
                                    'title' => $product_title,
                                    'quantity' => $current_quantity,
                                    'price' => $product_price,
                                    'subtotal' => $subtotal
                                ];

                                echo "<div class='item-summary'>
                                      $product_title x $current_quantity = Rs. $subtotal/- (Stock: $stock_quantity)
                                      </div>";
                            }

                            echo "<hr><h5>Total: <strong>Rs. $total_price/-</strong></h5>";
                        } else {
                            echo "<p>Your cart is empty.</p>";
                        }
                        ?>
                    </div>

                    <input type="hidden" name="total_price" value="<?php echo $total_price; ?>">
                    <input type="hidden" name="product_data" value="<?php echo htmlspecialchars(json_encode($product_data), ENT_QUOTES, 'UTF-8'); ?>">

                    <?php if ($total_price > 0 && $checkout_allowed): ?>
                        <button type="submit" class="btn btn-checkout w-100">Place Order</button>
                    <?php else: ?>
                        <button type="button" class="btn btn-danger w-100" disabled>Cannot Proceed to Checkout</button>
                    <?php endif; ?>
                </div>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleDifferentAddress() {
            const differentAddressForm = document.getElementById('different_address_form');
            const isChecked = document.getElementById('different_address').checked;
            
            if (isChecked) {
                differentAddressForm.classList.add('show');
                // Make alternative address fields required
                document.getElementById('alt_billing_first_name').required = true;
                document.getElementById('alt_billing_last_name').required = true;
                document.getElementById('alt_billing_email').required = true;
                document.getElementById('alt_billing_phone').required = true;
                document.getElementById('alt_billing_address').required = true;
            } else {
                differentAddressForm.classList.remove('show');
                // Remove required attribute from alternative address fields
                document.getElementById('alt_billing_first_name').required = false;
                document.getElementById('alt_billing_last_name').required = false;
                document.getElementById('alt_billing_email').required = false;
                document.getElementById('alt_billing_phone').required = false;
                document.getElementById('alt_billing_address').required = false;
            }
        }

        function validateCheckoutField(field) {
            let isValid = true;
            const firstName = document.getElementById('billing_first_name').value.trim();
            const lastName = document.getElementById('billing_last_name').value.trim();
            const email = document.getElementById('billing_email').value.trim();
            const phone = document.getElementById('billing_phone').value.trim();
            const address = document.getElementById('billing_address').value.trim();

            if (field === 'first_name') {
                document.getElementById('first_name_error').textContent = '';
                if (firstName === '' || !/^[a-zA-Z\s.]+$/.test(firstName)) {
                    document.getElementById('first_name_error').textContent = 'First name can only contain letters, spaces, and dots.';
                    isValid = false;
                }
            }
            if (field === 'last_name') {
                document.getElementById('last_name_error').textContent = '';
                if (lastName === '' || !/^[a-zA-Z\s.]+$/.test(lastName)) {
                    document.getElementById('last_name_error').textContent = 'Last name can only contain letters, spaces, and dots.';
                    isValid = false;
                }
            }
            if (field === 'email') {
                document.getElementById('email_error').textContent = '';
                if (email === '' || !/^\S+@\S+\.\S+$/.test(email)) {
                    document.getElementById('email_error').textContent = 'Valid Email is required.';
                    isValid = false;
                }
            }
            if (field === 'phone') {
                document.getElementById('phone_error').textContent = '';
                if (phone === '' || !/^07\d{8}$/.test(phone)) {
                    document.getElementById('phone_error').textContent = 'Valid Sri Lankan Phone Number is required (e.g., 0712345678).';
                    isValid = false;
                }
            }
            if (field === 'address') {
                document.getElementById('address_error').textContent = '';
                if (address === '') {
                    document.getElementById('address_error').textContent = 'Address is required.';
                    isValid = false;
                }
            }
            return isValid;
        }

        function validateCheckoutForm() {
            let isValid = true;
            if (!validateCheckoutField('first_name')) isValid = false;
            if (!validateCheckoutField('last_name')) isValid = false;
            if (!validateCheckoutField('email')) isValid = false;
            if (!validateCheckoutField('phone')) isValid = false;
            if (!validateCheckoutField('address')) isValid = false;

            // Validate alternative address if enabled
            if (document.getElementById('different_address').checked) {
                const altFirstName = document.getElementById('alt_billing_first_name').value.trim();
                const altLastName = document.getElementById('alt_billing_last_name').value.trim();
                const altEmail = document.getElementById('alt_billing_email').value.trim();
                const altPhone = document.getElementById('alt_billing_phone').value.trim();
                const altAddress = document.getElementById('alt_billing_address').value.trim();

                if (altFirstName === '' || !/^[a-zA-Z\s.]+$/.test(altFirstName)) {
                    alert('Alternative billing first name is invalid.');
                    isValid = false;
                }
                if (altLastName === '' || !/^[a-zA-Z\s.]+$/.test(altLastName)) {
                    alert('Alternative billing last name is invalid.');
                    isValid = false;
                }
                if (altEmail === '' || !/^\S+@\S+\.\S+$/.test(altEmail)) {
                    alert('Alternative billing email is invalid.');
                    isValid = false;
                }
                if (altPhone === '' || !/^07\d{8}$/.test(altPhone)) {
                    alert('Alternative billing phone number is invalid.');
                    isValid = false;
                }
                if (altAddress === '') {
                    alert('Alternative billing address is required.');
                    isValid = false;
                }
            }

            return isValid;
        }
    </script>
</body>

</html>