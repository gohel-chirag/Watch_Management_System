<?php
    // Session check
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Database Connection Include
    include_once 'assets/includes/db.php';

    $newsletter_msg = "";
    $newsletter_msg_type = "";

    // Newsletter Submit Logic
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_newsletter'])) {
        if (!isset($_SESSION['user_id'])) {
            $newsletter_msg = "Please login first to subscribe.";
            $newsletter_msg_type = "danger";
        } else {
            $newsletter_email = mysqli_real_escape_string($conn, $_POST['newsletter_email']);
            
            // Check if already subscribed
            $check_sql = "SELECT * FROM newsletter_subscribers WHERE email = '$newsletter_email'";
            $check_res = mysqli_query($conn, $check_sql);
            
            if (mysqli_num_rows($check_res) > 0) {
                $newsletter_msg = "You are already subscribed!";
                $newsletter_msg_type = "warning";
            } else {
                $insert_sql = "INSERT INTO newsletter_subscribers (email) VALUES ('$newsletter_email')";
                if (mysqli_query($conn, $insert_sql)) {
                    $newsletter_msg = "Thank you for subscribing!";
                    $newsletter_msg_type = "success";
                } else {
                    $newsletter_msg = "Something went wrong. Please try again.";
                    $newsletter_msg_type = "danger";
                }
            }
        }
    }
?>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="row gy-5">

            <!-- Logo -->
            <div class="col-lg-4">
                <img alt="Logo" class="footer-logo img-fluid" src="assets\Images\Logo.png">
                <p class="disclaimer-text">
                    <strong>Disclaimer:</strong> This website is created solely for educational and academic
                    purposes as a college project. All product names, trademarks, logos, and images used on this
                    website are the property of their respective owners. No copyright infringement is intended, and
                    this project is not affiliated with, endorsed by, or sponsored by Rolex SA or any other brand.
                </p>
                <div class="social-icons">
                    <a href="https://www.facebook.com/rolex" target="_blank">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="https://www.instagram.com/rolex" target="_blank">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="https://x.com/ROLEX" target="_blank">
                        <i class="bi bi-twitter-x"></i>
                    </a>
                    <a href="https://www.youtube.com/rolex" target="_blank">
                        <i class="bi bi-youtube"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-2">
                <h5>Quick Links</h5>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="products.php">Products</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="my-orders.php">My Orders</a></li>
                </ul>
            </div>

            <!-- Customer Care -->
            <div class="col-lg-3">
                <h5>Customer Care</h5>
                <ul>
                    <li><a href="FAQ-Page.php">FAQ</a></li>
                    <li><a href="Shipping-Delivery.php">Shipping &amp; Delivery</a></li>
                    <li><a href="Returns-Refunds.php">Returns &amp; Refunds</a></li>
                    <li><a href="Payment-Policy.php">Payment Policy</a></li>
                    <li><a href="Privacy-Policy.php">Privacy Policy</a></li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div class="col-lg-3">
                <h5>Newsletter</h5>
                <p>Subscribe for new arrivals and exclusive offers.</p>

                <?php if (!empty($newsletter_msg)) { ?>
                    <div class="alert alert-<?php echo $newsletter_msg_type; ?> p-2 small text-center mb-2">
                        <?php echo $newsletter_msg; ?>
                    </div>
                <?php } ?>

                <?php if (!isset($_SESSION['user_id'])) { ?>
                    <!-- Guest Form -->
                    <form onsubmit="event.preventDefault(); alert('Please login first to subscribe!'); window.location.href='login.php';">
                        <input class="form-control mb-3" placeholder="Enter your email" type="email" disabled required />
                        <button class="btn subscribe-btn w-100" type="submit">SUBSCRIBE</button>
                    </form>
                <?php } else { ?>
                    <!-- Logged In Form -->
                    <form action="" method="POST">
                        <input class="form-control mb-3" name="newsletter_email" placeholder="Enter your email" type="email" required />
                        <button class="btn subscribe-btn w-100" type="submit" name="submit_newsletter">SUBSCRIBE</button>
                    </form>
                <?php } ?>
            </div>
        </div>
    </div>
</footer>

<!-- Copyright -->
<section class="copyright">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 text-center mt-3 text-lg-start">
                © 2026 ROLEX. All Rights Reserved.<br>
                <p>Developed By : Chirag Gohel</p>
            </div>
            <div class="col-lg-6 text-center text-lg-end">
                <img alt="Payment" class="img-fluid payment-img" src="assets\Images\payment-logo.png">
            </div>
        </div>
    </div>
</section>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/script.js"></script>
</body>
</html>