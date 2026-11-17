<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'assets/includes/db.php'; 

$msg = "";
$msg_type = "";

// Get user details if logged in
$user_name = "";
$user_email = "";

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $user_query = "SELECT name, email FROM users WHERE id = '$user_id'";
    $user_result = mysqli_query($conn, $user_query);
    if ($user_result && mysqli_num_rows($user_result) > 0) {
        $user_data = mysqli_fetch_assoc($user_result);
        $user_name = $user_data['name'];
        $user_email = $user_data['email'];
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_message'])) {
    if (!isset($_SESSION['user_id'])) {
        $msg = "Please login first to send a message.";
        $msg_type = "danger";
    } else {
        $user_id = $_SESSION['user_id'];
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $subject = mysqli_real_escape_string($conn, $_POST['subject']);
        $message = mysqli_real_escape_string($conn, $_POST['message']);

        $sql = "INSERT INTO contact_messages (user_id, name, email, subject, message) VALUES ('$user_id', '$name', '$email', '$subject', '$message')";
        if (mysqli_query($conn, $sql)) {
            $msg = "Your message has been sent successfully!";
            $msg_type = "success";
        } else {
            $msg = "Something went wrong. Please try again.";
            $msg_type = "danger";
        }
    }
}
?>

<!-- Contact Styles -->
<style>
    .contact-hero {
        padding: 60px 10%;
        text-align: center;
        background: #fff;
    }
    .contact-hero h1 {
        font-family: 'Cinzel', serif;
        font-size: 36px;
        color: #000;
        margin-bottom: 15px;
    }
    .contact-hero p {
        color: #666;
        font-size: 16px;
        max-width: 700px;
        margin: auto;
        line-height: 1.6;
    }
    .contact-section {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        padding: 50px 10%;
        background: #f5f5f5;
    }
    .contact-info,
    .contact-form {
        background: #fff;
        padding: 30px;
        border: 1px solid #ddd;
        border-radius: 10px;
    }
    .contact-info h2,
    .contact-form h2 {
        font-family: 'Cinzel', serif;
        font-size: 26px;
        color: #000;
        margin-bottom: 20px;
    }
    .contact-info p,
    .contact-box p {
        color: #666;
        line-height: 1.6;
    }
    .contact-box {
        margin-top: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #ddd;
    }
    .contact-box i {
        font-size: 22px;
        color: #000;
    }
    .contact-box h3 {
        font-size: 18px;
        color: #111;
    }
    .contact-form input,
    .contact-form textarea {
        width: 100%;
        padding: 12px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 6px;
    }
    .contact-form button {
        background: #000;
        color: #fff;
        border: 1px solid transparent;
        padding: 12px 25px;
        border-radius: 25px;
        cursor: pointer;
        transition: 0.3s;
    }
    .contact-form button:hover {
        background: #fff;
        color: #000;
        border: 1px solid #000;
    }
    .login-alert {
        background: #fff3cd;
        color: #856404;
        padding: 15px;
        border: 1px solid #ffeeba;
        border-radius: 6px;
        margin-bottom: 20px;
        text-align: center;
    }
    .login-alert a {
        color: #856404;
        font-weight: bold;
        text-decoration: underline;
    }
    .alert-success {
        background: #d4edda;
        color: #155724;
        padding: 15px;
        border: 1px solid #c3e6cb;
        border-radius: 6px;
        margin-bottom: 20px;
    }
    .alert-danger {
        background: #f8d7da;
        color: #721c24;
        padding: 15px;
        border: 1px solid #f5c6cb;
        border-radius: 6px;
        margin-bottom: 20px;
    }
    .store-info {
        text-align: center;
        padding: 60px 10%;
        background: #fff;
    }
    .store-info h2 {
        font-family: 'Cinzel', serif;
        font-size: 30px;
        color: #000;
    }
    .store-info p {
        color: #666;
        line-height: 1.6;
    }
    .timing {
        margin-top: 25px;
        padding: 20px;
        background: #f5f5f5;
        border: 1px solid #ddd;
        border-radius: 10px;
    }
    .timing h3 {
        color: #000;
    }
    @media(max-width:768px) {
        .contact-section {
            grid-template-columns: 1fr;
            padding: 40px 5%;
        }
        .contact-hero h1 {
            font-size: 28px;
        }
        .contact-info,
        .contact-form {
            padding: 20px;
        }
    }
</style>

<!-- Header -->
<?php include 'assets/includes/header.php'; ?>

<!-- Hero Section -->
<section class="contact-hero">
    <h1>Contact Us</h1>
    <p>
        We are always here to assist you. Contact our team for any questions, watch
        details, services, or support.
    </p>
</section>

<!-- Main Contact Section -->
<section class="contact-section">
    <!-- Contact Info -->
    <div class="contact-info">
        <h2>Get In Touch</h2>
        <p>
        Experience luxury watch services with our dedicated support team. We are
        happy to help you with your requirements.
        </p>

        <div class="contact-box">
            <h3><i class="fa-solid fa-location-dot"></i> Address</h3>
            <p>
                ROLEX - Rajkot,<br />
                Gujarat, India
            </p>
        </div>

        <div class="contact-box">
            <h3><i class="fa-solid fa-phone"></i> Phone</h3>
            <p>+91 9924011730</p>
        </div>

        <div class="contact-box">
            <h3><i class="fa-solid fa-envelope"></i> Email</h3>
            <p>support@rolex.com</p>
        </div>
    </div>

    <!-- Contact Form -->
    <div class="contact-form">
        <h2>Send Message</h2>

        <?php if (!empty($msg)) { ?>
            <div class="alert-<?php echo $msg_type; ?>"><?php echo $msg; ?></div>
        <?php } ?>

        <?php if (!isset($_SESSION['user_id'])) { ?>
            <div class="login-alert">
                Please <a href="login.php">Login</a> to send us a message.
            </div>
            <form action="" method="POST">
                <input type="text" name="name" placeholder="Your Name" disabled required />
                <input type="email" name="email" placeholder="Your Email" disabled required />
                <input type="text" name="subject" placeholder="Subject" disabled required />
                <textarea rows="5" name="message" placeholder="Your Message" disabled required></textarea>
                <button type="button" onclick="alert('Please login first to send a message!'); window.location.href='login.php';">Send Message</button>
            </form>
        <?php } else { ?>
            <form action="" method="POST">
                <input type="text" name="name" value="<?php echo htmlspecialchars($user_name); ?>" placeholder="Your Name" required readonly />
                <input type="email" name="email" value="<?php echo htmlspecialchars($user_email); ?>" placeholder="Your Email" required readonly />
                <input type="text" name="subject" placeholder="Subject" required />
                <textarea rows="5" name="message" placeholder="Your Message" required></textarea>
                <button type="submit" name="submit_message">Send Message</button>
            </form>
        <?php } ?>
    </div>
</section>

<!-- Store Hours -->
<section class="store-info">
    <h2>Visit Our Boutique</h2>
    <p>
        Our specialists are available to guide you through our exclusive collections
        and provide personalized assistance.
    </p>

    <div class="timing">
        <h3>Opening Hours</h3>
        <p>Monday - Saturday : 10:00 AM - 7:00 PM</p>
        <p>Sunday : Closed</p>
    </div>
</section>

<!-- Footer -->
<?php include 'assets/includes/footer.php'; ?>