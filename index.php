<?php
    require_once "assets/includes/config.php";
    require_once "assets/includes/db.php";
?>

<!-- Home CSS -->
<style>
    /* Hero Carousel */
    #heroSlider {
        width: 100%;
    }

    #heroSlider .carousel-item {
        width: 100%;
    }

    #heroSlider .carousel-item img {
        width: 100%;
        height: auto;
        display: block;
        object-fit: contain; /* Prevents image cropping */
    }

    /* Mobile */
    @media (max-width:768px) {
        #heroSlider .carousel-item img {
            width: 100%;
            height: auto;
            object-fit: contain;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            width: 30px;
            height: 30px;
        }
    }

    /* Tablet */
    @media (min-width:769px) and (max-width:1024px) {
        #heroSlider .carousel-item img {
            width: 100%;
            height: auto;
            object-fit: contain;
        }
    }

    /* Desktop */
    @media (min-width:1025px) {
        #heroSlider .carousel-item img {
            width: 100%;
            height: auto;
            object-fit: contain;
        }
    }

    /* Section Title */
    .section-title h2 {
        font-family: 'Cinzel', serif;
        font-size: 32px;
    }

    .title-divider {
        width: 80px;
        height: 3px;
        background: #c9a227;
        margin: 10px auto;
    }

    /* Product Card */
    .product-card {
        background: #fff;
        border: 1px solid #e5e5e5;
        border-radius: 14px;
        padding: 20px;
        text-align: center;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .product-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.12);
        border-color: #000;
    }

    .product-card img {
        width: 100%;
        height: 240px;
        object-fit: contain;
        transition: transform 0.35s ease;
    }

    .product-card:hover img {
        transform: scale(1.05);
    }

    .product-card h5 {
        margin-top: 18px;
        font-size: 18px;
        font-weight: 600;
        color: #111;
        min-height: 52px;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .product-card h4 {
        margin: 10px 0;
        font-size: 22px;
        font-weight: 700;
        color: #000;
    }

    .stars {
        color: #000;
        font-size: 13px;
        margin-bottom: 15px;
    }

    .product-card .btn-outline-gold {
        border: 1px solid #000 !important;
        color: #000 !important;
        background: #fff !important;
        border-radius: 30px;
        padding: 10px 24px;
        font-weight: 500;
        transition: 0.3s;
        margin-top: auto;
    }

    .product-card .btn-outline-gold:hover {
        background: #000 !important;
        color: #fff !important;
        border-color: #000 !important;
    }

    /* Mobile */
    @media (max-width:768px) {
        .product-card {
            padding: 15px;
        }

        .product-card img {
            height: 180px;
        }

        .product-card h5 {
            font-size: 16px;
            min-height: 46px;
        }

        .product-card h4 {
            font-size: 20px;
        }

        .btn-outline-gold {
            width: 100%;
            padding: 10px;
        }
    }

    /* New Arrivals */
    .arrival-card {
        background: #fff;
        border: 1px solid #e8e8e8;
        border-radius: 14px;
        padding: 18px;
        overflow: hidden;
        text-align: center;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
    }

    .arrival-card:hover {
        transform: translateY(-6px);
        border-color: #000;
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12);
    }

    .arrival-card img {
        width: 100%;
        height: 250px;
        object-fit: contain;
        transition: transform 0.35s ease;
    }

    .arrival-card:hover img {
        transform: scale(1.05);
    }

    /* Mobile */
    @media (max-width: 768px) {
        .arrival-card {
            padding: 15px;
            border-radius: 12px;
        }

        .arrival-card img {
            height: 180px;
        }
    }

    /* Brands */
    .brand-card {
        background: #fff;
        padding: 20px;
        text-align: center;
        border: 1px solid #ddd;
    }

    .brand-card img {
        width: 120px;
    }

    /* Why Choose */
    .why-card {
        background: #fff;
        border: 1px solid #e5e5e5;
        border-radius: 12px;
        padding: 25px;
        text-align: center;
        transition: .3s;
        box-shadow: 0 4px 10px rgba(0, 0, 0, .05);
    }

    .why-card:hover {
        transform: translateY(-5px);
        border-color: #000;
        box-shadow: 0 8px 20px rgba(0, 0, 0, .12);
    }

    .why-card i {
        font-size: 40px;
        color: #000;
        margin-bottom: 15px;
    }

    .why-card h5 {
        color: #111;
        margin-bottom: 10px;
    }

    .why-card p {
        color: #666;
        font-size: 15px;
    }      
