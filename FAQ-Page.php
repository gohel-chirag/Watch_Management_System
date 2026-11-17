<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
?>

<!-- FAQ CSS -->
<style>
    /* Hero Section */
    .faq-hero {
        padding: 70px 10%;
        text-align: center;
        background: #ffffff;
    }
    .faq-hero h2 {
        font-family: 'Cinzel', serif;
        font-size: 36px;
        color: #000;
        margin-bottom: 15px;
    }
    .faq-hero p {
        max-width: 850px;
        margin: 0 auto;
        color: #555;
        line-height: 1.7;
        font-size: 16px;
    }

    /* FAQ List */
    .faq-section {
        padding: 60px 10%;
        background: #f5f5f5;
    }
    .faq-container {
        max-width: 900px;
        margin: 0 auto;
    }
    .faq-item {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 12px;
        margin-bottom: 20px;
        padding: 25px 30px;
        transition: all 0.3s ease;
    }
    .faq-item:hover {
        border-color: #000;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }
    .faq-item h3 {
        font-family: 'Cinzel', serif;
        font-size: 20px;
        color: #000;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .faq-item h3 i {
        color: #000;
        font-size: 18px;
    }
    .faq-item p {
        color: #555;
        font-size: 15px;
        line-height: 1.7;
        margin: 0;
    }

    /* Support Callout */
    .faq-support {
        padding: 70px 10%;
        background: #000;
        text-align: center;
    }
    .faq-support h2 {
        font-family: 'Cinzel', serif;
        font-size: 32px;
        color: #fff;
        margin-bottom: 20px;
    }
    .faq-support p {
        max-width: 700px;
        margin: 0 auto 25px auto;
        color: #ddd;
        font-size: 15px;
        line-height: 1.7;
    }
    .faq-support .btn-contact {
        display: inline-block;
        padding: 12px 30px;
        background: #fff;
        color: #000;
        text-decoration: none;
        font-weight: 600;
        border-radius: 30px;
        transition: background 0.3s ease;
    }
    .faq-support .btn-contact:hover {
        background: #e8e8e8;
    }

    /* Responsive Styles */
    @media(max-width: 768px) {
        .faq-hero {
            padding: 50px 5%;
        }
        .faq-hero h2 {
            font-size: 28px;
        }
        .faq-section {
            padding: 40px 5%;
        }
        .faq-item {
            padding: 20px;
        }
        .faq-item h3 {
            font-size: 18px;
        }
        .faq-support {
            padding: 50px 5%;
        }
    }
</style>

<!-- Header Includes -->
<?php include 'assets/includes/header.php'; ?>

<!-- FAQ Hero Section -->
<section class="faq-hero">
    <h2>Frequently Asked Questions</h2>
    <p>
        Got questions? We've got answers. Explore our most common inquiries about orders, shipping, tracking, and our luxury timepieces.
    </p>
</section>

<!-- FAQ Content Section -->
<section class="faq-section">
    <div class="faq-container">
        <div class="faq-item">
            <h3><i class="fa-solid fa-truck-fast"></i> How can I track my order?</h3>
            <p>
                Once your order has been shipped, you will receive a tracking link via email and SMS. You can also log in to your account and track your shipment directly from the "My Orders" section.
            </p>
        </div>

        <div class="faq-item">
            <h3><i class="fa-solid fa-xmark"></i> Can I cancel or modify my order after placing it?</h3>
            <p>
                Yes, you can cancel your order within 2 hours of placing it through your account dashboard or by reaching out to our support team. Once the watch enters the dispatch process, cancellations cannot be made.
            </p>
        </div>

        <div class="faq-item">
            <h3><i class="fa-solid fa-rotate-left"></i> What is your return and refund policy?</h3>
            <p>
                We offer a 7-day hassle-free return policy for unworn watches in their original packaging with all documentation intact. Refunds are processed back to your original payment method within 5-7 business days after inspection.
            </p>
        </div>

        <div class="faq-item">
            <h3><i class="fa-solid fa-clock"></i> How long does delivery usually take?</h3>
            <p>
                Standard delivery typically takes 3 to 5 business days, depending on your location. Express delivery options are also available during checkout for faster delivery.
            </p>
        </div>

        <div class="faq-item">
            <h3><i class="fa-solid fa-shield-halved"></i> Do your luxury watches come with a warranty?</h3>
            <p>
                Yes, every timepiece purchased from us includes an official 2-year international warranty covering manufacturing defects and internal movement components.
            </p>
        </div>

        <div class="faq-item">
            <h3><i class="fa-solid fa-credit-card"></i> What payment methods do you accept?</h3>
            <p>
                We accept all major credit/debit cards, Net Banking, UPI payments (Google Pay, PhonePe, Paytm), and Cash on Delivery (COD) for eligible pincodes.
            </p>
        </div>
    </div>
</section>

<!-- Support Banner Section -->
<section class="faq-support">
    <h2><i class="fa-solid fa-headset"></i> Still Have Questions?</h2>
    <p>
        Our dedicated customer support team is here to assist you with any inquiries regarding our products, orders, or services.
    </p>
    <a href="contact.php" class="btn-contact">Contact Us</a>
</section>

<!-- Footer Includes -->
<?php include 'assets/includes/footer.php'; ?>