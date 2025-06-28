<?php
include('includes/connect.php');
include('functions/common_function.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please log in to proceed with payment.');</script>";
    echo "<script>window.location.href = './users_area/user_login.php';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];

// Check if billing details and total price are passed from checkout.php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['billing_first_name'], $_POST['billing_last_name'], $_POST['billing_email'], $_POST['billing_phone'], $_POST['billing_address'], $_POST['total_price'], $_POST['product_data'])) {
    // Check if alternative billing address is used
    if (isset($_POST['alt_billing_first_name']) && !empty($_POST['alt_billing_first_name'])) {
        $_SESSION['billing_name'] = $_POST['alt_billing_first_name'] . ' ' . $_POST['alt_billing_last_name'];
        $_SESSION['billing_email'] = $_POST['alt_billing_email'];
        $_SESSION['billing_phone'] = $_POST['alt_billing_phone'];
        $_SESSION['billing_address'] = $_POST['alt_billing_address'];
    } else {
        $_SESSION['billing_name'] = $_POST['billing_first_name'] . ' ' . $_POST['billing_last_name'];
        $_SESSION['billing_email'] = $_POST['billing_email'];
        $_SESSION['billing_phone'] = $_POST['billing_phone'];
        $_SESSION['billing_address'] = $_POST['billing_address'];
    }
    $_SESSION['total_price'] = $_POST['total_price'];
    $_SESSION['product_data'] = $_POST['product_data'];
} elseif (!isset($_SESSION['billing_name'], $_SESSION['billing_email'], $_SESSION['billing_phone'], $_SESSION['billing_address'], $_SESSION['total_price'], $_SESSION['product_data'])) {
    echo "<script>alert('Invalid access. Please complete the checkout process first.');</script>";
    echo "<script>window.location.href = 'checkout.php';</script>";
    exit();
}

