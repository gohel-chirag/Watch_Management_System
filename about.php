<!-- About CSS -->
<style>
    /* About CSS */
    .about-hero {
        padding: 70px 10%;
        text-align: center;
        background: #ffffff;
    }

    .about-hero img {
        width: 150px;
        margin: -10px auto 30px auto;
    }

    .about-hero h2 {
        font-family: 'Cinzel', serif;
        font-size: 36px;
        color: black;
        margin-bottom: 20px;
    }

    .about-hero p {
        max-width: 850px;
        margin: 15px auto;
        color: #555;
        line-height: 1.7;
        font-size: 16px;
    }

    /* About Content */
    .about-content {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 30px;
        padding: 60px 10%;
        background: #f5f5f5;
    }

    .about-content div {
        background: #fff;
        padding: 30px;
        border: 1px solid #ddd;
        border-radius: 12px;
    }

    .about-content h2 {
        font-family: 'Cinzel', serif;
        color: #000;
        font-size: 26px;
        margin-bottom: 15px;
    }

    .about-content p {
        color: #555;
        font-size: 15px;
        line-height: 1.7;
    }

    /* Core Values */
    .values {
        padding: 70px 10%;
        text-align: center;
        background: #fff;
    }

    .values h2 {
        font-family: 'Cinzel', serif;
        font-size: 32px;
        color: #000;
        margin-bottom: 40px;
    }

    .values article {
        display: inline-block;
        width: 22%;
        margin: 1%;
        padding: 25px 15px;
        background: #f8f8f8;
        border-radius: 12px;
        border: 1px solid #ddd;
    }

    .values h3 {
        color: #000;
        font-size: 20px;
    }

    .values h3 i {
        display: block;
        font-size: 32px;
        margin-bottom: 15px;
        color: #000;
    }

    .values p {
        color: #555;
        font-size: 14px;
        line-height: 1.6;
    }

    /* Commitment Section */
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

    .commitment h2 i {
        color: #fff;
        margin-right: 10px;
    }

    .commitment p {
        max-width: 850px;
        margin: 15px auto;
        color: #ddd;
        font-size: 15px;
        line-height: 1.7;
    }

    /* Responsive */
    @media(max-width:992px) {
        .about-content {
            grid-template-columns: 1fr;
        }

        .values article {
            width: 45%;
        }
    }

    @media(max-width:768px) {
        .about-hero {
            padding: 50px 5%;
        }

        .about-hero h2 {
            font-size: 28px;
        }

        .about-content {
            padding: 40px 5%;
        }

        .values article {
            width: 100%;
            margin: 10px 0;
        }

        .commitment {
            padding: 50px 5%;
        }
    }
</style>


<!-- Header -->
<?php include 'assets/includes/header.php'; ?>



<!-- About Main -->
<section class="about-hero">
    <div>
        <img alt="brand" class="img-fluid" src="assets\Images\Black-logo.png" />
    </div>
    <h2>Our Legacy</h2>
    <p>
        For generations, our brand has created exceptional timepieces that reflect
        elegance, precision, innovation, and timeless craftsmanship. Every watch
        represents our passion for quality and dedication to excellence.
    </p>
    <p>
        A luxury watch is more than a timekeeping instrument; it represents
        ambition, achievement, personality, and unforgettable moments. Each creation
        carries a story of skill, dedication, and refined artistry.
    </p>
    <p>
        By combining traditional watchmaking techniques with modern innovation, we
        create masterpieces that represent sophistication, prestige, and lasting
        value.
    </p>
</section>

<section class="about-content">
    <div>
        <h2>About Our Brand</h2>

        <p>
            Our journey began with a vision to create watches that combine traditional
            craftsmanship with modern technology. Today, we are recognized for
            quality, elegant designs, and exceptional attention to detail.
        </p>

        <p>
            Every timepiece is carefully crafted by skilled artisans who bring
            passion, experience, and precision to every component.
        </p>

        <p>
            We believe true luxury is created through patience, dedication, and expert
            craftsmanship.
        </p>

        <p>
            We focus on building lasting trust with our customers through quality,
            reliability, and exceptional service.
        </p>
    </div>

    <div>
        <h2>Our Vision</h2>
        <p>
            Our vision is to redefine luxury watchmaking by blending heritage,
            innovation, and extraordinary craftsmanship.
        </p>

        <p>
            We explore new designs, technologies, and techniques while preserving
            traditional watchmaking.
        </p>

        <p>
            Our goal is to build a legacy based on trust, creativity, and excellence.
        </p>
    </div>
</section>

<section class="values">
    <h2>Our Core Values</h2>

    <article>
        <h3><i class="fa-solid fa-bullseye"></i> Precision</h3>
        <p>
            Every mechanism is carefully engineered and tested to ensure accuracy,
            durability, and reliable performance.
        </p>
    </article>

    <article>
        <h3><i class="fa-solid fa-hammer"></i> Craftsmanship</h3>
        <p>
            Our artisans combine traditional skills with modern techniques to create
            watches with exceptional quality and detailed finishing.
        </p>
    </article>

    <article>
        <h3><i class="fa-solid fa-lightbulb"></i> Innovation</h3>
        <p>
            We embrace innovation by developing advanced technologies while respecting
            the heritage of watchmaking.
        </p>
    </article>

    <article>
        <h3><i class="fa-solid fa-crown"></i> Timeless Elegance</h3>
        <p>
            Our designs focus on classic beauty, refined details, and sophisticated
            style beyond trends.
        </p>
    </article>
</section>

<section class="commitment">
    <h2><i class="fa-solid fa-handshake"></i> Our Commitment</h2>
    <p>
        We are committed to delivering excellence through premium materials, skilled
        craftsmanship, and strict quality standards.
    </p>

    <p>
        Our mission is to create more than watches; we create symbols of
        achievement, legacy, and memories.
    </p>

    <p>
        Through continuous improvement and dedication, we preserve the art of luxury
        watchmaking.
    </p>
</section>


<!-- Footer -->
<?php include 'assets/includes/footer.php'; ?>