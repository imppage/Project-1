<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TreasureGifts</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Ensure the logo image adjusts automatically */
        .navbar-brand {
            border-radius:20px;
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
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <!-- Add the logo image here beside the website name -->
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
                    <a class="nav-link" href="../public/index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../admin/login.php">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../public/register.php">Sign Up</a>
                </li>
                <li class="nav-item">
                    <!-- <a class="nav-link" href="../public/cart.php">Cart</a> -->
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../public/about.php">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../public/contact.php">Contact Us</a>
                </li>
            </ul>
        </div>
    </nav>
</body>
</html>
