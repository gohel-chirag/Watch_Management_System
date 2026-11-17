<?php
session_start();
include 'assets/includes/db.php';

// Fetch watch details from database using URL ID
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $watch_id = mysqli_real_escape_string($conn, $_GET['id']);
    $query = "SELECT * FROM watches WHERE watch_id = '$watch_id'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $watch = mysqli_fetch_assoc($result);
    } else {
        header("Location: products.php");
        exit();
    }
} else {
    header("Location: products.php");
    exit();
}

// Handle Add to Cart submission
if (isset($_POST['add_to_cart'])) {
    // Redirect to login if user is not logged in
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }

    $user_id  = $_SESSION['user_id'];
    $quantity = intval($_POST['quantity']);

    // Check if item already exists in user's cart
    $check_cart = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = '$user_id' AND watch_id = '$watch_id'");

    if (mysqli_num_rows($check_cart) > 0) {
        // Update quantity if item exists
        $cart_row = mysqli_fetch_assoc($check_cart);
        $new_quantity = $cart_row['quantity'] + $quantity;

        // Ensure update does not exceed available stock
        if ($new_quantity <= $watch['stock']) {
            $update_cart = "UPDATE cart SET quantity = '$new_quantity' WHERE user_id = '$user_id' AND watch_id = '$watch_id'";
            mysqli_query($conn, $update_cart);
        }
    } else {
        // Insert new cart item
        $insert_cart = "INSERT INTO cart (user_id, watch_id, quantity) VALUES ('$user_id', '$watch_id', '$quantity')";
        mysqli_query($conn, $insert_cart);
    }

    header("Location: cart.php");
    exit();
}
?>

<!-- Product Details CSS -->
<style> 
    /* Product Layout */
    .product-details {
        width: 84%;
        margin: 60px auto;
        padding: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 70px;
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    }

    /* Product Image */
    .product-image {
        flex: 1;
        text-align: center;
    }
    .product-image img {
        width: 400px;
        max-width: 100%;
        height: auto;
        object-fit: contain;
        transition: 0.4s;
    }
    .product-image img:hover {
        transform: scale(1.05);
    }

    /* Product Info */
    .product-info {
        flex: 1;
    }
    .product-info h1 {
        font-size: 42px;
        color: #111;
        margin-bottom: 15px;
    }
    .product-info h2 {
        font-size: 28px;
        color: #000;
        margin: 20px 0;
    }
    .product-info p {
        color: #666;
        font-size: 16px;
        line-height: 1.7;
    }
    .product-info strong {
        color: #111;
    }
    .product-info label {
        display: block;
        margin: 20px 0 10px;
    }
    .product-info input {
        width: 60px;
        height: 40px;
        text-align: center;
        border: 1px solid #ddd;
        border-radius: 8px;
    }
    .product-info .add-cart-btn {
        display: inline-block;
        margin-top: 15px;
        text-align: center;
        width: 220px;
        padding: 14px 30px;
        background: #fff;
        color: #000;
        text-decoration: none;
        border: 1px solid #000;
        border-radius: 30px;
        cursor: pointer;
        transition: .3s;
    }
    .product-info .add-cart-btn:hover {
        background: #000;
        color: #fff;
    }

    /* Responsive Design */
    @media (max-width:768px){
        .product-details{
            width:92%;
            padding:30px 20px;
            flex-direction:column;
            gap:30px;
            text-align:center;
        }
        .product-image img{
            width:280px;
        }
        .product-info h1{
            font-size:32px;
        }
        .product-info h2{
            font-size:24px;
        }
        .product-info .add-cart-btn{
            width:100%;
        }
    }
</style>

<!-- Header -->
<?php include 'assets/includes/header.php'; ?>

<!-- Product Details Section -->
<section class="product-details">
    <div class="product-image">
        <img src="assets/Images/watches/<?php echo htmlspecialchars($watch['image']); ?>" 
             alt="<?php echo htmlspecialchars($watch['watch_name']); ?>">
    </div>

    <div class="product-info">
        <h1><?php echo htmlspecialchars($watch['watch_name']); ?></h1>
        <p>⭐⭐⭐⭐⭐</p>
        <h2>Price : ₹<?php echo number_format($watch['price'], 2); ?></h2>
        <p>
            <?php echo htmlspecialchars($watch['description']); ?>
        </p>
        <p><strong>Brand :</strong> Rolex</p>
        <p><strong>Stock :</strong> <?php echo ($watch['stock'] > 0) ? 'Available (' . $watch['stock'] . ')' : 'Out of Stock'; ?></p>
        
        <form action="" method="POST">
            <?php if ($watch['stock'] > 0): ?>
                <label><strong>Quantity :</strong></label>
                <input type="number" name="quantity" value="1" min="1" max="<?php echo $watch['stock']; ?>">
                <br><br>
                <button type="submit" name="add_to_cart" class="add-cart-btn">Add To Cart</button>
            <?php else: ?>
                <p class="text-danger fw-bold fs-5 mt-4">Sold Out</p>
                <p class="text mt-3" style="font-size:16px; color: gray;">Currently Unavailable</p>
            <?php endif; ?>
        </form>
    </div>
</section>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/script.js"></script>