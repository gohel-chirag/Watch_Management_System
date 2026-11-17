<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
?>

<style>
    /* Hero Section */
    .shipping-hero {
        padding: 70px 10%;
        text-align: center;
        background: #ffffff;
    }
    .shipping-hero h2 {
        font-family: 'Cinzel', serif;
        font-size: 36px;
        color: #000;
        margin-bottom: 20px;
    }
    .shipping-hero p {
        max-width: 850px;
        margin: 15px auto;
        color: #555;
        line-height: 1.7;
        font-size: 16px;
    }

    /* Info Grid */
    .shipping-info {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 30px;
        padding: 60px 10%;
        background: #f5f5f5;
    }
    .shipping-card {
        background: #fff;
        padding: 35px 30px;
        border: 1px solid #ddd;
        border-radius: 12px;
        transition: all 0.3s ease;
    }
    .shipping-card:hover {
        border-color: #000;
        box-shadow: 0 8px 20px rgba(0,0,0,0.06);
    }
    .shipping-card h3 {
        font-family: 'Cinzel', serif;
        color: #000;
        font-size: 24px;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .shipping-card h3 i {
        font-size: 26px;
        color: #000;
    }
    .shipping-card p {
        color: #555;
        font-size: 15px;
        line-height: 1.7;
        margin-bottom: 10px;
    }
    .shipping-card ul {
        list-style: none;
        padding: 0;
        margin: 15px 0 0 0;
    }
    .shipping-card ul li {
        color: #555;
        font-size: 15px;
        line-height: 1.8;
        position: relative;
        padding-left: 22px;
        margin-bottom: 8px;
    }
    .shipping-card ul li::before {
        content: "•";
        color: #000;
        font-weight: bold;
        font-size: 18px;
        position: absolute;
        left: 0;
        top: -2px;
    }

    /* Note Banner */
    .shipping-note {
        padding: 70px 10%;
        background: #000;
        text-align: center;
    }
    .shipping-note h2 {
        font-family: 'Cinzel', serif;
        font-size: 32px;
        color: #fff;
        margin-bottom: 20px;
    }
    .shipping-note h2 i {
        color: #fff;
        margin-right: 10px;
    }
    .shipping-note p {
        max-width: 850px;
        margin: 15px auto;
        color: #ddd;
        font-size: 15px;
        line-height: 1.7;
    }

    /* Responsive Styles */
    @media(max-width: 992px) {
        .shipping-info {
            grid-template-columns: 1fr;
        }
    }
    @media(max-width: 768px) {
        .shipping-hero {
            padding: 50px 5%;
        }
        .shipping-hero h2 {
            font-size: 28px;
        }
        .shipping-info {
            padding: 40px 5%;
        }
        .shipping-note {
            padding: 50px 5%;
        }
    }
</style>

<!-- Header -->
<?php include 'assets/includes/header.php'; ?>

<!-- Hero Section -->
<section class="shipping-hero">
    <h2>Shipping & Delivery</h2>
    <p>
        We are committed to delivering your luxury timepiece safely, securely, and in a timely manner. Every shipment is handled with utmost care to ensure your order arrives in perfect condition.
    </p>
</section>

<!-- Content Grid -->
<section class="shipping-info">
    <div class="shipping-card">
        <h3><i class="fa-solid fa-truck-fast"></i> Delivery Timelines</h3>
        <p>
            We process all orders promptly to ensure quick dispatch and reliable delivery to your doorstep.
        </p>
        <ul>
            <li><strong>Standard Delivery:</strong> 3 to 7 business days across India.</li>
            <li><strong>Order Processing:</strong> Orders are dispatched within 24 to 48 hours of confirmation.</li>
            <li><strong>Metro Cities:</strong> Typically delivered within 3 to 4 business days.</li>
            <li><strong>Rest of India:</strong> Delivered within 5 to 7 business days.</li>
        </ul>
    </div>

    <div class="shipping-card">
        <h3><i class="fa-solid fa-credit-card"></i> Shipping Charges</h3>
        <p>
            We offer transparent shipping policies with no hidden fees at checkout.
        </p>
        <ul>
            <li><strong>Prepaid Orders:</strong> FREE express shipping on all prepaid orders.</li>
            <li><strong>Cash on Delivery (COD):</strong> Nominal flat charge of ₹100 applied at checkout.</li>
            <li><strong>Insured Transit:</strong> All packages are 100% insured against loss or damage during transit at no extra cost.</li>
        </ul>
    </div>

    <div class="shipping-card">
        <h3><i class="fa-solid fa-location-dot"></i> Order Tracking</h3>
        <p>
            Stay updated on the status of your delivery every step of the way.
        </p>
        <p>
            Once your order is shipped, you will receive an SMS and Email containing your unique tracking ID along with a direct link to track your parcel in real-time.
        </p>
    </div>

    <div class="shipping-card">
        <h3><i class="fa-solid fa-box-open"></i> Secure Packaging</h3>
        <p>
            Your luxury watch is packaged in a premium, tamper-evident box designed to protect the timepiece from shock, moisture, and handling during transit.
        </p>
        <p>
            Please do not accept the package if the outer seal is broken or tampered with upon delivery.
        </p>
    </div>
</section>

<!-- Note Banner -->
<section class="shipping-note">
    <h2><i class="fa-solid fa-shield-halved"></i> Safe & Secure Transit</h2>
    <p>
        Every timepiece we ship is fully insured until it reaches your hands. In the rare event of transit delay or damage, our customer support team is always available to assist you.
    </p>
</section>

<!-- Footer -->
<?php include 'assets/includes/footer.php'; ?>