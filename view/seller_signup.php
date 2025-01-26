<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include "navbar.php"; ?>
  </head>
  <body>

    <section class="site-banner jarallax padding-large" style="background: url(images/hero-image.jpg) no-repeat; background-position: top;">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h1 class="page-title">Sell With Us</h1>
            <div class="breadcrumbs">
              <span class="item">
                <a href="../index.php">Home /</a>
              </span>
              <span class="item">Seller Signup</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="contact-information padding-large">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-8">
            <div class="contact-information">
              <div class="section-header text-center">
                <h2 class="section-title">Become a Byte Bazaar Seller</h2>
                <p>Join our platform and start selling your digital products today!</p>
              </div>

              <form action="../actions/seller_register_action.php" method="post" enctype="multipart/form-data" class="contact-form">
                <div class="form-item">
                  <input type="text" name="name" placeholder="Full Name" class="u-full-width bg-light" required>
                  <input type="email" name="email" placeholder="Email Address" class="u-full-width bg-light" required>
                  <input type="password" name="password" placeholder="Password" class="u-full-width bg-light" required>
                  
                  <label for="country">Country</label>
                  <input type="text" id="country" name="country" placeholder="Your country." class="u-full-width bg-light" required>

                  <label for="city">City</label>
                  <input type="text" id="city" name="city" placeholder="Your city.." class="u-full-width bg-light" required>
                  <input type="tel" name="contact_no" placeholder="Phone Number" class="u-full-width bg-light" required>
                  <textarea class="u-full-width bg-light" name="description" placeholder="Brief Description About You or Your Products" style="height: 120px;" required></textarea>
                  
                </div>

                <!-- Hidden input for user role -->
                <input type="hidden" name="role" value="2">

                <label>
                  <input type="checkbox" required>
                  <span class="label-body">I agree to the <a href="#">terms and conditions</a></span>
                </label>
                <button type="submit" name="submit" class="btn btn-dark btn-full btn-medium">Register as a Seller</button>
              </form>

              <p class="text-center">Already a seller? <a href="login.php">Login here</a></p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <?php include "footer.php"; ?>
  </body>
</html>
