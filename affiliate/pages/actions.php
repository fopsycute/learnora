<?php

// add to affiliate list


if (isset($_GET['action']) && $_GET['action'] == 'read-message') {
    $sql = "UPDATE ln_aff_alerts SET status='1' WHERE user='$user_id' AND status='0'";
    $sql2 = mysqli_query($con,$sql);
    $message="All notifications marked as read.";
    showToast($message);
    header("refresh:2; url=notifications.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_affiliate_list'])) {
    $user_id = $_POST['user_id'];
    $affliate_id = $_POST['affliate_id'];
    $product_id = mysqli_real_escape_string($con, $_POST['product_id']); // Sanitize product ID

    // Check if the product is already in the affiliate's list
    $check_query = "SELECT * FROM " . $siteprefix . "affiliate_products WHERE user_id = '$user_id' AND product_id = '$product_id'";
    $check_result = mysqli_query($con, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Product is already in the list
        $message = "This product is already in your affiliate list.";
        showToast($message);
        header("refresh:2; url=training.php");
        exit;
    }

    // Fetch the product title from the training table
    $product_query = "SELECT title, alt_title FROM " . $siteprefix . "training WHERE training_id = '$product_id'";
    $product_result = mysqli_query($con, $product_query);

    if ($product_result && mysqli_num_rows($product_result) > 0) {
        $product_row = mysqli_fetch_assoc($product_result);
        $title = $product_row['title'];
        $alt_title = $product_row['alt_title'];

        // Generate the slug
        $slug =$alt_title;

        // Generate the affiliate link
        $affiliate_link = $siteurl . "events/" . $slug . "?affiliate=" . base64_encode($affliate_id);

        // Add product to affiliate's list
        $insert_query = "INSERT INTO " . $siteprefix . "affiliate_products (user_id, product_id, affiliate_link, affiliate_id) 
                         VALUES ('$user_id', '$product_id', '$affiliate_link', '$affliate_id')";
        if (mysqli_query($con, $insert_query)) {
            $message = "Product added to your affiliate list successfully!";
            showSuccessModal('Processed', $message);
            header("refresh:1; url=training.php");
           
        } else {
            $message = "Failed to add product to your affiliate list: " . mysqli_error($con);
            showErrorModal('Oops', $message);
            exit;
        }
    } else {
        $message = "Failed to fetch product details.";
        showErrorModal('Oops', $message);
        exit;
    }
}



//withdrawwallet
if (isset($_POST['withdraw'])){
    $date=$currentdatetime;
    $bank=$_POST['bank'];
    $bankname=$_POST['bankname'];
    $bankno=$_POST['bankno'];
    $amount=$_POST['amount'];
    $status="pending";
    
    
    insertWithdraw($con, $user_id, $amount,$bank, $bankname, $bankno, $date, $status);
    $emailSubject="Withdrawal Request - Recieved";
    $emailMessage="<p>We have successfully received your withdrawal request of ₦$amount. Your request is now being processed and will be completed within the next 24 hours.";
    $emailMessage_admin="<p>A new withdrawal request has been recieved for ₦$amount. Please login into your dashboard to process it</p>";
    $adminmessage = "New Withdrawal Request - &#8358;$amount";
    $link="withdrawals.php";
    $msgtype='New Withdrawal';
    $message_status=1;
    insertadminAlert($con, $adminmessage, $link, $date, $msgtype, $message_status); 
    //sendEmail($email, $name, $siteName, $siteMail, $emailMessage, $emailSubject);
    //sendEmail($siteMail, $adminName, $siteName, $siteMail, $emailMessage_admin, $emailSubject);
        
       
    $statusAction="Successful";
    $statusMessage="Withdrawal Request Sent Sucessfully!";
    showSuccessModal($statusAction,$statusMessage);
    header("Refresh: 4; url=wallet.php");
    }

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
    $user_id = $_POST['user_id'];
    $first_name = mysqli_real_escape_string($con, $_POST['first_name']);
    $middle_name = mysqli_real_escape_string($con, $_POST['middle_name']);
    $last_name = mysqli_real_escape_string($con, $_POST['last_name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $sex = mysqli_real_escape_string($con, $_POST['gender']);
    $mobile_number = mysqli_real_escape_string($con, $_POST['mobile_number']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $bank_name = mysqli_real_escape_string($con, $_POST['bank_name']);
    $bank_accname = mysqli_real_escape_string($con, $_POST['bank_accname']);
    $bank_number = mysqli_real_escape_string($con, $_POST['bank_number']);
    $facebook = mysqli_real_escape_string($con, $_POST['facebook']);
    $twitter = mysqli_real_escape_string($con, $_POST['twitter']);
    $instagram = mysqli_real_escape_string($con, $_POST['instagram']);
    $linkedln = mysqli_real_escape_string($con, $_POST['linkedln']);
    $biography = mysqli_real_escape_string($con, $_POST['biography']);
    $password = !empty($_POST['password']) ? $_POST['password'] : null;
    $retypePassword = !empty($_POST['retypePassword']) ? $_POST['retypePassword'] : null;
    $oldPassword = htmlspecialchars($_POST['oldpassword']);

    // Handle profile picture upload if needed
    $profilePicture = $_FILES['profile_picture']['name'] ?? '';
    if (!empty($profilePicture)) {
        $uploadDir = '../../uploads/';
        global $fileName;
        $profile_picture = handleFileUpload('profile_picture', $uploadDir, $fileName);
    } else {
        $profile_picture = $_POST['existing_picture'] ?? '';
    }

    // Password logic
    $password_sql = '';
    if ($password || $retypePassword || $oldPassword) {
        if (empty($password) || empty($retypePassword) || empty($oldPassword)) {
            echo "<script>alert('All password fields must be filled out.'); window.history.back();</script>";
            exit;
        }
        if ($password !== $retypePassword) {
            echo "<script>alert('Passwords do not match.'); window.history.back();</script>";
            exit;
        }
        $stmt = $con->prepare("SELECT password FROM {$siteprefix}users WHERE s = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        if (!$user || !password_verify($oldPassword, $user['password'])) {
            echo "<script>alert('Old password is incorrect.'); window.history.back();</script>";
            exit;
        }
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $password_sql = ", password = '" . mysqli_real_escape_string($con, $hashedPassword) . "'";
    }

    // Build the update query with only the available variables
    $update_query = "
        UPDATE {$siteprefix}users SET
            first_name = '$first_name',
            middle_name = '$middle_name',
            last_name = '$last_name',
            email_address = '$email',
            gender = '$sex',
            phone_number = '$mobile_number',
            n_office_address = '$address',
            bank_name = '$bank_name',
            bank_accname = '$bank_accname',
            bank_number = '$bank_number',
            facebook = '$facebook',
            twitter = '$twitter',
            instagram = '$instagram',
            linkedin = '$linkedln',
            biography = '$biography',
            profile_photo = '$profile_picture'
            $password_sql
        WHERE s = '$user_id'
    ";

    // Execute update
    if (mysqli_query($con, $update_query)) {
        $statusAction = "Success!";
        $statusMessage = "Profile updated successfully!";
        showSuccessModal($statusAction, $statusMessage);
        header("refresh:1; url=settings.php");
    } else {
        $statusAction = "Error!";
        $statusMessage = "Failed to update profile: " . mysqli_error($con);
        showErrorModal($statusAction, $statusMessage);
    }
}
?>