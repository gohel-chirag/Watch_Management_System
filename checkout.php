<?php
session_start();
include 'assets/includes/db.php';

// Redirect to login if user is not authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = "";

// Fetch user details
$user_name = "";
$user_phone = "";
$user_query = "SELECT * FROM users WHERE id = '$user_id'";
$user_res = mysqli_query($conn, $user_query);
if ($user_res && mysqli_num_rows($user_res) > 0) {
    $u_data = mysqli_fetch_assoc($user_res);
    $user_name  = isset($u_data['name']) ? $u_data['name'] : (isset($u_data['username']) ? $u_data['username'] : '');
    $user_phone = isset($u_data['phone']) ? $u_data['phone'] : '';
}

// Fetch cart items
$cart_query = "SELECT c.cart_id, c.quantity, w.watch_name, w.price 
                FROM cart c 
                JOIN watches w ON c.watch_id = w.watch_id 
                WHERE c.user_id = '$user_id'";
$cart_result = mysqli_query($conn, $cart_query);
$grand_total = 0;

// Save address on form submit
if (isset($_POST['place_order'])) {
    $name    = mysqli_real_escape_string($conn, $_POST['name']);
    $phone   = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $city    = mysqli_real_escape_string($conn, $_POST['city']);
    $state   = mysqli_real_escape_string($conn, $_POST['state']);
    $pincode = mysqli_real_escape_string($conn, $_POST['pincode']);

    $insert_address = "INSERT INTO user_addresses (user_id, name, phone, address, city, state, pincode) 
                        VALUES ('$user_id', '$name', '$phone', '$address', '$city', '$state', '$pincode')";

    if (mysqli_query($conn, $insert_address)) {
        $address_id = mysqli_insert_id($conn);
        $_SESSION['address_id'] = $address_id;
        header("Location: payment.php");
        exit();
    } else {
        $message = "<div class='alert alert-danger'>Failed to save address. Please try again.</div>";
    }
}
?>

<!-- Checkout CSS -->
<style>
    .checkout-section {
        width: 85%;
        margin: 60px auto;
        padding: 50px;
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }
    .checkout-section h1 {
        font-size: 40px;
        color: #111;
        margin-bottom: 35px;
        font-family: "Cinzel", serif;
    }
    .checkout-box {
        padding: 30px;
        border: 1px solid #eee;
        border-radius: 15px;
        height: 100%;
    }
    .checkout-box h2 {
        font-size: 28px;
        margin-bottom: 25px;
        color: #111;
    }
    .form-control {
        height: 45px;
        border-radius: 8px;
        border: 1px solid #ddd;
    }
    .form-control:focus {
        border-color: #000;
        box-shadow: none;
    }
    .order-table th {
        background: #000;
        color: #fff;
    }
    .order-table td,
    .order-table th {
        padding: 15px;
        text-align: center;
    }
    .total-price {
        display: flex;
        justify-content: space-between;
        border-top: 1px solid #ddd;
        margin-top: 20px;
        padding-top: 20px;
    }
    .total-price h3 {
        font-size: 25px;
    }
    .payment-btn {
        display: inline-block;
        width: 100%;
        margin-top: 25px;
        padding: 14px;
        background: #fff;
        color: #000;
        text-align: center;
        text-decoration: none;
        border: 1px solid #000;
        border-radius: 30px;
        transition: 0.3s;
        cursor: pointer;
    }
    .payment-btn:hover {
        background: #000;
        color: #fff;
        text-decoration: none;
    }
    @media (max-width: 768px) {
        .checkout-section {
            width: 95%;
            padding: 25px;
        }
        .checkout-section h1 {
            font-size: 32px;
        }
        .checkout-box {
            margin-bottom: 25px;
        }
    }
</style>

<!-- Header -->
<?php include 'assets/includes/header.php'; ?>

<!-- Checkout Section -->
<section class="checkout-section">
    <h1>Checkout</h1>
    <?php echo $message; ?>

    <form action="" method="POST">
        <div class="row g-4">
            <div class="col-lg-7">
                <div class="checkout-box">
                    <h2>Delivery Address</h2>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter Name" value="<?php echo htmlspecialchars($user_name); ?>" required />
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control" placeholder="Enter Phone" value="<?php echo htmlspecialchars($user_phone); ?>" required />
                        </div>

                        <div class="col-12 mb-3">
                            <label>Address</label>
                            <textarea name="address" class="form-control" rows="3" placeholder="Enter Address" required></textarea>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>City</label>
                            <input type="text" name="city" class="form-control" placeholder="City" required />
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>State</label>
                            <input type="text" name="state" class="form-control" placeholder="State" required />
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Pincode</label>
                            <input type="text" name="pincode" class="form-control" placeholder="Pincode" required />
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="checkout-box">
                    <h2>Order Summary</h2>
                    <table class="table order-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if ($cart_result && mysqli_num_rows($cart_result) > 0) {
                                while ($item = mysqli_fetch_assoc($cart_result)) {
                                    $subtotal = $item['price'] * $item['quantity'];
                                    $grand_total += $subtotal;
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['watch_name']); ?> (x<?php echo $item['quantity']; ?>)</td>
                                <td>₹<?php echo number_format($subtotal, 2); ?></td>
                            </tr>
                            <?php 
                                }
                            } else {
                                echo "<tr><td colspan='2'>Your cart is empty.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>

                    <div class="total-price">
                        <h3>Total</h3>
                        <h3>₹<?php echo number_format($grand_total, 2); ?></h3>
                    </div>
                    <button type="submit" name="place_order" class="payment-btn">Continue Payment</button>
                </div>
            </div>
        </div>
    </form>
</section>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/script.js"></script>