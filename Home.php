<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driving School Management</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    body {
        font-family: 'Roboto', sans-serif;
    }

    /* Header Styles */
    .top-nav {
        background-color: #fff;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 20px 40px;
    }

    .top-nav .navbar-brand {
        font-weight: bold;
    }

    .top-nav .nav-link {
        color: #333;
        font-weight: bold;
        margin-left: 20px;
    }

    /* Flex container for nav links */
    .top-nav .nav-links {
        display: flex;
        align-items: center;
    }

    /* Hero Section */
    .hero {
        background: #f2f2f2;
        padding: 60px 40px;
        text-align: center;
    }

    .hero h1 {
        font-size: 48px;
        font-weight: 700;
    }

    .hero p {
        font-size: 20px;
        margin: 20px 0;
    }

    .hero .cta-button {
        background-color: #ff5a5f;
        color: white;
        padding: 15px 30px;
        border: none;
        border-radius: 5px;
        text-decoration: none;
    }

    /* Packages Section */
    .packages-section {
        background: #fff;
        padding: 60px 40px;
        text-align: center;
    }

    .packages-section h2 {
        font-size: 36px;
        margin-bottom: 20px;
    }

    .packages-card {
        background-color: #f9f9f9;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin: 10px;
    }

    .packages-card h3 {
        font-size: 24px;
        margin-bottom: 15px;
    }

    .packages-card .price {
        font-size: 32px;
        margin: 10px 0;
    }

    .packages-card p {
        font-size: 16px;
    }

    .packages-card .cta-button {
        background-color: #ff5a5f;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        text-decoration: none;
    }

    /* Testimonial Section */
    .testimonial-section {
        background: #fff;
        padding: 60px 40px;
        text-align: center;
    }

    .testimonial-carousel {
        display: flex;
        overflow-x: auto;
        scroll-behavior: smooth;
    }

    .testimonial-item {
        padding: 20px;
        background: #f9f9f9;
        margin-right: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        min-width: 300px;
    }

    /* Image Gallery Section */
    .image-gallery {
        background: #f2f2f2;
        padding: 60px 40px;
    }

    .image-gallery img {
        width: 100%;
        height: auto;
        border-radius: 10px;
        transition: transform 0.3s ease;
    }

    .image-gallery img:hover {
        transform: scale(1.05);
    }

    .gallery-item {
        padding: 10px;
        box-sizing: border-box;
    }
    
</style>

</head>
<body>

    <!-- Header -->
    <div class="top-nav d-flex justify-content-between align-items-center">
        <a class="navbar-brand" href="Home.php">Driving School</a>
        <div class="nav-links">
            <a href="Home.php" class="nav-link">Home</a>
            <a href="login_form.php" class="nav-link">Login</a>
            <a href="register_form.php" class="nav-link">Register</a>
            <a href="feedback.php" class="nav-link">Feedback</a>
            <a href="chatbot/index.php" class="nav-link">Chatbot</a>

           

        </div>
    </div>

    <!-- Hero Section -->
    <div class="hero">
        <h1>Drive Safe, Drive Smart</h1>
        <p>We make it easier for you to get your driver's license</p>
        <a href="register_form.php" class="cta-button">Get Started</a>
    </div>

    <div class="image-gallery">
    <h2 class="text-center">Our Services</h2>
    <div class="row">
        <div class="col-md-3 gallery-item">
            <a href="register_form.php">
                <img src="https://static.vecteezy.com/system/resources/previews/015/618/036/original/driving-school-with-education-process-of-car-training-and-learning-to-drive-to-get-drivers-license-in-flat-cartoon-hand-drawn-templates-illustration-vector.jpg" alt="Login Illustration">
            </a>
        </div>
        <div class="col-md-3 gallery-item">
            <a href="register_form.php">
                <img src="https://static.vecteezy.com/system/resources/previews/015/618/058/non_2x/driving-school-with-education-process-of-car-training-and-learning-to-drive-to-get-drivers-license-in-flat-cartoon-hand-drawn-templates-illustration-vector.jpg" alt="Driving Illustration">
            </a>
        </div>
        <div class="col-md-3 gallery-item">
            <a href="register_form.php">
                <img src="https://static.vecteezy.com/system/resources/previews/015/618/046/non_2x/driving-school-with-education-process-of-car-training-and-learning-to-drive-to-get-drivers-license-in-flat-cartoon-hand-drawn-templates-illustration-vector.jpg" alt="Driving Car">
            </a>
        </div>
        <div class="col-md-3 gallery-item">
            <a href="register_form.php">
                <img src="https://static.vecteezy.com/system/resources/previews/015/618/053/non_2x/driving-school-with-education-process-of-car-training-and-learning-to-drive-to-get-drivers-license-in-flat-cartoon-hand-drawn-templates-illustration-vector.jpg" alt="Driver License">
            </a>
        </div>
    </div>
</div>


    <!-- Packages Section -->
    <div class="packages-section">
        <h2>Our Packages</h2>
        <div class="row justify-content-center">
            <div class="col-md-4 packages-card">
                <h3>1 Year Package</h3>
                <div class="price">₹15000.00</div>
                <p>This package includes 1 year of driving lessons and practice sessions.</p>
                <p>Duration: 1 Year</p>
                <a href="register_form.php" class="cta-button">Select Package</a>
            </div>
            <div class="col-md-4 packages-card">
                <h3>6 Month Package</h3>
                <div class="price">₹10000.00</div>
                <p>This package includes 6 months of driving lessons and practice sessions.</p>
                <p>Duration: 6 Months</p>
                <a href="register_form.php" class="cta-button">Select Package</a>
            </div>
            <div class="col-md-4 packages-card">
                <h3>3 Month Package</h3>
                <div class="price">₹5000.00</div>
                <p>This package includes 3 months of driving lessons and practice sessions.</p>
                <p>Duration: 3 Months</p>
                <a href="register_form.php" class="cta-button">Select Package</a>
            </div>
        </div>
    </div>

    <!-- Testimonial Section -->
    <div class="testimonial-section">
        <h2>What Our Students Say</h2>
        <div class="testimonial-carousel">
            <div class="testimonial-item">
                <p>"Great driving school! The instructors are very professional and helpful."</p>
                <p>- Alex Smith</p>
            </div>
            <div class="testimonial-item">
                <p>"I had a fantastic experience. Highly recommend this place for learning to drive."</p>
                <p>- Sarah Johnson</p>
            </div>
            <div class="testimonial-item">
                <p>"The process was smooth, and I got my license quickly. Excellent service."</p>
                <p>- Michael Brown</p>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
