<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
?>
<!-- Styles -->
<style>
    .policy-hero {
        padding: 70px 10%;
        text-align: center;
        background: #ffffff;
    }
    .policy-hero h2 {
        font-family: 'Cinzel', serif;
        font-size: 36px;
        color: #000;
        margin-bottom: 20px;
    }
    .policy-hero p {
        max-width: 850px;
        margin: 15px auto;
        color: #555;
        line-height: 1.7;
        font-size: 16px;
    }
    .policy-highlights {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
        padding: 60px 10%;
        background: #f5f5f5;
    }
    .policy-card {
        background: #fff;
        padding: 30px;
        border: 1px solid #ddd;
        border-radius: 12px;
        text-align: center;
    }
    .policy-card i {
        font-size: 36px;
        color: #000;
        margin-bottom: 15px;
    }
    .policy-card h3 {
        font-family: 'Cinzel', serif;
        font-size: 20px;
        color: #000;
        margin-bottom: 10px;
    }
    .policy-card p {
        color: #555;
        font-size: 14px;
        line-height: 1.6;
    }
    .policy-details {
        padding: 70px 10%;
        background: #fff;
    }
    .policy-box {
        margin-bottom: 40px;
    }
    .policy-box h3 {
        font-family: 'Cinzel', serif;
        font-size: 24px;
        color: #000;
        margin-bottom: 15px;
        border-bottom: 2px solid #000;
        padding-bottom: 8px;
        display: inline-block;
    }
    .policy-box p, .policy-box ul {
        color: #555;
        font-size: 15px;
        line-height: 1.8;
    }
    .policy-box ul {
        list-style: disc;
        margin-left: 20px;
        margin-top: 10px;
    }
    .commitment {
        padding: 70px 10%;
        background: #000;
        text-align: center;
    }
    .commitment h2 {
        font-family: 'Cinzel', serif;
        font-size: 32px;
        color: #fff;
        margin-bottom: 25px;
    }
    .commitment p {
        max-width: 850px;
        margin: 15px auto;
        color: #ddd;
        font-size: 15px;
        line-height: 1.7;
    }
    @media(max-width: 992px) {
        .policy-highlights {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media(max-width: 768px) {
        .policy-hero, .policy-highlights, .policy-details, .commitment {
            padding: 40px 5%;
        }
        .policy-hero h2 {
            font-size: 28px;
        }
        .policy-highlights {
            grid-template-columns: 1fr;
        }
    }
</style>

<!-- Header -->
<?php include 'assets/includes/header.php'; ?>

<!-- Hero -->
<section class="policy-hero">
    <h2>Returns & Refund Policy</h2>
    <p>
        At our brand, customer satisfaction and luxury standards are paramount. 
        If you are not entirely satisfied with your purchase, we are here to assist you with a seamless return and refund process.
    </p>
</section>

<!-- Highlights -->
<section class="policy-highlights">
    <div class="policy-card">
        <i class="fa-solid fa-rotate-left"></i>
        <h3>7-Day Return Window</h3>
        <p>You can request a return within 7 calendar days from the date you receive your order.</p>
    </div>
    <div class="policy-card">
        <i class="fa-solid fa-truck-ramp-box"></i>
        <h3>Hassle-Free Pickups</h3>
        <p>Once approved, our team will arrange a secure courier pickup right from your doorstep.</p>
    </div>
    <div class="policy-card">
        <i class="fa-solid fa-credit-card"></i>
        <h3>Fast Refund Process</h3>
        <p>Refunds are initiated within 5 to 7 business days after inspection of the returned product.</p>
    </div>
</section>

<!-- Policy Details -->
<section class="policy-details">
    <div class="policy-box">
        <h3>Eligibility for Returns</h3>
        <p>To be eligible for a return, your luxury timepiece must meet the following conditions:</p>
        <ul>
            <li>The watch must be unworn, unused, and in the same condition as when received.</li>
            <li>It must be in its original packaging along with all documentation, certificates, warranty cards, and accessories.</li>
            <li>The original protective stickers and seals must remain intact.</li>
            <li>Customized, engraved, or altered watches cannot be returned.</li>
        </ul>
    </div>
    <div class="policy-box">
        <h3>Refund Processing</h3>
        <p>
            Once we receive your returned item, our expert quality assurance team will inspect it carefully. 
            Upon successful inspection:
        </p>
        <ul>
            <li><strong>Cash on Delivery (COD):</strong> For COD orders, refund details (Order Invoice) will be requested, and funds will be transferred via NEFT/UPI within 7 business days.</li>
        </ul>
    </div>
    <div class="policy-box">
        <h3>Damaged or Defective Items</h3>
        <p>
            In the rare event that your watch arrives damaged, defective, or incorrect, please notify our Customer Support within 24 hours of delivery with photos or video proof. We will arrange an immediate replacement or full refund.
        </p>
    </div>
</section>

<!-- Support Banner -->
<section class="commitment">
    <h2><i class="fa-solid fa-headset"></i> Need Assistance?</h2>
    <p>
        Our dedicated Customer Support team is here to guide you through every step of your return.
    </p>
    <p>
        Contact us at <strong>support@Rolex.com</strong> or call us at <strong>+91 9924011730</strong>.
    </p>
</section>

<!-- Footer -->
<?php include 'assets/includes/footer.php'; ?>