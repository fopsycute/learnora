
<?php include "header.php";
$show="none"; $textshow="none";
    if(isset($_GET['user_login'])){
    $user_log=$_GET['user_login'];
    $sql = "SELECT * from ".$siteprefix."users where s='$user_log'";
    $sql2 = mysqli_query($con,$sql);
    while($row = mysqli_fetch_array($sql2))
    {$username = $row['email_address']; $pass = $row['password']; $status = $row['status']; }
    if($status=="inactive"){$textshow="block";} $show="block"; 
    } ifLoggedin($active_log);
   
   ?>
   
  <main class="main">

    <!-- Page Title -->
    <div class="page-title light-background position-relative">
      <div class="container">
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.html">Home</a></li>
            <li class="current">Login</li>
          </ol>
        </nav>
        <h1>Login</h1>
      </div>
    </div><!-- End Page Title -->

    <!-- Login Section -->
    <section id="login" class="login section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row justify-content-center">
          <div class="col-lg-5 col-md-8" data-aos="zoom-in" data-aos-delay="200">
            <div class="login-form-wrapper">
              <div class="login-header text-center">
                <h2>Login</h2>
                <p>Welcome back! Please enter your details</p>
              </div>

              <form method="post">
                <div class="alert alert-success alert-dismissible mb-3 fade show" id="myAlert" role="alert" style="display:<?php echo $show; ?>">
                        Congratulations! Your account has been successfully created. Thank you for registering! <span style="display: <?php echo $textshow;?>"> your email to verify your account.</span></div>
                <div class="mb-4">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" class="form-control" id="email" placeholder="Enter your email" name="email" required="" autocomplete="email">
                </div>
                <div class="mb-3">
                  <div class="d-flex justify-content-between">
                    <label for="password" class="form-label">Password</label>
                    <a href="forgot_password.php" class="forgot-link">Forgot password?</a>
                  </div>
                  <input type="password" class="form-control" id="password" placeholder="Enter your password" name="password" required="" autocomplete="current-password">
                </div>
                <div class="d-grid gap-2 mb-4">
                  <button type="submit" name="signin" class="btn btn-primary">Sign in</button>
                </div>

                <div class="signup-link text-center">
                  <span>Don't have an account?</span>
                  <a href="register.php">Sign up for free</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section><!-- /Login Section -->

  </main>

  <?php include "footer.php"; ?>