<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Byte Bazaar - Digital Store eCommerce Store</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link rel="stylesheet" type="text/css" href="./view/css/normalize.css">
    <link rel="stylesheet" type="text/css" href="./view/icomoon/icomoon.css">
    <link rel="stylesheet" type="text/css" media="all" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="./view/css/vendor.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- script
    ================================================== -->
    <script src="./view/js/modernizr.js"></script>
  </head>
  <body>

    <?php /*include "./view/navbar.php"; */?>

    <!-- <div class="preloader-wrapper">
      <div class="preloader">
      </div>
    </div> -->

    <div class="search-popup">
      <div class="search-popup-container">

        <form role="search" method="get" class="search-form" action="">
          <input type="search" id="search-form" class="search-field" placeholder="Type and press enter" value="" name="s" />
          <button type="submit" class="search-submit"><a href="#"><i class="icon icon-search"></i></a></button>
        </form>

        <h5 class="cat-list-title">Browse Categories</h5>
        
        <ul class="cat-list">
          <li class="cat-list-item">
            <a href="./view/shop.php" title="Web Applications">Web Applications</a>
          </li>
          <li class="cat-list-item">
            <a href="./view/shop.php" title="PWAs">PWAs</a>
          </li>
          <li class="cat-list-item">
            <a href="./view/shop.php" title="Cross Platform">Cross Platform</a>
          </li>
          <li class="cat-list-item">
            <a href="./view/shop.php" title="Native (Android)">Native (Android)</a>
          </li>
          <li class="cat-list-item">
            <a href="./view/shop.php" title="Native (IOS)">Native (IOS)</a>
          </li>
          <li class="cat-list-item">
            <a href="./view/shop.php" title="Sites">Sites</a>
          </li>
          <li class="cat-list-item">
            <a href="./view/shop.php" title="PWAs">PWAs</a>
          </li>
          <li class="cat-list-item">
            <a href="./view/shop.php" title="Aesthetics">Aesthetics</a>
          </li>
          <li class="cat-list-item">
            <a href="./view/shop.php" title="Miscellaneous">Miscellaneous</a>
          </li>
        </ul>
      </div>
    </div>
    
    <header id="header">
      <div id="header-wrap">
        <nav class="secondary-nav border-bottom">
          <div class="container">
            <div class="row d-flex align-items-center">
              <div class="col-md-4 header-contact">
                <p>Let's talk! <strong>+234 906 410 8594</strong>
                </p>
              </div>
              <div class="col-md-4 shipping-purchase text-center">
                <p>Empower the digital supply chain</p>
              </div>
              <div class="col-md-4 col-sm-12 user-items">
                <ul class="d-flex justify-content-end list-unstyled">
                  <li>
                    <a href="./view/login.php">
                      <i class="icon icon-user"></i>
                    </a>
                  </li>
                  <li>
                    <a href="./view/cart_view.php">
                      <i class="icon icon-shopping-cart"></i>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="icon icon-heart"></i>
                    </a>
                  </li>
                  <li class="user-items search-item pe-3">
                    <a href="#" class="search-button">
                      <i class="icon icon-search"></i>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </nav>
        <nav class="primary-nav padding-small">
          <div class="container">
            <div class="row d-flex align-items-center">
              <div class="col-lg-2 col-md-2">
                <div class="main-logo">
                  <a href="index.php">
                    <img src="./view/images/main-logo.png" alt="logo">
                  </a>
                </div>
              </div>

              <div class="col-lg-10 col-md-10">
                <div class="navbar">
                  <div id="main-nav" class="stellarnav d-flex justify-content-end right">
                    <ul class="menu-list">

                      <li class="menu-item has-sub">
                        <a href="index.php" class="item-anchor active d-flex align-item-center" data-effect="Home">Home</a>
                      </li>

                      <li><a href="./view/about.php" class="item-anchor" data-effect="About">About</a></li>
                      
                      <li><a href="./view/login.php" class="item-anchor" data-effect="About">Login</a></li>

                      <li><a href="./view/seller_signup.php" class="item-anchor" data-effect="About">Sell With Us</a></li>

                      <li><a href="./view/customer_signup.php" class="item-anchor" data-effect="About">Register</a></li>

                      <li class="menu-item has-sub">
                        <a href="./view/shop.php" class="item-anchor d-flex align-item-center" data-effect="Shop">Shop<i class="icon icon-chevron-down"></i></a>
                        <ul class="submenu">
                          <li><a href="./view/shop.php" class="item-anchor">Shop</a></li>
                          <li><a href="./view/cart_view.php" class="item-anchor">Cart<span class="text-primary"></span></a></li>
                          <li><a href="./view/purchase_history.php" class="item-anchor">purchase History<span class="text-primary"></span></a></li>
                        </ul>
                      </li>

                      <li class="menu-item has-sub">
                        <a href="./view/blog.php" class="item-anchor d-flex align-item-center" data-effect="Blog">Blog<i class="icon icon-chevron-down"></i></a>
                        <ul class="submenu">
                          <li><a href="./view/single-post.php" class="item-anchor">Single post</a></li>
                        </ul>
                      </li>

                      <li><a href="./view/contact.php" class="item-anchor" data-effect="Contact">Contact</a></li>

                    </ul>
                  </div>

                </div>
              </div>

            </div>
          </div>
        </nav>
      </div>
    </header>

    <section id="billboard" class="overflow-hidden">

      <button class="button-prev">
        <i class="icon icon-chevron-left"></i>
      </button>
      <button class="button-next">
        <i class="icon icon-chevron-right"></i>
      </button>
      <div class="swiper main-swiper">
        <div class="swiper-wrapper">
          <div class="swiper-slide" style="background-image: url('./view/images/banner1.jpg');background-repeat: no-repeat;background-size: cover;background-position: center;">
            <div class="banner-content">
              <div class="container">
                <div class="row">
                  <div class="col-md-6">
                    <h2 class="banner-title">Fresh Minds, fresh solutions</h2>
                    <span>Find the next generation of innovative digital products built by young talent all over the world</span>
                    <div class="btn-wrap">
                      <a href="./view/shop.php" class="btn btn-light btn-medium d-flex align-items-center" tabindex="0">Shop it now <i class="icon icon-arrow-io"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="swiper-slide" style="background-image: url('./view/images/banner2.jpg');background-repeat: no-repeat;background-size: cover;background-position: center;">
            <div class="banner-content">
              <div class="container">
                <div class="row">
                  <div class="col-md-6">
                    <h2 class="banner-title">Collection</h2>
                    <p>Big ideas, small costs, endless possibilities.</p>
                    <div class="btn-wrap">
                      <a href="./view/shop.php" class="btn btn-light btn-light-arrow btn-medium d-flex align-items-center" tabindex="0">Shop it now <i class="icon icon-arrow-io"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="featured-products" class="product-store padding-large">
      <div class="container">
        
      </div>
    </section>


    <section id="testimonials" class="padding-large">
      <div class="container">
        <div class="reviews-content">
          <div class="row d-flex flex-wrap">
            <div class="col-md-2">
              <div class="review-icon">
                <i class="icon icon-right-quote"></i>
              </div>
            </div>
            <div class="col-md-8">
              <div class="swiper testimonial-swiper overflow-hidden">
                <div class="swiper-wrapper">
                  <div class="swiper-slide">
                    <div class="testimonial-detail">
                      <p>"As a student at Ashesi, I’ve always looked for ways to apply my skills in real-world scenarios. Byte Bazaar is exactly what we needed—a platform that allows us to collaborate, create meaningful projects, and earn while learning."</p>
                      <div class="author-detail">
                        <div class="name">By Jonathan Odonkor</div>
                      </div>
                    </div>
                  </div>
                  <div class="swiper-slide">
                    <div class="testimonial-detail">
                      <p>"I was skeptical at first, but Byte Bazaar proved to be exactly what I could've been missing in my fashion enterprise. The collaborative model means the students are motivated to deliver their best work, and I get to benefit from their innovation at a price that small businesses like mine can handle."</p>
                      <div class="author-detail">
                        <div class="name">By Amarachi Ogbonna</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="swiper-arrows">
                <button class="prev-button">
                  <i class="icon icon-arrow-left"></i>
                </button>
                <button class="next-button">
                  <i class="icon icon-arrow-right"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="shoppify-section-banner">
      <div class="container">
        <div class="product-collection">
          <div class="left-content collection-item">
            <div class="products-thumb">
              <img src="./view/images/model.jpg" alt="collection item" class="large-image image-rounded">
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 product-entry">
              <div class="categories">Find your digital resource</div>
              <h3 class="item-title">Collections</h3>
              <p></p>
              <div class="btn-wrap">
                <a href="./view/shop.php" class="d-flex align-items-center">shop collection <i class="icon icon-arrow-io"></i>
                </a>
              </div>
            </div>
          </div>
        </div>        
      </div>
    </section>

    <section id="quotation" class="align-center padding-large">
      <div class="inner-content">
        <h2 class="section-title divider">Quote of the day</h2>
        <blockquote>
          <q>Byte Bazaar is the Future of project-based incentives</q>
          <div class="author-name">- Happy buyer</div>
        </blockquote>
      </div>
    </section>

    <hr>

    <section id="brand-collection" class="padding-medium bg-light-grey">
      <div class="container">
        <div class="d-flex flex-wrap justify-content-between">
          <img src="./view/images/brand1.png" alt="phone" class="brand-image">
          <img src="./view/images/brand2.png" alt="phone" class="brand-image">
          <img src="./view/images/brand3.png" alt="phone" class="brand-image">
          <img src="./view/images/brand4.png" alt="phone" class="brand-image">
          <img src="./view/images/brand5.png" alt="phone" class="brand-image">
        </div>
      </div>
    </section>

    <section id="instagram" class="padding-large">
      <div class="container">
        <div class="section-header">
          <h2 class="section-title">Follow our most renowned Developers on Instagram</h2>
        </div>
        <p>Our official Instagram account <a href="https://www.instagram.com/doron_pela/?hl=en">@ByteBazaar</a> or <a href="#">#Byte_Bazaar</a>
        </p>

        <!-- Echo image from database -->

        <div class="row d-flex flex-wrap justify-content-between">
          <div class="col-lg-2 col-md-4 col-sm-6">
            <figure class="zoom-effect">
              <img src="./view/images/insta-image1.jpg" alt="instagram" class="insta-image">
              <i class="icon icon-instagram"></i>
            </figure>
          </div>
          <div class="col-lg-2 col-md-4 col-sm-6">
            <figure class="zoom-effect">
              <img src="./view/images/insta-image2.jpg" alt="instagram" class="insta-image">
              <i class="icon icon-instagram"></i>
            </figure>
          </div>
          <div class="col-lg-2 col-md-4 col-sm-6">
            <figure class="zoom-effect">
              <img src="./view/images/insta-image3.jpg" alt="instagram" class="insta-image">
              <i class="icon icon-instagram"></i>
            </figure>
          </div>
          <div class="col-lg-2 col-md-4 col-sm-6">
            <figure class="zoom-effect">
              <img src="./view/images/insta-image4.jpg" alt="instagram" class="insta-image">
              <i class="icon icon-instagram"></i>
            </figure>
          </div>
          <div class="col-lg-2 col-md-4 col-sm-6">
            <figure class="zoom-effect">
              <img src="./view/images/insta-image5.jpg" alt="instagram" class="insta-image">
              <i class="icon icon-instagram"></i>
            </figure>
          </div>
          <div class="col-lg-2 col-md-4 col-sm-6">
            <figure class="zoom-effect">
              <img src="./view/images/insta-image6.jpg" alt="instagram" class="insta-image">
              <i class="icon icon-instagram"></i>
            </figure>
          </div>
        </div>          
      </div>
    </section>


    <footer id="footer">
      <div class="container">
        <div class="footer-menu-list">
          <div class="row d-flex flex-wrap justify-content-between">
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="footer-menu">
                <h5 class="widget-title">Byte Bazaar</h5>
                <ul class="menu-list list-unstyled">
                  <li class="menu-item">
                    <a href="./view/about.php">About us</a>
                  </li>
                  <li class="menu-item">
                    <a href="#">Conditions </a>
                  </li>
                  <li class="menu-item">
                    <a href="./view/blog.php">Our Journals</a>
                  </li>
                  <li class="menu-item">
                    <a href="#">Careers</a>
                  </li>
                  <li class="menu-item">
                    <a href="#">Affiliate Programme</a>
                  </li>
                  <li class="menu-item">
                    <a href="#">Byte Bazaar</a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="footer-menu">
                <h5 class="widget-title">Customer Service</h5>
                <ul class="menu-list list-unstyled">
                  <li class="menu-item">
                    <a href="faqs.php">FAQ</a>
                  </li>
                  <li class="menu-item">
                    <a href="./view/contact.php">Contact</a>
                  </li>
                  <li class="menu-item">
                    <a href="#">Privacy Policy</a>
                  </li>
                  <li class="menu-item">
                    <a href="#">Returns & Refunds</a>
                  </li>
                  <li class="menu-item">
                    <a href="#">Cookie Guidelines</a>
                  </li>
                  <li class="menu-item">
                    <a href="#">Delivery Information</a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="footer-menu">
                <h5 class="widget-title">Contact Us</h5>
                <p>Do you have any questions or suggestions? <a href="#" class="email">bytebazaar@gmail.com</a>
                </p>
                <p>Do you need assistance? Give us a call. <br>
                  <strong>+233 9064108594</strong>
                </p>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="footer-menu">
                <h5 class="widget-title">Follow our socials</h5>
                <p></p>
                <div class="social-links">
                  <ul class="d-flex list-unstyled">
                    <li>
                      <a href="https://www.facebook.com/doron.pela.3">
                        <i class="icon icon-facebook"></i>
                      </a>
                    </li>
                    <!-- <li>
                      <a href="#">
                        <i class="icon icon-twitter"></i>
                      </a>
                    </li> -->
                    <li>
                      <a href="https://www.youtube.com/@doronpela4693">
                        <i class="icon icon-youtube-play"></i>
                      </a>
                    </li>
                    <!-- <li>
                      <a href="#">
                        <i class="icon icon-behance-square"></i>
                      </a>
                    </li> -->
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <hr>
    </footer>

    <div id="footer-bottom">
      <div class="container">
        <div class="d-flex align-items-center flex-wrap justify-content-between">
          <div class="copyright">
            <p> <a href="https://templatesjungle.com/"></a> Distributed by <a href="https://doron.pela@ashesi.edu.gh">Doron Pela</a>
            </p>
          </div>
          <div class="payment-method">
            <p>Payment options :</p>
            <div class="card-wrap">
              <img src="images/visa-icon.jpg" alt="visa">
              <img src="images/mastercard.png" alt="mastercard">
              <img src="images/american-express.jpg" alt="american-express">
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="js/jquery-1.11.0.min.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/script.js"></script>
  </body>
</html>