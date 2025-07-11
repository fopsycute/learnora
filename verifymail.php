

<?php include "header.php";  ?>
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
           
                    <?php 
                if(isset($_GET['verify_status'])){
                    $user_log = $_GET['verify_status'];
                    $sql = "SELECT * from ".$siteprefix."users where s='$user_log'";
                    $sql2 = mysqli_query($con, $sql);
                    if (mysqli_affected_rows($con) == 0){
                        $message = 'User does not exist!';
                        showErrorModal('Error', $message);
                    } else {
                        while($row = mysqli_fetch_array($sql2)) {
                            $id = $row["s"];   
                            $name = $row["display_name"];
                            $email = $row["email_address"];
                        }
$subject = "Welcome to Learnora ";
$emailMessage = "
    <p>Your email has been successfully verified — welcome aboard!</p>
    <p>Learnora is your go-to platform for learning new skills and personal development. Whether you're looking to boost your career, start a business, or grow personally, Learnora offers practical courses, expert insights, and resources tailored to the Nigerian audience. Learn anytime, grow every day.</p>
    <p>You can now access your dashboard, explore high-quality customizable financial models, and start uploading or downloading tools to support your financial decisions.</p>
    <p><a href='$siteurl'>Visit Learnora</a> to get started.</p>
    <p>We're excited to have you on the platform!</p>";
                        if(mysqli_query($con, "UPDATE ".$siteprefix."users SET status='active' where s='$user_log'")) {
                            if(sendEmail($email, $name, $siteName, $siteMail, $emailMessage, $subject)) {
                                $message = 'Email Verified Successfully!';
                                showSuccessModal('Success', $message);
                                header("refresh:2;url=login.php?verify_login=$user_log");
                            } else {
                                $message = 'Verification successful'; //but failed to send email
                                showSuccessModal('Success', $message);
                                header("refresh:2;url=login.php?verify_login=$user_log");
                            }
                        } else {
                            $message = 'Failed to verify';
                            showErrorModal('Error', $message);
                        }
                    }
                } else { header('Location: signin.php'); exit(); }
                ?>

             

            </div>
          </div>
        </div>

      </div>

    </section><!-- /Login Register Section -->

  </main>
<?php include "footer.php"; ?>

