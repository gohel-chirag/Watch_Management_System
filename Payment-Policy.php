<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
?>

<!-- Payment Policy Styles -->
<style>
    /* Hero Section */
    .policy-hero {
        padding: 70px 10%;
        text-align: center;
        background: #ffffff;
    }
    .policy-hero img {
        width: 150px;
        margin: -10px auto 30px auto;
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
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 30px;
        padding: 60px 10%;
        background: #f5f5f5;
    }
    .policy-content div {
        background: #fff;
        padding: 30px;
        border: 1px solid #ddd;
        border-radius: 12px;
    }
    .policy-content h2 {
        font-family: 'Cinzel', serif;
        color: #000;
        font-size: 26px;
        margin-bottom: 15px;
    }
    .policy-content p {
        color: #555;
        font-size: 15px;
        line-height: 1.7;
        margin-bottom: 10px;
    }
    .policy-content ul {
        list-style-type: disc;
        margin-left: 20px;
        color: #555;
        font-size: 15px;
        line-height: 1.7;
    }

    /* COD Features */
    .cod-features {
        padding: 70px 10%;
        text-align: center;
        background: #fff;
    }
    .cod-features h2 {
        font-family: 'Cinzel', serif;
        font-size: 32px;
        color: #000;
        margin-bottom: 40px;
    }
    .cod-features article {
        display: inline-block;
        width: 22%;
        margin: 1%;
        padding: 25px 15px;
        background: #f8f8f8;
        border-radius: 12px;
        border: 1px solid #ddd;
        vertical-align: top;
    }
    .cod-features h3 {
        color: #000;
        font-size: 20px;
        margin-bottom: 10px;
    }
    .cod-features h3 i {
        display: block;
        font-size: 32px;
        margin-bottom: 15px;
        color: #000;
    }
    .cod-features p {
        color: #555;
        font-size: 14px;
        line-height: 1.6;
    }

    /* Policy Notice */
    .policy-notice {
        padding: 70px 10%;
        background: #000;
        text-align: center;
    }
    .policy-notice h2 {
        font-family: 'Cinzel', serif;
        font-size: 32px;
        color: #fff;
        margin-bottom: 25px;
    }
    .policy-notice h2 i {
        color: #fff;
        margin-right: 10px;
    }
    .policy-notice p {
        max-width: 850px;
        margin: 15px auto;
        color: #ddd;
        font-size: 15px;
        line-height: 1.7;
    }

    /* Responsive Queries */
    @media (max-width: 992px) {
        .policy-content {
            grid-template-columns: 1fr;
        }
        .cod-features article {
            width: 45%;
        }
    }
    @media (max-width: 768px) {
        .policy-hero {
            padding: 50px 5%;
        }
        .policy-hero h2 {
            font-size: 28px;
        }
        .policy-content {
            padding: 40px 5%;
        }
        .cod-features article {
            width: 100%;
            margin: 10px 0;
        }
        .policy-notice {
            padding: 50px 5%;
        }
    }
</style>

<!-- Header Include -->
<?php include 'assets/includes/header.php'; ?>

<!-- Hero Section -->
<section class="policy-hero">
    <h2>Payment Policy</h2>
    <p>
        At our store, we aim to provide a simple, secure, and hassle-free shopping experience. 
        To ensure complete trust and convenience for our customers, we currently offer 
        <strong>Cash on Delivery (COD)</strong> as our primary payment method.
    </p>
    <p>
        Pay for your luxury timepiece directly at your doorstep once it arrives. No advance online 
        payment is required.
    </p>
</section>

<!-- Policy Content -->
<section class="policy-content">
    <div>
        <h2>Cash on Delivery (COD)</h2>
        <p>Cash on Delivery allows you to pay for your order in cash at the time of actual delivery.</p>
        <p>This service ensures absolute peace of mind, as you only hand over the payment when your package is safely delivered by our courier partner.</p>
        <p>Please ensure you provide an accurate delivery address and contact number while placing your order to avoid any delays in delivery.</p>
    </div>
    <div>
        <h2>Terms & Conditions for COD</h2>
        <ul>
            <li>Payment must be made strictly in cash to the delivery executive upon receiving the parcel.</li>
            <li>Please keep the exact amount ready to ensure a smooth and quick handoff.</li>
            <li>Open delivery (opening the package before payment) is strictly not permitted as per courier guidelines.</li>
            <li>In case of any issues with the watch after delivery, you can easily request a return through our Returns Policy.</li>
        </ul>
    </div>
</section>

<!-- COD Process -->
<section class="cod-features">
    <h2>How COD Works</h2>
    <article>
        <h3><i class="fa-solid fa-cart-shopping"></i> 1. Place Order</h3>
        <p>Select your favorite timepiece and choose Cash on Delivery at checkout without any advance payment.</p>
    </article>
    <article>
        <h3><i class="fa-solid fa-truck-fast"></i> 2. Order Shipped</h3>
        <p>Your watch is carefully inspected, packed, and dispatched straight to your shipping address.</p>
    </article>
    <article>
        <h3><i class="fa-solid fa-house-chimney"></i> 3. Doorstep Delivery</h3>
        <p>Our delivery partner arrives with your package at your doorstep on the estimated date.</p>
    </article>
    <article>
        <h3><i class="fa-solid fa-money-bill-wave"></i> 4. Pay Cash</h3>
        <p>Hand over the exact cash amount to the delivery agent and receive your luxury timepiece.</p>
    </article>
</section>

<!-- Important Notice -->
<section class="policy-notice">
    <h2><i class="fa-solid fa-shield-halved"></i> Safe & Secure Transactions</h2>
    <p>
        We are committed to delivering genuine products and a transparent shopping experience. 
        With Cash on Delivery, your money stays safe with you until your order reaches your hands.
    </p>
    <p>For any questions or support regarding your payment and delivery, feel free to contact our Customer Care team.</p>
</section>

<!-- Footer Include -->
<?php include 'assets/includes/footer.php'; ?>