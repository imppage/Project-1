
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
    <h2 class="text-center mb-4 text-primary">Contact Us</h2>

    <div class="row">
        <!-- Contact Information -->
        <div class="col-md">
            <h4 class="text-info">Contact Information</h4>
            <ul class="list-group mb-4">
                <li class="list-group-item"><strong>Email:</strong> TreasureGifts@gmail.com</li>
                <li class="list-group-item"><strong>Phone:</strong> 01-4485936, 01-4429447</li>
                <li class="list-group-item"><strong>Address:</strong> Sanepa, Lalitpur</li>
            </ul>

            <h4 class="text-success">Our Location</h4>
            <!-- Optional: Embed Google Map -->
            <div class="embed-responsive embed-responsive-16by9 mb-4">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2976.399165796375!2d85.30444177458133!3d27.685269426466416!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb190dbf2aebcd%3A0x5ad4b845ab34f7fa!2sSanepa%20khari%20ko%20bot!5e1!3m2!1sen!2sus!4v1732808032584!5m2!1sen!2sus" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>            </div>
            <h4 class="text-warning">Get In Touch</h4>
            <p>We are here to assist you with any inquiries or feedback you may have. Feel free to reach out to us through the information mentioned. You can contact or email us using the information given and we'll get back to you shortly! Your curiosities and feedback really mean a lot to us. </p>
            <!-- <div class="alert alert-info" role="alert"> -->
                <!-- <strong>Note:</strong> Currently, we do not accept direct messages through the website, but we encourage you to use our email or contact number to reach out for any inquiries or assistance. -->
            <!-- </div> -->
            
            <p class="font-italic">We look forward to hearing from you!</p>
        </div>

        <!-- Message Section (without PHP mail) -->
        
    </div>
</div>

<?php include('../includes/footer.php'); ?>
