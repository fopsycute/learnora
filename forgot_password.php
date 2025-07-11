
<?php include "header.php";  
//if($active_log=="1"){ header("location:index.php");}
if(isset($_POST['forget'])){
$email=$_POST['email'];

$check = "SELECT * FROM ".$siteprefix."users WHERE email_address= '$email' AND type='user' AND status='active'";
$query = mysqli_query($con, $check);
if (mysqli_affected_rows($con) == 0) {
$statusAction="Invalid User";
$statusMessage="User not found!";
showErrorModal($statusAction,$statusMessage);
} else {
    $sql= "SELECT * FROM ".$siteprefix."users WHERE email_address= '$email' AND type='user' AND status='active'";
    $sql2 = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_array($sql2)) {
        $user_name = $row['display_name'];
        $user_id = $row['s'];
        $user_email = $row['email_address'];
    }

$randomPassword = generateRandomHardPassword();
$emailMessage="<p>Your password has been reset successfully to <span style='color:F57C00;'>$randomPassword</span> <br>Please login with it to change your password to a desired format.</p>";
$emailSubject="Password Reset";
$statusAction="Successful";
$statusMessage="Password reset successfully. Please check your email!";
$randomPassword=hashPassword($randomPassword);
$submit = mysqli_query($con, "UPDATE " . $siteprefix . "users SET password ='$randomPassword' WHERE s = '$user_id'") or die('Could not connect: ' . mysqli_error($con));
sendEmail($user_email, $user_name, $siteName, $siteMail, $emailMessage, $emailSubject);
showSuccessModal($statusAction,$statusMessage);
}}


?>
 <main class="main">

    <!-- Page Title -->
    <div class="page-title light-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Login</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php">Home</a></li>
            <li class="current">Reset Password</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Reset Password Section -->
    <section id="login-register" class="login-register section">

      <div class="container">

        <div class="row justify-content-center">
          <div class="col-lg-5">
            <div class="login-register-wraper">
              <h4>Reset Password</h4>
                <p>Enter your email address below and we will send you a link to reset your password.</p>
                  <form method="POST">
                    <div class="mb-4">
                      <label for="login-register-login-email" class="form-label">Email address</label>
                      <input type="email" class="form-control" name="email" id="login-register-login-email" required>
                    </div>

                   

                    <div class="d-grid">
                      <button type="submit" name="forget" class="btn btn-primary btn-lg">Login</button>
                    </div>
                  </form>
             

            </div>
          </div>
        </div>

      </div>

    </section><!-- /Login Register Section -->

  </main>
<?php include "footer.php"; ?>