</style>

<!-- Header -->
<?php include 'assets/includes/header.php'; ?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="2000" id="heroSlider">
        <div class="carousel-indicators">
            <button class="active" data-bs-slide-to="0" data-bs-target="#heroSlider" type="button"></button>
            <button data-bs-slide-to="1" data-bs-target="#heroSlider" type="button"></button>
            <button data-bs-slide-to="2" data-bs-target="#heroSlider" type="button"></button>
            <button data-bs-slide-to="3" data-bs-target="#heroSlider" type="button"></button>
            <button data-bs-slide-to="4" data-bs-target="#heroSlider" type="button"></button>
            <button data-bs-slide-to="5" data-bs-target="#heroSlider" type="button"></button>
            <button data-bs-slide-to="6" data-bs-target="#heroSlider" type="button"></button>
            <button data-bs-slide-to="7" data-bs-target="#heroSlider" type="button"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <!-- Golden Carousel -->
                <img alt="Golden Carousel Image" class="d-block w-100" src="assets/Images/carousel-1.png"/>
            </div>
            <div class="carousel-item">
                <!-- Coffee Carousel -->
                <img alt="Coffee Carousel Image" class="d-block w-100" src="assets/Images/carousel-2.png"/>
            </div>
            <div class="carousel-item">
                <!-- Gold Submarine Carousel -->
                <img alt="Gold Submarine Carousel Image" class="d-block w-100" src="assets/Images/carousel-3.png"/>
            </div>
            <div class="carousel-item">
                <!-- Red Carousel -->
                <img alt="Red Carousel Image" class="d-block w-100" src="assets/Images/carousel-4.png"/>
            </div>
            <div class="carousel-item">
                <!-- Ice Carousel -->
                <img alt="Ice Carousel Image" class="d-block w-100" src="assets/Images/carousel-5.png"/>
            </div>
            <div class="carousel-item">
                <!-- Black and Green Carousel -->
                <img alt="Black and Green Carousel Image" class="d-block w-100" src="assets/Images/carousel-6.png"/>
            </div>
            <div class="carousel-item">
                <!-- Silver Carousel -->
                <img alt="Silver Carousel Image" class="d-block w-100" src="assets/Images/carousel-7.png"/>
            </div>
        </div>

        <!-- Carousel Controls -->
        <button class="carousel-control-prev" data-bs-slide="prev" data-bs-target="#heroSlider" type="button">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" data-bs-slide="next" data-bs-target="#heroSlider" type="button">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
</section>

