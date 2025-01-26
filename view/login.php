<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Byte Bazaar - Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="../style.css" rel="stylesheet">
    <?php include "navbar.php"; ?>
  </head>
  <body>
    <section class="site-banner jarallax padding-large" style="background: url(images/hero-image.jpg) no-repeat; background-position: top;">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h1 class="page-title">Login</h1>
            <div class="breadcrumbs">
              <span class="item">
                <a href="../index.php">Home /</a>
              </span>
              <span class="item">Login</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="contact-information padding-large">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-6">
            <div class="contact-information">
              <div class="section-header text-center">
                <h2 class="section-title">Welcome Back</h2>
                <p>Select your login role and sign in to continue</p>
              </div>
              <form action="../actions/login_action.php" method="post" class="contact-form" onsubmit="return validateRoleSelection()">
                <div class="form-item">
                  <label for="email">Email Address</label>
                  <input type="email" name="email" placeholder="Enter your email" class="u-full-width bg-light" required>

                  <label for="password">Password</label>
                  <input type="password" name="password" placeholder="Enter your password" class="u-full-width bg-light" required>
                  
                  <!-- Role selection -->
                  <label for="role" class="mt-4">Login as:</label>
                  <div class="role-selection d-flex justify-content-between">
                    <label class="radio-container">
                      <input type="radio" name="role" value="1" required>
                      <span>Customer</span> 
                    </label>
                    <label class="radio-container">
                      <input type="radio" name="role" value="2" required>
                      <span>Seller</span> 
                    </label>
                    <label class="radio-container">
                      <input type="radio" name="role" value="3" required>
                      <span>Admin</span> 
                    </label>
                  </div>
                </div>

                <button type="submit" name="submit" class="btn btn-dark btn-full btn-medium mt-4">Login</button>
              </form>
              <p class="text-center mt-3">
                Don't have an account? 
                <a href="customer_signup.php">Register as Buyer</a> or 
                <a href="seller_signup.php">Register to Sell</a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <?php include "footer.php"; ?>

    <style>
      .radio-container {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 1rem;
        cursor: pointer;
      }
      .radio-container input {
        margin-right: 10px;
      }
      .radio-container .checkmark {
        height: 20px;
        width: 20px;
        border: 2px solid #000;
        border-radius: 50%;
        position: relative;
      }
      .radio-container input:checked + .checkmark {
        background-color: #000;
      }
    </style>

    <script>
      function validateRoleSelection() {
        const roles = document.querySelectorAll('input[name="role"]');
        let roleSelected = false;
        roles.forEach(role => {
          if (role.checked) {
            roleSelected = true;
          }
        });
        if (!roleSelected) {
          alert('Please select a role before proceeding.');
          return false;
        }
        return true;
      }
    </script>
  </body>
</html>
