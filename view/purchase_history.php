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
    <!-- Header -->
    
    <?php include "navbar.php";?>
  
      <section class="site-banner jarallax min-height300 padding-large" style="background: url(images/hero-image.jpg) no-repeat; background-position: top;">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <h1 class="page-title">Shop page</h1>
              <div class="breadcrumbs">
                <span class="item">
                  <a href="../index.php">Home /</a>
                </span>
                <span class="item">
                    <a href="shop.php">Shop /</a>
                </span>
                <span class="item"> Purchase History </span>
              </div>
            </div>
        </div>
      </section>  
    

    <!-- Main Content -->
    <main>
        <section class="padding-medium">
            <div class="container">
                <h2 class="section-title">Your Purchases</h2>
                <div class="table-responsive">
                    <table class="border-bottom">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Product</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Amount</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Sample Row 1 -->
                            <tr>
                                <td>#1001</td>
                                <td>Digital Art Design Pack</td>
                                <td>2024-11-15</td>
                                <td><span class="text-primary">Completed</span></td>
                                <td>$45.00</td>
                                <td><button class="btn btn-small btn-outline-primary">View Details</button></td>
                            </tr>
                            <!-- Sample Row 2 -->
                            <tr>
                                <td>#1002</td>
                                <td>Web Template</td>
                                <td>2024-11-20</td>
                                <td><span class="text-muted">Pending</span></td>
                                <td>$30.00</td>
                                <td><button class="btn btn-small btn-outline-primary">View Details</button></td>
                            </tr>
                            <!-- Sample Row 3 -->
                            <tr>
                                <td>#1003</td>
                                <td>Mobile App UI Kit</td>
                                <td>2024-12-01</td>
                                <td><span class="text-muted">Processing</span></td>
                                <td>$75.00</td>
                                <td><button class="btn btn-small btn-outline-primary">View Details</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    
    <?php include "footer.php";?>
</body>

</html>
