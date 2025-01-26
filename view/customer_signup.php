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
            <h1 class="page-title">Register</h1>
            <div class="breadcrumbs">
              <span class="item">
                <a href="../index.php">Home /</a>
              </span>
              <span class="item">Register</span>
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
                <h2 class="section-title">Create Your Account</h2>
              </div>

                <form action="../actions/register_action.php" method="post" class="contact-form" enctype="multipart/form-data" onsubmit="return validateForm()">
                  <label for="name">Name</label>
                  <input type="text" id="name" name="name" placeholder="Your name.." class="u-full-width bg-light" required>

                  <label for="email">Email</label>
                  <input type="email" id="email" name="email" placeholder="Your email.." class="u-full-width bg-light" pattern="^[a-zA-Z0-9._%+-]+@(ashesi\.edu\.gh|aucampus\.onmicrosoft\.com)$" title="Please enter a valid email ending with '@ashesi.edu.gh' or '@aucampus.onmicrosoft.com'" required>

                  <label for="password">Password</label>
                  <input type="password" id="pass" name="password" placeholder="Your password.." class="u-full-width bg-light" required>

                  <label for="country">Country</label>
                  <input type="text" id="country" name="country" placeholder="Your country." class="u-full-width bg-light" required>

                  <label for="city">City</label>
                  <input type="text" id="city" name="city" placeholder="Your city.." class="u-full-width bg-light" required>

                  <label for="contact_no">Contact Number</label>
                  <input type="text" id="contact_no" name="contact_no" placeholder="Your contact number.." class="u-full-width bg-light" required>

                  <!-- Hidden input for user role -->
                  <input type="hidden" name="role" value="1">

                  <label>
                    <input type="checkbox" required>
                    <span class="label-body">I agree to the <a href="#">terms and conditions</a></span>
                  </label>

                  <button type="submit" name="submit" class="btn btn-dark btn-full btn-medium">Register</button>
                </form>

              <p class="text-center">Already have an account? <a href="login.php">Login here</a></p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <?php include "footer.php"; ?>
  </body>
</html>
