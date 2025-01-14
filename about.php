
<head>
<script src="../includes/logout.js"></script>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<style>
        .buttons{
            background-color: #11114e;
            padding: .5rem 2rem;
            border-radius:.5rem;
            color: white;
        }
        .buttons:hover{
            color: white;
            box-shadow: rgba(20, 20, 20, 0.5) -5px 5px;
            text-decoration: none;
        }
        /* Ensure the logo image adjusts automatically */
        .navbar-brand {
            border-radius:100px;
        }
        .navbar-brand img {
            max-height: 60px; /* Maximum height of the logo */
            /* border-radius: 10px; */
            width: auto; /* Keep aspect ratio intact */
            height: auto; /* Maintain the original aspect ratio */
        }

        /* Optional: Adjust navbar height to ensure it looks good with the logo */
        .navbar {
            padding-top: 10px;
            padding-bottom: 10px;
        }
    </style>
</head>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
<a class="navbar-brand" href="../public/index.php" style="color:green;">
            <img src="../images/treasureGifts_logo.png" alt="TreasureGifts Logo"> <!-- Path to your logo -->
            TreasureGifts
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../public/user_dashboard.php">Home</a>
                </li>
                <li class="nav-item">
                    <!-- <a class="nav-link" href="../admin/login.php">Login</a> -->
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../public/cart.php">Cart</a>
                    <!-- <a class="nav-link" href="../public/register.php">Sign Up</a> -->
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../public/order_history.php">Order History</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../public/about.php">About Us</a>
                </li>
                <li class="nav-item">
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../public/contact.php">Contact Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="confirmLogOut()">Logout</a>
                </li>
            </ul>
        </div>
    </nav>


<div class="container mt-5">
    <h2 class="text-center mb-4 text-primary">About Us</h2>

    <!-- Introduction Section -->
    <div class="row mb-5">
        <div class="col-md-6">
        <h4 class="text-info">Welcome to Our Gift Shop!</h4>
        <p>At TreasureGifts, we specialize in providing unique and personalized gift sets that are perfect for every occasion. Whether you're celebrating a birthday, anniversary, holiday, or simply want to show someone you care, we have something special for you.</p>
        <p>We believe that the perfect gift can bring joy and create lasting memories. Our collection of thoughtfully curated gift items includes a wide variety of options, from luxury hampers to custom gift baskets, ensuring that you find the ideal present for your loved ones. We strive to make every occasion memorable with our exceptional service and high-quality products.</p>
        <p>Our team is passionate about creating the best gift experiences, and we take pride in offering products that are not only beautiful but also meaningful. Explore our collection and find the perfect gift for any moment.</p>
        </div>
        <div class="col-md-6">
            <img src="../images/gift_shop.webp" class="img-fluid rounded shadow-lg" alt="Gift Shop" style="border-radius: 15px;">
        </div>
    </div>

    <!-- Mission Section -->
    <div class="mb-5">
        <h4 class="text-success">Our Mission</h4>
        <p>Our mission is to offer the best curated gift sets that bring joy and excitement to every recipient. We focus on quality, uniqueness, and a personal touch in every gift. Our goal is to make gift-giving as special as the moment itself.</p>
    </div>

    <!-- Why Choose Us Section -->
    <div class="mb-5">
        <h4 class="text-warning">Why Choose Us?</h4>
        <ul class="list-group">
            <li class="list-group-item"><i class="fas fa-check-circle text-success"></i> Carefully selected gift sets for every occasion</li>
            <li class="list-group-item"><i class="fas fa-check-circle text-success"></i> Affordable prices with premium quality</li>
            <li class="list-group-item"><i class="fas fa-check-circle text-success"></i> Personalized options to make gifts extra special</li>
            <li class="list-group-item"><i class="fas fa-check-circle text-success"></i> Fast and reliable delivery right to your doorstep</li>
            <li class="list-group-item"><i class="fas fa-check-circle text-success"></i> Secure and simple online shopping experience</li>
        </ul>
    </div>

    <!-- Our Values Section -->
    <div class="mb-5">
        <h4 class="text-danger">Our Values</h4>
        <p>At TreasureGifts, we believe in integrity, exceptional customer service, and providing memorable gift experiences. We take pride in making every gift-giving moment special, ensuring that our customers are completely satisfied with their purchases.</p>
    </div>

    <!-- Our Team Section -->
    <div class="mb-5">
        <h4 class="text-primary">Meet Our Team</h4>
        <p>We are a passionate team of gift enthusiasts committed to bringing joy through thoughtfully curated gift sets. We focus on delivering quality, creativity, and a personal touch in everything we do. Let us help you express your love and appreciation through perfect gifts!</p>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
