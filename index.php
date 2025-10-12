<?php
require 'register/SuiteCRMClient.php'; // Your SuiteCRMClient PHP class
$error = "";


$selectFields = ['name', 'phone_office', 'id', 'ownership','address','email1','employees','rating','description','passport_url'];
    // Instantiate and login SuiteCRM client
    $crmClient = new SuiteCRMClient();

    try {
        $crmClient->login();

        // Search the Amdon_Dealers module for record with matching unique_code
            $entry = $crmClient->searchRecords(
                'AMD_Members',
                "name <> ''",
                 $selectFields,
                'date_entered ASC',
                0,
                10
            );
        // var_dump($entry);
        // exit;
    } catch (Exception $e) {
        $error = "Error fetching data: " . $e->getMessage();
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- meta tags -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- title -->
    <title>Oyo State AMDON Portal</title>

    <!-- favicon -->
    <link rel="icon" type="image/x-icon" href="assets/img/logo/favicon.png">

    <!-- css -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/all-fontawesome.min.css">
    <link rel="stylesheet" href="assets/css/flaticon.css">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.min.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/jquery-ui.min.css">
    <link rel="stylesheet" href="assets/css/nice-select.min.css">
    <link rel="stylesheet" href="assets/css/style.css">

</head>

<body>

    <!-- preloader -->
    <div class="preloader">
        <div class="loader-ripple">
            <div></div>
            <div></div>
        </div>
    </div>
    <!-- preloader end -->


    <!-- header area -->
    <header class="header">
        <!-- top header -->
        <div class="header-top">
            <div class="container">
                <div class="header-top-wrapper">
                    <div class="header-top-left">
                        <div class="header-top-contact">
                            <ul>
                                <li><a href="https://live.themewild.com/cdn-cgi/l/email-protection#d9b0b7bfb699bca1b8b4a9b5bcf7bab6b4"><i class="far fa-envelopes"></i>
                                        <span class="__cf_email__" data-cfemail="4f262129200f2a372e223f232a612c2022">oyo@amdon.com.ng</span></a></li>
                                <li><a href="tel:+21236547898"><i class="far fa-phone-volume"></i> +2 123 654 7898</a>
                                </li>
                                <li><a href="#"><i class="far fa-alarm-clock"></i> Sun - Fri (08AM - 10PM)</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="header-top-right">
                        <div class="header-top-link">
                            <a href="register"><i class="far fa-arrow-right-to-arc"></i> Login</a>
                            <a href="register"><i class="far fa-user-vneck"></i> Register</a>
                        </div>
                        <div class="header-top-social">
                            <span>Follow Us: </span>
                            <a href="#"><i class="fab fa-facebook"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="main-navigation">
            <nav class="navbar navbar-expand-lg">
                <div class="container position-relative">
                    <a class="navbar-brand" href="index-2.html">
                        <img src="assets/img/logo/logo.png" alt="logo">
                    </a>
                    <div class="mobile-menu-right">
                        <div class="search-btn">
                            <button type="button" class="nav-right-link"><i class="far fa-search"></i></button>
                        </div>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#main_nav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-mobile-icon"><i class="far fa-bars"></i></span>
                        </button>
                    </div>
                    <div class="collapse navbar-collapse" id="main_nav">
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link" href="#" data-bs-toggle="dropdown">Home</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#about">About US</a></li>
                            <li class="nav-item">
                                <a class="nav-link" href="#dealers">Dealers</a>
                            </li>
                            <!--<li class="nav-item"><a class="nav-link" href="#team">Our Excos</a></li>-->
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                        </ul>
                        <div class="nav-right">
                           <!--  <div class="search-btn">
                                <button type="button" class="nav-right-link"><i class="far fa-search"></i></button>
                            </div>
                            <div class="cart-btn">
                                <a href="#" class="nav-right-link"><i class="far fa-cart-plus"></i><span></span></a>
                            </div> -->
                            <div class="nav-right-btn mt-2">
                                <a href="register" class="theme-btn"><span class="far fa-plus-circle"></span>Register / Login</a>
                            </div>
                            <!-- <div class="sidebar-btn">
                                <button type="button" class="nav-right-link"><i class="far fa-bars-sort"></i></button>
                            </div> -->
                        </div> 
                    </div>
                    <!-- search area 
                    <div class="search-area">
                        <form action="#">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Type Keyword...">
                                <button type="submit" class="search-icon-btn"><i class="far fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                    search area end -->
                </div>
            </nav>
        </div>
    </header>
    <!-- header area end -->

      <main class="main">

        <!-- hero slider -->
        <div class="hero-section">
            <div class="hero-slider owl-carousel owl-theme">
                <div class="hero-single" style="background: url(assets/img/slider/slider-1.jpg)">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-lg-6">
                                <div class="hero-content">
                                    <h6 class="hero-sub-title" data-animation="fadeInUp" data-delay=".25s">Welcome To
                                        AMDON Oyo State!</h6>
                                    <h1 class="hero-title" data-animation="fadeInRight" data-delay=".50s">
                                        Best Place To Find Your <span>Dream</span> Cars.
                                    </h1>
                                    <p data-animation="fadeInLeft" data-delay=".75s">
                                        Sellers of vehicles Brand new and imported fairly used popularly know as tokunbo in Nigeria.
                                    </p>
                                    <div class="hero-btn" data-animation="fadeInUp" data-delay="1s">
                                        <a href="register" class="theme-btn">Register Now<i
                                                class="fas fa-arrow-right-long"></i></a>
                                        <a href="register" class="theme-btn theme-btn2">Login Now<i
                                                class="fas fa-arrow-right-long"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6">
                                <div class="hero-right">
                                    <div class="hero-img">
                                        <img src="assets/img/slider/hero-1.png" alt="" data-animation="fadeInRight"
                                            data-delay=".25s">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hero-single" style="background: url(assets/img/slider/slider-2.jpg)">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-md-12 col-lg-6">
                                <div class="hero-content">
                                    <h6 class="hero-sub-title" data-animation="fadeInUp" data-delay=".25s">Welcome To
                                        AMDON Oyo State!</h6>
                                    <h1 class="hero-title" data-animation="fadeInRight" data-delay=".50s">
                                        Trusted and Verified  <span>Car</span> Dealers.
                                    </h1>
                                    <p data-animation="fadeInLeft" data-delay=".75s">
                                        Sellers of vehicles Brand new and imported fairly used popularly know as tokunbo in Nigeria.
                                    </p>
                                    <div class="hero-btn" data-animation="fadeInUp" data-delay="1s">
                                        <a href="register" class="theme-btn">Register Now<i
                                                class="fas fa-arrow-right-long"></i></a>
                                        <a href="register" class="theme-btn theme-btn2">Login Now<i
                                                class="fas fa-arrow-right-long"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6">
                                <div class="hero-right">
                                    <div class="hero-img">
                                        <img src="assets/img/slider/hero-2.png" alt="" data-animation="fadeInRight"
                                            data-delay=".25s">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- hero slider end -->

        <!-- about area -->
        <div class="about-area pt-50" id="about">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="about-left wow fadeInLeft" data-wow-delay=".25s">
                            <div class="about-img">
                                <img src="assets/img/about/01.png" alt="">
                            </div>
                            <div class="about-experience">
                                <div class="about-experience-icon">
                                    <i class="flaticon-car"></i>
                                </div>
                                <b>AMDON <br> OYO STATE</b>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="about-right wow fadeInRight" data-wow-delay=".25s">
                            <div class="site-heading mb-3">
                                <span class="site-title-tagline justify-content-start">
                                    <i class="flaticon-drive"></i> About Us
                                </span>
                                <h2 class="site-title">
                                    Association of <span>Motor Dealer</span> of Nigeria (AMDON) Oyo State.
                                </h2>
                            </div>
                            <p class="about-text">
                                 The unbralla body for all importers and sellers of vehicles especially the imported fairly used popularly know as tokunbo in Nigeria. it is the solitary body having the supreme capacity to propel the innovation of automobile industry in Nigeria.
                            </p>
                            <p class="about-text">
                                 We are registered under the CAMA Act of the corporate affair commission of the federal republic of Nigeria to engaged in the promotion and protection of Car dealings, to develop a tangible Law of automobile industry, and good governance in Nigeria.
                            </p>
                           <!--  <div class="about-list-wrapper">
                                <ul class="about-list list-unstyled">
                                    <li>
                                    </li>
                                    <li>
                                        Established fact that a reader will be distracted.
                                    </li>
                                    <li>
                                        Sed ut perspiciatis unde omnis iste natus sit.
                                    </li>
                                </ul>
                            </div> -->
                            <a href="#" class="theme-btn mt-4">Discover More<i
                                    class="fas fa-arrow-right-long"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- about area end -->


        <!-- counter area -->
        <div class="counter-area pt-30 pb-30">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-sm-6">
                        <div class="counter-box">
                            <div class="icon">
                                <i class="flaticon-car-rental"></i>
                            </div>
                            <div>
                                <span class="counter" data-count="+" data-to="15000" data-speed="30000">15000</span>
                                <h6 class="title">+ Available Cars </h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="counter-box">
                            <div class="icon">
                                <i class="flaticon-car-key"></i>
                            </div>
                            <div>
                                <span class="counter" data-count="+" data-to="90000" data-speed="30000">90000</span>
                                <h6 class="title">+ Happy Clients</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 d-none d-md-block">
                        <div class="counter-box">
                            <div class="icon">
                                <i class="flaticon-screwdriver"></i>
                            </div>
                            <div>
                                <span class="counter" data-count="+" data-to="1500" data-speed="3000">1500</span>
                                <h6 class="title">+ Car Dealers</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 d-none d-md-block">
                        <div class="counter-box">
                            <div class="icon">
                                <i class="flaticon-review"></i>
                            </div>
                            <div>
                                <span class="counter" data-count="+" data-to="30" data-speed="3000">30</span>
                                <h6 class="title">+ Years Of Experience</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- car dealer -->
        <div class="car-dealer pt-50" id="dealers">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mx-auto">
                        <div class="site-heading text-center">
                            <span class="site-title-tagline"><i class="flaticon-drive"></i> Motor Dealers</span>
                            <h2 class="site-title">Verified AMDON Members In <span>Oyo State</span></h2>
                            <div class="heading-divider"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <?php foreach ($entry as $result): ?>
                     <?php
                        $fields = $result['name_value_list'];
                        // var_dump($fields);
                        // exit;
                        $fullName = '';
                        $phone = '';
                        $dealer = '';
                        foreach ($fields as $field) {
                            if ($field['name'] === 'ownership') $dealer = htmlspecialchars($field['value']);
                            if ($field['name'] === 'phone_office') $phone = htmlspecialchars($field['value']);
                            if ($field['name'] === 'description') $address = htmlspecialchars($field['value']);
                        }
                    ?>
                    <div class="col-md-6 col-lg-3">
                        <div class="dealer-item wow fadeInUp" data-wow-delay=".25s">
                            <div class="dealer-img">
                                <span class="dealer-listing">Verified</span>
                                <img src="assets/img/dealer/01.png" alt="">
                            </div>
                            <div class="dealer-content">
                                <h4><a href="#"><?= $dealer ?></a></h4>
                                <ul>
                                    <li><i class="far fa-location-dot"></i> <?= $address ?></li>
                                    <li><i class="far fa-phone"></i> <a href="tel:$phone"><?= $phone ?></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <div class="col-md-6 col-lg-3">
                        <div class="dealer-item wow fadeInUp" data-wow-delay=".50s">
                            <div class="dealer-img">
                                <span class="dealer-listing">Verified</span>
                                <img src="assets/img/dealer/02.png" alt="">
                            </div>
                            <div class="dealer-content">
                                <h4><a href="#">Keithson Car</a></h4>
                                <ul>
                                    <li><i class="far fa-location-dot"></i> 25/B Milford Road, New York</li>
                                    <li><i class="far fa-phone"></i> <a href="tel:+21236547898">+2 123 654 7898</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="dealer-item wow fadeInUp" data-wow-delay=".75s">
                            <div class="dealer-img">
                                <span class="dealer-listing">Verified</span>
                                <img src="assets/img/dealer/03.png" alt="">
                            </div>
                            <div class="dealer-content">
                                <h4><a href="#">Superious Automotive</a></h4>
                                <ul>
                                    <li><i class="far fa-location-dot"></i> 25/B Milford Road, New York</li>
                                    <li><i class="far fa-phone"></i> <a href="tel:+21236547898">+2 123 654 7898</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="dealer-item wow fadeInUp" data-wow-delay="1s">
                            <div class="dealer-img">
                                <span class="dealer-listing">Verified</span>
                                <img src="assets/img/dealer/04.png" alt="">
                            </div>
                            <div class="dealer-content">
                                <h4><a href="#">Racing Gear Car</a></h4>
                                <ul>
                                    <li><i class="far fa-location-dot"></i> 25/B Milford Road, New York</li>
                                    <li><i class="far fa-phone"></i> <a href="tel:+21236547898">+2 123 654 7898</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="dealer-item wow fadeInUp" data-wow-delay=".25s">
                            <div class="dealer-img">
                                <span class="dealer-listing">Verified</span>
                                <img src="assets/img/dealer/05.png" alt="">
                            </div>
                            <div class="dealer-content">
                                <h4><a href="#">Car Showromio</a></h4>
                                <ul>
                                    <li><i class="far fa-location-dot"></i> 25/B Milford Road, New York</li>
                                    <li><i class="far fa-phone"></i> <a href="tel:+21236547898">+2 123 654 7898</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="dealer-item wow fadeInUp" data-wow-delay=".50s">
                            <div class="dealer-img">
                                <span class="dealer-listing">Verified</span>
                                <img src="assets/img/dealer/06.png" alt="">
                            </div>
                            <div class="dealer-content">
                                <h4><a href="#">Fastspeedio Car</a></h4>
                                <ul>
                                    <li><i class="far fa-location-dot"></i> 25/B Milford Road, New York</li>
                                    <li><i class="far fa-phone"></i> <a href="tel:+21236547898">+2 123 654 7898</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="dealer-item wow fadeInUp" data-wow-delay=".75s">
                            <div class="dealer-img">
                                <span class="dealer-listing">Verified</span>
                                <img src="assets/img/dealer/07.png" alt="">
                            </div>
                            <div class="dealer-content">
                                <h4><a href="#">Star AutoMall</a></h4>
                                <ul>
                                    <li><i class="far fa-location-dot"></i> 25/B Milford Road, New York</li>
                                    <li><i class="far fa-phone"></i> <a href="tel:+21236547898">+2 123 654 7898</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="dealer-item wow fadeInUp" data-wow-delay="1s">
                            <div class="dealer-img">
                                <span class="dealer-listing">Verified</span>
                                <img src="assets/img/dealer/08.png" alt="">
                            </div>
                            <div class="dealer-content">
                                <h4><a href="#">Superspeed Auto</a></h4>
                                <ul>
                                    <li><i class="far fa-location-dot"></i> 25/B Milford Road, New York</li>
                                    <li><i class="far fa-phone"></i> <a href="tel:+21236547898">+2 123 654 7898</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- car dealer end-->
        <!-- video area -->
        <div class="video-area pb-120 d-none d-md-block">
            <div class="container-fluid px-0">
                <div class="video-content" style="background-image: url(assets/img/video/01.jpg);">
                    <div class="row align-items-center">
                        <div class="col-lg-12">
                            <div class="video-wrapper">
                                <a class="play-btn popup-youtube" href="https://www.youtube.com/watch?v=ckHzmP1evNU">
                                    <i class="fas fa-play"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- video area end -->


        <!-- car category -->
        <div class="car-category">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mx-auto">
                        <div class="site-heading text-center">
                            <span class="site-title-tagline"><i class="flaticon-drive"></i> Car Category</span>
                            <h2 class="site-title">Car By Body <span>Types</span></h2>
                            <div class="heading-divider"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 col-md-4 col-lg-2">
                        <a href="#" class="category-item wow fadeInUp" data-wow-delay=".25s">
                            <div class="category-img">
                                <img src="assets/img/category/01.png" alt="">
                            </div>
                            <h5>Sedan</h5>
                        </a>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2">
                        <a href="#" class="category-item wow fadeInUp" data-wow-delay=".50s">
                            <div class="category-img">
                                <img src="assets/img/category/02.png" alt="">
                            </div>
                            <h5>Compact</h5>
                        </a>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2">
                        <a href="#" class="category-item wow fadeInUp" data-wow-delay=".75s">
                            <div class="category-img">
                                <img src="assets/img/category/03.png" alt="">
                            </div>
                            <h5>Convertible</h5>
                        </a>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2">
                        <a href="#" class="category-item wow fadeInUp" data-wow-delay="1s">
                            <div class="category-img">
                                <img src="assets/img/category/04.png" alt="">
                            </div>
                            <h5>SUV</h5>
                        </a>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2">
                        <a href="#" class="category-item wow fadeInUp" data-wow-delay="1.25s">
                            <div class="category-img">
                                <img src="assets/img/category/05.png" alt="">
                            </div>
                            <h5>Crossover</h5>
                        </a>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2">
                        <a href="#" class="category-item wow fadeInUp" data-wow-delay="1.50s">
                            <div class="category-img">
                                <img src="assets/img/category/06.png" alt="">
                            </div>
                            <h5>Wagon</h5>
                        </a>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2">
                        <a href="#" class="category-item wow fadeInUp" data-wow-delay=".25s">
                            <div class="category-img">
                                <img src="assets/img/category/07.png" alt="">
                            </div>
                            <h5>Sports</h5>
                        </a>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2">
                        <a href="#" class="category-item wow fadeInUp" data-wow-delay=".50s">
                            <div class="category-img">
                                <img src="assets/img/category/08.png" alt="">
                            </div>
                            <h5>Pickup</h5>
                        </a>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2">
                        <a href="#" class="category-item wow fadeInUp" data-wow-delay=".75s">
                            <div class="category-img">
                                <img src="assets/img/category/09.png" alt="">
                            </div>
                            <h5>Family MPV</h5>
                        </a>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2">
                        <a href="#" class="category-item wow fadeInUp" data-wow-delay="1s">
                            <div class="category-img">
                                <img src="assets/img/category/10.png" alt="">
                            </div>
                            <h5>Coupe</h5>
                        </a>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2">
                        <a href="#" class="category-item wow fadeInUp" data-wow-delay="1.25s">
                            <div class="category-img">
                                <img src="assets/img/category/11.png" alt="">
                            </div>
                            <h5>Electric</h5>
                        </a>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2">
                        <a href="#" class="category-item wow fadeInUp" data-wow-delay="1.50s">
                            <div class="category-img">
                                <img src="assets/img/category/12.png" alt="">
                            </div>
                            <h5>Luxury</h5>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- car category end-->


        <!-- car brand 
        <div class="car-brand py-120">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mx-auto">
                        <div class="site-heading text-center">
                            <span class="site-title-tagline"><i class="flaticon-drive"></i> Popular Brands</span>
                            <h2 class="site-title">Our Top Quality <span>Brands</span></h2>
                            <div class="heading-divider"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 col-md-3 col-lg-2">
                        <a href="#" class="brand-item wow fadeInUp" data-wow-delay=".25s">
                            <div class="brand-img">
                                <img src="assets/img/brand/01.png" alt="">
                            </div>
                            <h5>Ferrari</h5>
                        </a>
                    </div>
                    <div class="col-6 col-md-3 col-lg-2">
                        <a href="#" class="brand-item wow fadeInUp" data-wow-delay=".50s">
                            <div class="brand-img">
                                <img src="assets/img/brand/02.png" alt="">
                            </div>
                            <h5>Hyundai</h5>
                        </a>
                    </div>
                    <div class="col-6 col-md-3 col-lg-2">
                        <a href="#" class="brand-item wow fadeInUp" data-wow-delay=".75s">
                            <div class="brand-img">
                                <img src="assets/img/brand/03.png" alt="">
                            </div>
                            <h5>Mercedes Benz</h5>
                        </a>
                    </div>
                    <div class="col-6 col-md-3 col-lg-2">
                        <a href="#" class="brand-item wow fadeInUp" data-wow-delay="1s">
                            <div class="brand-img">
                                <img src="assets/img/brand/04.png" alt="">
                            </div>
                            <h5>Toyota</h5>
                        </a>
                    </div>
                    <div class="col-6 col-md-3 col-lg-2">
                        <a href="#" class="brand-item wow fadeInUp" data-wow-delay="1.25s">
                            <div class="brand-img">
                                <img src="assets/img/brand/05.png" alt="">
                            </div>
                            <h5>BMW</h5>
                        </a>
                    </div>
                    <div class="col-6 col-md-3 col-lg-2">
                        <a href="#" class="brand-item wow fadeInUp" data-wow-delay="1.50s">
                            <div class="brand-img">
                                <img src="assets/img/brand/06.png" alt="">
                            </div>
                            <h5>Nissan</h5>
                        </a>
                    </div>
                </div>
            </div>
        </div>
         car brand end-->
    </main>



    <!-- footer area -->
    <footer class="footer-area">
        <div class="footer-widget">
            <div class="container">
                <div class="row footer-widget-wrapper pt-100 pb-70">
                    <div class="col-md-6 col-lg-4">
                        <div class="footer-widget-box about-us">
                            <a href="#" class="footer-logo">
                                <img src="assets/img/logo/logo-light.png" alt="">
                            </a>
                            <p class="mb-3">
                                The unbralla body for all importers and sellers of vehicles especially the imported fairly used popularly know as tokunbo in Nigeria. it is the solitary body having the supreme capacity to propel the innovation of automobile industry in Nigeria.
                            </p>
                           <!--  <ul class="footer-contact">
                                <li><a href="tel:+21236547898"><i class="far fa-phone"></i>+2 123 654 7898</a></li>
                                <li><i class="far fa-map-marker-alt"></i>25/B Milford Road, New York</li>
                                <li><a href="https://live.themewild.com/cdn-cgi/l/email-protection#f29b9c949db2978a939f829e97dc919d9f"><i
                                            class="far fa-envelope"></i><span class="__cf_email__" data-cfemail="95fcfbf3fad5f0edf4f8e5f9f0bbf6faf8">[email&#160;protected]</span></a></li>
                            </ul> -->
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-2 d-none d-md-block">
                        <div class="footer-widget-box list">
                            <h4 class="footer-widget-title">Quick Links</h4>
                            <ul class="footer-list">
                                <li><a href="#"><i class="fas fa-caret-right"></i> About Us</a></li>
                                <!-- <li><a href="#"><i class="fas fa-caret-right"></i> Update News</a></li> -->
                                <!-- <li><a href="#"><i class="fas fa-caret-right"></i> Testimonials</a></li> -->
                                <li><a href="#"><i class="fas fa-caret-right"></i> Terms Of Service</a></li>
                                <!-- <li><a href="#"><i class="fas fa-caret-right"></i> Privacy policy</a></li> -->
                                <li><a href="#"><i class="fas fa-caret-right"></i> Our Dealers</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="footer-widget-box list">
                            <h4 class="footer-widget-title">Support Center</h4>
                            <ul class="footer-list">
                                <li><a href="https://wa.me/+2348074571144"><i class="fas fa-caret-right"></i> FAQ's</a></li>
                                <!-- <li><a href="#"><i class="fas fa-caret-right"></i> Affiliates</a></li> -->
                                <!-- <li><a href="#"><i class="fas fa-caret-right"></i> Booking Tips</a></li> -->
                                <li><a href="#"><i class="fas fa-caret-right"></i> Buy Vehicles</a></li>
                                <li><a href="https://wa.me/+2348074571144"><i class="fas fa-caret-right"></i> Contact Us</a></li>
                                <!-- <li><a href="#"><i class="fas fa-caret-right"></i> Sitemap</a></li> -->
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 d-none d-md-block">
                        <div class="footer-widget-box list">
                            <h4 class="footer-widget-title">Newsletter</h4>
                            <div class="footer-newsletter">
                                <p>Subscribe Our Newsletter To Get Latest Update And News</p>
                                <div class="subscribe-form">
                                    <form action="#">
                                       <!--  <input type="email" class="form-control" placeholder="Your Email">
                                        <button class="theme-btn" type="submit">
                                            Subscribe Now <i class="far fa-paper-plane"></i>
                                        </button> -->
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 align-self-center">
                        <p class="copyright-text">
                            &copy; Copyright <span id="date"></span> <a href="#"> AMDON OYO STATE </a> All Rights Reserved.
                        </p>
                    </div>
                    <div class="col-md-6 align-self-center">
                        <ul class="footer-social">
                            <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                            <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- footer area end -->




    <!-- scroll-top -->
    <a href="#" id="scroll-top"><i class="far fa-arrow-up"></i></a>
    <!-- scroll-top end -->


    <!-- js -->
    <script data-cfasync="false" src="../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/modernizr.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/imagesloaded.pkgd.min.js"></script>
    <script src="assets/js/jquery.magnific-popup.min.js"></script>
    <script src="assets/js/isotope.pkgd.min.js"></script>
    <script src="assets/js/jquery.appear.min.js"></script>
    <script src="assets/js/jquery.easing.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/counter-up.js"></script>
    <script src="assets/js/jquery-ui.min.js"></script>
    <script src="assets/js/jquery.nice-select.min.js"></script>
    <script src="assets/js/wow.min.js"></script>
    <script src="assets/js/main.js"></script>

</body>


<!-- Mirrored from live.themewild.com/motex/ by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 03 Mar 2025 13:53:02 GMT -->
</html>