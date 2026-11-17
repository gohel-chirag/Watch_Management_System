<?php
session_start();
include 'assets/includes/db.php';

// Redirect to login if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Remove item from cart
if (isset($_GET['remove'])) {
    $cart_id = mysqli_real_escape_string($conn, $_GET['remove']);
    mysqli_query($conn, "DELETE FROM cart WHERE cart_id = '$cart_id' AND user_id = '$user_id'");
    header("Location: cart.php");
    exit();
}

// Update item quantity
if (isset($_POST['update_qty'])) {
    $cart_id = mysqli_real_escape_string($conn, $_POST['cart_id']);
    $qty = intval($_POST['quantity']);
    if ($qty > 0) {
        mysqli_query($conn, "UPDATE cart SET quantity = '$qty' WHERE cart_id = '$cart_id' AND user_id = '$user_id'");
    }
    header("Location: cart.php");
    exit();
}

// Fetch cart items from database
$cart_query = "SELECT c.cart_id, c.quantity, w.watch_id, w.watch_name, w.price, w.image, w.stock 
                FROM cart c 
                JOIN watches w ON c.watch_id = w.watch_id 
                WHERE c.user_id = '$user_id'";
$cart_result = mysqli_query($conn, $cart_query);
$grand_total = 0;
?>

<!-- Cart CSS -->
<style>
    .cart-section {
        width: 85%;
        margin: 60px auto;
        padding: 40px;
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }

    .cart-section h1 {
        font-size: 40px;
        color: #111;
        margin-bottom: 30px;
        font-family: "Cinzel", serif;
    }

    .cart-img {
        width: 90px;
        height: 90px;
        object-fit: contain;
    }

    .table {
        border-radius: 15px;
        overflow: hidden;
    }

    .table th {
        padding: 18px;
        background: #000;
        color: #fff;
    }

    .table td {
        padding: 20px;
        vertical-align: middle;
    }

    .qty {
        width: 70px;
        padding: 8px;
        text-align: center;
        border: 1px solid #ddd;
        border-radius: 8px;
    }

    .remove-btn {
        padding: 8px 18px;
        background: #fff;
        color: #000;
        border: 1px solid #000;
        border-radius: 25px;
        transition: 0.3s;
        text-decoration: none;
        display: inline-block;
    }

    .remove-btn:hover {
        background: #000;
        color: #fff;
    }

    .total-box {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 30px;
        padding: 25px;
        border-top: 1px solid #ddd;
    }

    .total-box h2 {
        font-size: 30px;
    }

    .cart-btn {
        display: inline-block;
        padding: 14px 35px;
        margin-right: 10px;
        background: #fff;
        color: #000;
        text-align: center;
        text-decoration: none;
        border: 1px solid #000;
        border-radius: 30px;
        transition: 0.3s;
    }

    .cart-btn:hover {
        background: #000;
        color: #fff;
        text-decoration: none;
    }

    @media (max-width: 768px) {
        .cart-section {
            width: 95%;
            padding: 20px;
        }

        .cart-section h1 {
            font-size: 32px;
        }

        .cart-btn {
            display: flex;
            justify-content: center;
            margin-bottom: 15px;
        }

        .table {
            font-size: 14px;
        }

        .total-box {
            flex-direction: column;
            gap: 20px;
        }
    }
</style>

<!-- Header -->
<?php include 'assets/includes/header.php'; ?>

<!-- Cart Section -->
<section class="cart-section">
    <h1>Cart</h1>
    <div class="table-responsive">
        <table class="table text-center">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Remove</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if ($cart_result && mysqli_num_rows($cart_result) > 0) {
                    while ($row = mysqli_fetch_assoc($cart_result)) {
                        $subtotal = $row['price'] * $row['quantity'];
                        $grand_total += $subtotal;
                ?>
                <tr>
                    <td>
                        <img class="cart-img" src="assets/Images/watches/<?php echo htmlspecialchars($row['image']); ?>"
                            alt="<?php echo htmlspecialchars($row['watch_name']); ?>">
                    </td>
                    <td>
                        <?php echo htmlspecialchars($row['watch_name']); ?>
                    </td>
                    <td>₹
                        <?php echo number_format($row['price'], 2); ?>
                    </td>
                    <td>
                        <form action="" method="POST" class="d-flex justify-content-center align-items-center gap-2">
                            <input type="hidden" name="cart_id" value="<?php echo $row['cart_id']; ?>">
                            <input type="number" class="qty" value="<?php echo $row['quantity']; ?>" readonly
                                style="background-color: transparent; border: none; text-align: center; width: 60px;">
                            <input type="hidden" name="update_qty" value="1">
                        </form>
                    </td>
                    <td>₹
                        <?php echo number_format($subtotal, 2); ?>
                    </td>
                    <td>
                        <a href="cart.php?remove=<?php echo $row['cart_id']; ?>" class="remove-btn"
                            onclick="return confirm('Are you sure you want to remove this item?');">Remove</a>
                    </td>
                </tr>
                <?php 
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center py-4'>Your cart is empty.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="total-box">
        <h2>Total</h2>
        <h2>₹
            <?php echo number_format($grand_total, 2); ?>
        </h2>
    </div>
    <div class="text-end">
        <a href="products.php" class="cart-btn">Continue Shopping</a>
        <?php if ($grand_total > 0): ?>
        <a href="checkout.php" class="cart-btn">Checkout</a>
        <?php endif; ?>
    </div>
</section>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/script.js"></script>