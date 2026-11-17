<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
?>

<!-- Privacy Policy CSS -->
<style>
    /* Hero Section */
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

    /* Policy Content */
    .policy-content {
        padding: 60px 10%;
        background: #f5f5f5;
    }

    .policy-card {
        background: #fff;
        padding: 35px;
        border: 1px solid #ddd;
        border-radius: 12px;
        margin-bottom: 30px;
    }

    .policy-card h3 {
        font-family: 'Cinzel', serif;
        color: #000;
        font-size: 22px;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .policy-card h3 i {
        color: #000;
        font-size: 20px;
    }

    .policy-card p, .policy-card ul {
        color: #555;
        font-size: 15px;
        line-height: 1.7;
    }

    .policy-card ul {
        padding-left: 20px;
        margin-top: 10px;
    }

    .policy-card ul li {
        margin-bottom: 8px;
    }

    /* Contact Section */
    .policy-contact {
        padding: 60px 10%;
        background: #000;
        text-align: center;
        color: #fff;
    }

    .policy-contact h2 {
        font-family: 'Cinzel', serif;
        font-size: 32px;
        color: #fff;
        margin-bottom: 20px;
    }

    .policy-contact p {
        max-width: 850px;
        margin: 10px auto;
        color: #ddd;
        font-size: 15px;
        line-height: 1.7;
    }

    /* Responsive Styles */
    @media(max-width: 768px) {
        .policy-hero {
            padding: 50px 5%;
        }
        .policy-hero h2 {
            font-size: 28px;
        }
        .policy-content {
            padding: 40px 5%;
        }
        .policy-card {
            padding: 20px;
        }
        .policy-contact {
            padding: 50px 5%;
        }
    }
</style>

<!-- Header -->
<?php include 'assets/includes/header.php'; ?>

<!-- Hero Section -->
<section class="policy-hero">
    <h2>Privacy Policy</h2>
    <p>
        At our luxury watch store, we value your trust and are committed to protecting your personal information. This Privacy Policy outlines how we collect, use, and safeguard your data when you visit or make a purchase from our website.
    </p>
</section>

<!-- Policy Content -->
<section class="policy-content">
    <div class="policy-card">
        <h3><i class="fa-solid fa-database"></i> Information We Collect</h3>
        <p>
            When you interact with our website, we may collect the following types of information:
        </p>
        <ul>
            <li><strong>Personal Information:</strong> Name, email address, phone number, shipping address, and billing details provided during checkout or account creation.</li>
            <li><strong>Technical Data:</strong> IP address, browser type, device information, and browsing activity collected via cookies to enhance your experience.</li>
        </ul>
    </div>

    <div class="policy-card">
        <h3><i class="fa-solid fa-user-gear"></i> How We Use Your Information</h3>
        <p>
            We use the collected information for specific and legitimate business purposes, including:
        </p>
        <ul>
            <li>Processing and delivering your order seamlessly.</li>
            <li>Sending order updates, invoices, and customer service communications.</li>
            <li>Improving our website performance, security, and product offerings.</li>
            <li>Sending promotional offers and newsletters (only if you have opted in).</li>
        </ul>
    </div>

    <div class="policy-card">
        <h3><i class="fa-solid fa-shield-halved"></i> Data Protection & Security</h3>
        <p>
            We implement strict security measures to keep your personal data safe. Your payment details are encrypted using advanced SSL encryption technology. We never store credit/debit card numbers on our servers, and we do not sell or rent your personal information to third parties.
        </p>
    </div>

    <div class="policy-card">
        <h3><i class="fa-solid fa-cookie-bite"></i> Cookies Policy</h3>
        <p>
            Our website uses cookies to store your preferences, remember items in your cart, and offer a personalized shopping journey. You can choose to disable cookies through your browser settings, though some website features may not function properly.
        </p>
    </div>

    <div class="policy-card">
        <h3><i class="fa-solid fa-user-shield"></i> Your Rights</h3>
        <p>
            You have the right to access, update, or request the deletion of your personal data at any time. If you wish to make changes to your account information or unsubscribe from marketing emails, you can do so through your account settings or by reaching out to us.
        </p>
    </div>
</section>

<!-- Contact Section -->
<section class="policy-contact">
    <h2><i class="fa-solid fa-envelope"></i> Questions About Privacy?</h2>
    <p>
        If you have any questions, concerns, or requests regarding this Privacy Policy and your data, please contact our support team.
    </p>
    <p>
        <strong>Email:</strong> support@Rolex.com | <strong>Phone:</strong> +91 9924011730
    </p>
</section>

<!-- Footer -->
<?php include 'assets/includes/footer.php'; ?>