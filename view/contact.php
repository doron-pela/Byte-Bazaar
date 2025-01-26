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
    <link rel="stylesheet" type="text/css" href="css/normalize.css">
    <link rel="stylesheet" type="text/css" href="icomoon/icomoon.css">
    <link rel="stylesheet" type="text/css" media="all" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/vendor.css">
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- script
    ================================================== -->
    <script src="js/modernizr.js"></script>
  </head>
  <body>

    
    <?php include "navbar.php";?>

    <section class="site-banner jarallax padding-large" style="background: url(images/hero-image.jpg) no-repeat; background-position: top;">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h1 class="page-title">Contact us</h1>
            <div class="breadcrumbs">
              <span class="item">
                <a href="../index.php">Home /</a>
              </span>
              <span class="item">Contact us</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="contact-information padding-large">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <div class="section-header">
              <h2 class="section-title">Get in touch</h2>
            </div>
            <div class="contact-detail">
              <div class="detail-list">
                <p>Message a Creator</p>
                <hr>
                <p>Contact us through these channels</p>
                <ul class="list-unstyled list-icon">
                  <li>
                    <a href="#"><i class="icon icon-phone"></i>+233 25788 0061</a>
                  </li>
                  <li>
                    <a href="mailto:info@yourcompany.com"><i class="icon icon-mail"></i>ByteBazaar@gmail.com</a>
                  </li>
                  <li>
                    <a href="#"><i class="icon icon-map-pin"></i>1 University Ave, Berekuso, Ghana</a>
                  </li>
                </ul>
              </div>
              <div class="social-links">
                <h3>Social Links</h3>
                <ul class="d-flex list-unstyled">
                  <li><a href="#" class="icon icon-facebook"></a></li>
                  <li><a href="#" class="icon icon-twitter"></a></li>
                  <li><a href="#" class="icon icon-instagram"></a></li>
                  <li><a href="#" class="icon icon-youtube-play"></a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="contact-information">
              <div class="section-header">
                <h2 class="section-title">Contact a Creator</h2>
              </div>


              <form name="contactform" action="contact.php" method="post" class="contact-form">
                <div class="form-item">
                  <input type="text" minlength="2" name="name" placeholder="Name" class="u-full-width bg-light" required>
                  <input type="email" name="email" placeholder="E-mail" class="u-full-width bg-light" required>
                  <textarea class="u-full-width bg-light" name="message" placeholder="Message" style="height: 180px;" required></textarea>
                </div>
                <label>
                  <input type="checkbox" required>
                  <span class="label-body">I agree all the <a href="#">terms and conditions</a>
                  </span>
                </label>
                
                <h3>Featured Creators</h3>
                <!--
                ! Implement drop down of creators here (from database)
                -->

                <button type="submit" name="submit" class="btn btn-dark btn-full btn-medium">Submit</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="google-map">
      <div class="mapouter">
        <div class="gmap_canvas">
          <iframe width="100%" height="500" id="gmap_canvas" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3170.1090519732857!2d-0.22021812518184415!3d5.760275200000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xfdf767731dfa583%3A0xc30b0f51f3b91add!2sAshesi%20University!5e0!3m2!1sen!2sus!4v1696588162847!5m2!1sen!2sus" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
          <a href="https://getasearch.com/fmovies"></a>
          <br>
          <style>
            .mapouter {
              position: relative;
              text-align: right;
              height: 500px;
              width: 100%;
            }
          </style>
          <a href="https://www.embedgooglemap.net">embedgooglemap.net</a>
          <style>
            .gmap_canvas {
              overflow: hidden;
              background: none !important;
              height: 500px;
              width: 100%;
            }
          </style>
        </div>
      </div>
    </section>

    
    <?php include "footer.php";?>
  </body>
</html>