<!-- Featured Collection Section -->
<section class="featured py-5">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2>FEATURED COLLECTION</h2>
            <div class="title-divider"></div>
        </div>

        <div class="row g-4">
            <!-- Product 1 -->
            <div class="col-lg-3 col-md-6 d-flex">
                <div class="product-card w-100">
                    <img alt="ROLEX DEEPSEA" class="img-fluid" src="assets/Images/watches/m136660-0005.png"/>
                    <h5>Rolex Deepsea D-Blue Dial</h5>
                    <h4>₹13,500.00</h4>
                    <div class="stars">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <a class="btn btn-outline-gold" href="product-details.php?id=20">VIEW DETAILS</a>
                </div>
            </div>

            <!-- Product 2 -->
            <div class="col-lg-3 col-md-6 d-flex">
                <div class="product-card w-100">
                    <img alt="ROLEX Sky-Dweller" class="img-fluid" src="assets/Images/watches/m126720vtnr-0001.png"/>
                    <h5>Rolex GMT-Master II Sprite</h5>
                    <h4>₹12,000.00</h4>
                    <div class="stars">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <a class="btn btn-outline-gold" href="product-details.php?id=15">VIEW DETAILS</a>
                </div>
            </div>

            <!-- Product 3 -->
            <div class="col-lg-3 col-md-6 d-flex">
                <div class="product-card w-100">
                    <img alt="ROLEX Cosmograph Daytona" class="img-fluid" src="assets/Images/watches/m126508-0008.png"/>
                    <h5>Rolex Cosmograph Daytona Gold</h5>
                    <h4>₹34,000.00</h4>
                    <div class="stars">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <a class="btn btn-outline-gold" href="product-details.php?id=7">VIEW DETAILS</a>
                </div>
            </div>

            <!-- Product 4 -->
            <div class="col-lg-3 col-md-6 d-flex">
                <div class="product-card w-100">
                    <img alt="ROLEX OYESTER PERPETUAL" class="img-fluid" src="assets/Images/watches/m228238-0054.png"/>
                    <h5>Rolex Day-Date 40 Diamond Pave</h5>
                    <h4>₹49,000.00</h4>
                    <div class="stars">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <a class="btn btn-outline-gold" href="product-details.php?id=23">VIEW DETAILS</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- New Arrivals Section -->
<section class="new-arrivals py-5">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2>NEW ARRIVALS</h2>
            <div class="title-divider"></div>
        </div>

        <div class="row g-4">
            <!-- Card 1 -->
            <div class="col-lg-3 col-md-6">
                <div class="arrival-card">
                    <img alt="Rolex Oyster Perpetual" class="img-fluid" src="assets/Images/New Arrivals/m124245rbr-0001.png"/>
                    <h5 class="text-center">Rolex Oyster Perpetual</h5>
                    <p class="text-center" style="font-size:14px; color:gray;">Everose Gold, Diamond Bezel & Chocolate Dial</p>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="col-lg-3 col-md-6">
                <div class="arrival-card">
                    <img alt="Rolex Oyster Perpetual" class="img-fluid" src="assets/Images/New Arrivals/m126000-0016.png"/>
                    <h5 class="text-center">Rolex Oyster Perpetual</h5>
                    <p class="text-center" style="font-size:14px; color:gray;">Celebration Dial / Bubble Dial</p>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="col-lg-3 col-md-6">
                <div class="arrival-card">
                    <img alt="Rolex Datejust" class="img-fluid" src="assets/Images/New Arrivals/m126283rbr-0041.png"/>
                    <h5 class="text-center">Rolex Datejust</h5>
                    <p class="text-center" style="font-size:14px; color:gray;">Two-Tone Yellow Rolesor, Diamond Bezel & Black Roman Dial</p>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="col-lg-3 col-md-6">
                <div class="arrival-card">
                    <img alt="ROLEX OYESTER PERPETUAL" class="img-fluid" src="assets/Images/New Arrivals/m126331-0026.png"/>
                    <h5 class="text-center">Rolex Datejust</h5>
                    <p class="text-center" style="font-size:14px; color:gray;">Two-Tone Everose Rolesor, Fluted Bezel & White Roman Dial</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Rolex Section -->
<section class="why-choose py-5">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2>WHY CHOOSE ROLEX?</h2>
            <div class="title-divider"></div>
        </div>
        <div class="row text-center g-4">
            <div class="col-lg-4 col-md-6">
                <div class="why-card">
                    <i class="bi bi-patch-check"></i>
                    <h4>ORIGINAL QUALITY</h4>
                    <p>We provide 100% authentic and original luxury watches.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="why-card">
                    <i class="bi bi-truck"></i>
                    <h4>FAST DELIVERY</h4>
                    <p>Safe and fast shipping across India. Lorem ipsum dolor sit.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="why-card">
                    <i class="bi bi-shield-lock"></i>
                    <h4>SECURE PAYMENT</h4>
                    <p>Multiple secure payment methods with full protection.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<?php include 'assets/includes/footer.php'; ?>