// Handle payment form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['card_number'], $_POST['card_expiry'], $_POST['card_cvv'])) {
    $billing_name = $_SESSION['billing_name'];
    $billing_email = $_SESSION['billing_email'];
    $billing_phone = $_SESSION['billing_phone'];
    $billing_address = $_SESSION['billing_address'];
    $total_price = $_SESSION['total_price'];
    $product_data = json_decode($_SESSION['product_data'], true);

    $card_number = str_replace(' ', '', trim($_POST['card_number'])); // Remove spaces from card number
    $card_expiry = trim($_POST['card_expiry']);
    $card_cvv = trim($_POST['card_cvv']);

    // Generate a unique order ID
    $unique_order_id = 'ORD' . strtoupper(uniqid());

    // Validate billing name and phone number
    $errors = [];
    if (empty($billing_name) || !preg_match('/^[a-zA-Z\s.]+$/', $billing_name)) {
        $errors['billing_name'] = 'Full Name can only contain letters, spaces, and dots.';
    }
    if (empty($billing_phone) || !preg_match('/^07\d{8}$/', $billing_phone)) {
        $errors['billing_phone'] = 'Valid Sri Lankan Phone Number is required (e.g., 0712345678).';
    }

    // Validate card details
    if (empty($card_number) || !preg_match('/^\d{16}$/', $card_number)) {
        $errors['card_number'] = 'Invalid card number. Must be 16 digits.';
    }
    if (empty($card_expiry) || !preg_match('/^\d{2}\/\d{2}$/', $card_expiry)) {
        $errors['card_expiry'] = 'Invalid expiry date. Format: MM/YY.';
    }
    if (empty($card_cvv) || !preg_match('/^\d{3}$/', $card_cvv)) {
        $errors['card_cvv'] = 'Invalid CVV. Must be 3 digits.';
    }

    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<script>alert('$error');</script>";
        }
        exit();
    }

    // Validate stock availability
    foreach ($product_data as $product) {
        $product_id = $product['product_id'];
        $quantity = $product['quantity'];

        $stock_query = "SELECT product_quantity FROM products WHERE product_id = '$product_id'";
        $stock_result = mysqli_query($con, $stock_query);
        $stock_row = mysqli_fetch_assoc($stock_result);

        if ($quantity > $stock_row['product_quantity']) {
            echo "<script>alert('Not enough stock for {$product['title']}. Available: {$stock_row['product_quantity']}');</script>";
            echo "<script>window.location.href = 'checkout.php';</script>";
            exit();
        }
    }

    // Save order to database
    $order_query = "INSERT INTO orders (order_id, user_table_user_id, total_price, billing_name, billing_email, billing_address, billing_phone, order_date, payment_status) 
                    VALUES ('$unique_order_id', '$user_id', '$total_price', '$billing_name', '$billing_email', '$billing_address', '$billing_phone', NOW(), 'Paid')";
    $order_result = mysqli_query($con, $order_query);

    if ($order_result) {
        foreach ($product_data as $product) {
            $product_id = $product['product_id'];
            $quantity = $product['quantity'];
            $subtotal = $product['subtotal'];

            // Save order details
            $order_details_query = "INSERT INTO order_items (order_order_id, products_product_id, quantity, subtotal) 
                                    VALUES ('$unique_order_id', '$product_id', '$quantity', '$subtotal')";
            mysqli_query($con, $order_details_query);

            // Update product quantity
            $update_product_query = "UPDATE products SET product_quantity = product_quantity - $quantity WHERE product_id = '$product_id'";
            mysqli_query($con, $update_product_query);
        }

        // Clear cart
        $clear_cart_query = "DELETE FROM cart_details WHERE user_table_user_id = '$user_id'";
        mysqli_query($con, $clear_cart_query);

        // Clear session data
        unset($_SESSION['billing_name'], $_SESSION['billing_email'], $_SESSION['billing_phone'], $_SESSION['billing_address'], $_SESSION['total_price'], $_SESSION['product_data']);

        echo "<script>alert('Payment successful! Your order has been placed. Order ID: $unique_order_id');</script>";
        echo "<script>window.location.href = 'index.php';</script>";
    } else {
        echo "<script>alert('Failed to process your order. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payment - Shehara Handicrafts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .payment-container {
            max-width: 600px;
            margin: 50px auto;
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }

        .form-label {
            font-weight: bold;
        }

        .btn-pay {
            background-color: #198754;
            color: white;
            font-weight: bold;
        }

        .btn-pay:hover {
            background-color: #157347;
        }

        .error-message {
            color: red;
            font-size: 0.9rem;
        }

        .order-summary {
            margin-top: 20px;
        }

        .order-summary h4 {
            font-weight: bold;
            margin-bottom: 15px;
        }

        .order-summary .product-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .order-summary .product-item span {
            font-size: 0.9rem;
        }

        .order-summary .total {
            font-weight: bold;
            font-size: 1.2rem;
            margin-top: 15px;
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="container payment-container">
        <h2 class="text-center mb-4"><i class="fas fa-credit-card"></i> Payment</h2>

        <!-- Order Summary Section -->
        <div class="order-summary">
            <h4><i class="fas fa-shopping-cart"></i> Order Summary</h4>
            <?php
            $product_data = json_decode($_SESSION['product_data'], true);
            $total_price = $_SESSION['total_price'];

            foreach ($product_data as $product) {
                echo "<div class='product-item'>
                        <span>{$product['title']} x {$product['quantity']}</span>
                        <span>Rs. {$product['subtotal']}/-</span>
                      </div>";
            }
            ?>
            <div class="total">Total: Rs. <?php echo $total_price; ?>/-</div>
        </div>

        <!-- Payment Form -->
        <form action="" method="post" onsubmit="return validatePaymentForm()">
            <div class="mb-3">
                <label class="form-label">Card Number</label>
                <input type="text" class="form-control" name="card_number" id="card_number" maxlength="19" placeholder="1234 5678 9012 3456" required>
                <small class="error-message" id="card_number_error"></small>
            </div>
            <div class="mb-3">
                <label class="form-label">Expiry Date</label>
                <input type="text" class="form-control" name="card_expiry" id="card_expiry" placeholder="MM/YY" required>
                <small class="error-message" id="card_expiry_error"></small>
            </div>
            <div class="mb-3">
                <label class="form-label">CVV</label>
                <input type="text" class="form-control" name="card_cvv" id="card_cvv" maxlength="3" 
                       placeholder="123" required oninput="validateCVV(this.value)">
                <small class="error-message" id="card_cvv_error"></small>
            </div>
            <button type="submit" class="btn btn-pay w-100"><i class="fas fa-lock"></i> Pay Now</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/index.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/style.css">
    <script>
        // Format card number with spaces every 4 digits
        document.getElementById('card_number').addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, ''); // Remove non-digit characters
            value = value.match(/.{1,4}/g)?.join(' ') || value; // Add spaces every 4 digits
            e.target.value = value;
        });

        // CVV validation function
        function validateCVV(value) {
            const errorElem = document.getElementById('card_cvv_error');
            errorElem.textContent = '';

            // Remove any non-digit characters
            value = value.replace(/\D/g, '');

            if (value === '') {
                errorElem.textContent = 'CVV is required.';
                return false;
            }

            if (!/^\d{3}$/.test(value)) {
                errorElem.textContent = 'CVV must be exactly 3 digits.';
                return false;
            }

            return true;
        }

        // Initialize Flatpickr for expiry date (month/year only, no day)
        flatpickr('#card_expiry', {
            dateFormat: "m/y",
            allowInput: true,
            plugins: [
                new window.monthSelectPlugin({
                    shorthand: true,
                    dateFormat: "m/y",
                    altFormat: "m/y"
                })
            ],
            onChange: function(selectedDates, dateStr, instance) {
                validateExpiryOnChange(dateStr);
            },
            onReady: function(selectedDates, dateStr, instance) {
                // Disable current month if current year is selected
                const now = new Date();
                const currentMonth = now.getMonth() + 1;
                const currentYear = now.getFullYear();
                
                // Disable all months before current month for current year
                for (let month = 1; month < currentMonth; month++) {
                    const date = new Date(currentYear, month - 1, 1);
                    instance.set('disable', [date]);
                }
            }
        });

        function validateExpiryOnChange(dateStr) {
            const errorElem = document.getElementById('card_expiry_error');
            errorElem.textContent = '';
            
            if (!/^\d{2}\/\d{2}$/.test(dateStr)) return;
            
            let [mm, yy] = dateStr.split('/');
            let expMonth = parseInt(mm, 10);
            let expYear = 2000 + parseInt(yy, 10);
            let now = new Date();
            let thisMonth = now.getMonth() + 1;
            let thisYear = now.getFullYear();

            if (expMonth < 1 || expMonth > 12) {
                errorElem.textContent = 'Invalid month in expiry date.';
            } else if (expYear < thisYear || (expYear === thisYear && expMonth <= thisMonth)) {
                errorElem.textContent = 'Expiry date must be after the current month.';
            }
        }

        function validatePaymentForm() {
            let isValid = true;

            const cardNumber = document.getElementById('card_number').value.replace(/\s/g, '').trim();
            const cardExpiry = document.getElementById('card_expiry').value.trim();
            const cardCVV = document.getElementById('card_cvv').value.trim();

            document.getElementById('card_number_error').textContent = '';
            document.getElementById('card_expiry_error').textContent = '';
            document.getElementById('card_cvv_error').textContent = '';

            if (cardNumber === '' || !/^\d{16}$/.test(cardNumber)) {
                document.getElementById('card_number_error').textContent = 'Card number must be 16 digits.';
                isValid = false;
            }
            if (cardExpiry === '' || !/^\d{2}\/\d{2}$/.test(cardExpiry)) {
                document.getElementById('card_expiry_error').textContent = 'Expiry date must be in MM/YY format.';
                isValid = false;
            } else {
                // Validate expiry date is not in the past or current month
                let [mm, yy] = cardExpiry.split('/');
                let expMonth = parseInt(mm, 10);
                let expYear = 2000 + parseInt(yy, 10);
                let now = new Date();
                let thisMonth = now.getMonth() + 1;
                let thisYear = now.getFullYear();

                if (expMonth < 1 || expMonth > 12) {
                    document.getElementById('card_expiry_error').textContent = 'Invalid month in expiry date.';
                    isValid = false;
                } else if (expYear < thisYear || (expYear === thisYear && expMonth <= thisMonth)) {
                    document.getElementById('card_expiry_error').textContent = 'Expiry date must be after the current month.';
                    isValid = false;
                }
            }
            if (!validateCVV(cardCVV)) {
                isValid = false;
            }

            return isValid;
        }
    </script>
</body>

</html>
