
<?php
function handleFileUpload($fileKey, $uploadDir, $fileName = null) {
    if (isset($_FILES[$fileKey]) && $_FILES[$fileKey]['error'] === UPLOAD_ERR_OK) {
        $fileExtension = pathinfo($_FILES[$fileKey]['name'], PATHINFO_EXTENSION);
        if ($fileName === null) {
            $fileName = uniqid() . '.' . $fileExtension;
        } else {
            $fileName .= '.' . $fileExtension;
        }

        $uploadedFile = $uploadDir . $fileName;
        if (move_uploaded_file($_FILES[$fileKey]['tmp_name'], $uploadedFile)) {
            return $fileName; // Return the new file name
        } else {
            return "Failed to move the uploaded file.";
        }
    } else {
        return "No file uploaded or an error occurred.";
    }
}
function deleteCommentAndReplies($comment_id, $con) {
    // Delete all child comments recursively
    $childRes = mysqli_query($con, "SELECT s FROM ln_comments WHERE parent_comment_id='$comment_id'");
    while ($child = mysqli_fetch_assoc($childRes)) {
        deleteCommentAndReplies($child['s'], $con);
    }
    // Delete this comment
    mysqli_query($con, "DELETE FROM ln_comments WHERE s='$comment_id'");
}
function renderForumCommentsModern($parent_id, $forum_id, $con, $siteprefix, $imagePath, $level = 0) {
    $parent_condition = ($parent_id === '0' || $parent_id === 0 || $parent_id === '' || $parent_id === null)
        ? "(parent_comment_id='' OR parent_comment_id='0')" 
        : "parent_comment_id='$parent_id'";

    $comments = mysqli_query($con, "SELECT * FROM ln_comments WHERE blog_id='$forum_id' AND $parent_condition ORDER BY commented_time ASC");

    while ($comment = mysqli_fetch_assoc($comments)) {
        $userRes = mysqli_query($con, "SELECT display_name, profile_picture FROM {$siteprefix}users WHERE s='{$comment['user_id']}' LIMIT 1");
        $user = mysqli_fetch_assoc($userRes);
        $avatar = !empty($user['profile_picture']) ? $imagePath . $user['profile_picture'] : $imagePath . 'user-avatar.png';
        $username = $user['display_name'] ?? 'User';
        $replyCountRes = mysqli_query($con, "SELECT COUNT(*) as cnt FROM ln_comments WHERE parent_comment_id='{$comment['s']}'");
        $replyCount = mysqli_fetch_assoc($replyCountRes)['cnt'];
       
        include 'comment.php'; // Include the comment card

    }
}


function generateRandomHardPassword($length = 8) {
return substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()-_+=<>?'), 0, $length);
}

 function increaseDownloads($con, $user_id) {
        // Increase downloads by 1
        $update = mysqli_query($con, "UPDATE ln_users SET downloads = downloads + 1 WHERE s = '$user_id'") 
        or die('Could not connect: ' . mysqli_error($con));
    }
  function decreaseDownloads($con, $user_id) {
        // Decrease downloads by 1
        $update = mysqli_query($con, "UPDATE ln_users SET downloads = downloads - 1 WHERE s = '$user_id'") 
        or die('Could not connect: ' . mysqli_error($con));
    }
function showToast($message) {
    echo '<div id="toast-wrapper" class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 11;"></div>';
    echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            var wrapper = document.getElementById("toast-wrapper");

            // Create a new toast container
            var toast = document.createElement("div");
            toast.className = "toast align-items-center text-white bg-primary border-0 mb-2";
            toast.setAttribute("role", "alert");
            toast.setAttribute("aria-live", "assertive");
            toast.setAttribute("aria-atomic", "true");

            // Create toast content
            var toastContent = `
                <div class="d-flex">
                    <div class="toast-body">' . addslashes($message) . '</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>`;
            
            toast.innerHTML = toastContent;
            wrapper.appendChild(toast);

            // Initialize and show the toast
            var bootstrapToast = new bootstrap.Toast(toast, { delay: 5000 });
            bootstrapToast.show();
        });
    </script>';
}
function sendEmail($vendorEmail, $vendorName, $siteName, $siteMail, $emailMessage, $emailSubject) {
    global $siteimg, $adminlink, $siteurl, $brevokey;

    $htmlBody = "
        <div style='width:600px; padding:40px; background-color:#000000; color:#fff;'>
            <p><img src='$siteurl/img/$siteimg' style='width:10%; height:auto;' /></p>
            <p style='font-size:14px; color:#fff;'>
                <span style='font-size:14px; color:#F57C00;'>Dear $vendorName,</span><br>
                $emailMessage
            </p>
            <p>Best regards,<br>
            Learnora Team<br>
            $siteMail | <a href='$siteurl' style='font-size:14px; font-weight:600; color:#F57C00;'>🌐 www.learnora.ng</a></p>
        </div>
    ";

    $apiKey = $brevokey;  // Replace with your actual API key

    $data = [
        'sender' => [
            'name' => $siteName,
            'email' => $siteMail
        ],
        'to' => [
            [
                'email' => $vendorEmail,
                'name' => $vendorName
            ]
        ],
        'subject' => "$emailSubject - $siteName",
        'htmlContent' => $htmlBody
    ];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://api.brevo.com/v3/smtp/email');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'api-key: ' . $apiKey,
        'Content-Type: application/json',
        'Accept: application/json'
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if (curl_errno($ch)) {
        echo 'Curl error: ' . curl_error($ch);
        curl_close($ch);
        return false;
    }

    curl_close($ch);

    if ($httpCode === 201) {
        return true;
    } else {
        echo 'Brevo API Error: ' . $response;
        return false;
    }
}


function sendEmail2($vendorEmail, $vendorName, $siteName, $siteMail, $emailMessage, $emailSubject, $attachment = []) {
    global $siteimg, $siteurl, $brevokey;

    $apiKey = $brevokey; // Replace with your actual Brevo API key

    $htmlBody = "
        <div style='width:600px; padding:40px; background-color:#000000; color:#fff;'>
            <p><img src='$siteurl/img/$siteimg' style='width:10%; height:auto;' /></p>
            <p style='font-size:14px; color:#fff;'>
                <span style='font-size:14px; color:#F57C00;'>Dear $vendorName,</span><br>
                $emailMessage
            </p>
            <p>Best regards,<br>
            The Learnora Team<br>
            $siteMail | <a href='$siteurl' style='font-size:14px; font-weight:600; color:#F57C00;'>🌐 www.learnora.ng</a></p>
        </div>
    ";

    // Prepare attachments
    $attachmentPayload = [];
    foreach ($attachment as $filePath) {
        if (file_exists($filePath)) {
            $attachmentPayload[] = [
                'content' => base64_encode(file_get_contents($filePath)),
                'name' => basename($filePath)
            ];
        }
    }

    // Prepare the API request payload
    $data = [
        'sender' => [
            'name' => $siteName,
            'email' => $siteMail
        ],
        'to' => [
            ['email' => $vendorEmail, 'name' => $vendorName]
        ],
        'subject' => "$emailSubject - $siteName",
        'htmlContent' => $htmlBody
    ];

    if (!empty($attachmentPayload)) {
        $data['attachment'] = $attachmentPayload;
    }

    // Send via CURL
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://api.brevo.com/v3/smtp/email');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'accept: application/json',
        'api-key: ' . $apiKey,
        'content-type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_POST, true);

    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if (curl_errno($ch)) {
        echo 'Curl error: ' . curl_error($ch);
        return false;
    }

    curl_close($ch);

    if ($httpcode == 201) {
        return true;
    } else {
        echo "Brevo API Error: $response";
        return false;
    }
}

function handleMultipleFileUpload($fileKey, $uploadDir) {
    $uploadedFiles = [];
    $defaultImages = ['default1.jpg', 'default2.jpg', 'default3.jpg', 'default4.jpg', 'default5.jpg'];
    $randomImage = $defaultImages[array_rand($defaultImages)];

    if (isset($_FILES[$fileKey])) {
        $fileCount = count($_FILES[$fileKey]['name']);

        for ($i = 0; $i < $fileCount; $i++) {
            if ($_FILES[$fileKey]['error'][$i] === UPLOAD_ERR_OK) {
                $fileExtension = pathinfo($_FILES[$fileKey]['name'][$i], PATHINFO_EXTENSION);
                $fileName = uniqid() . '.' . $fileExtension;
                $uploadedFile = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES[$fileKey]['tmp_name'][$i], $uploadedFile)) {
                    $uploadedFiles[] = $fileName; // Add the new file name to the array
                } else {
                    $uploadedFiles[] = "Failed to move the uploaded file.";
                }
            } else {
                $uploadedFiles[] = $randomImage;//"No file uploaded or an error occurred.";
            }
        }
    }

    return $uploadedFiles; // Return the array of uploaded file names or error messages
}


function sendEmailoldd($vendorEmail, $vendorName, $siteName, $siteMail, $emailMessage, $emailSubject) {
    global $siteimg, $adminlink, $siteurl;

    $htmlBody = "
        <div style='width:600px; padding:40px; background-color:#000000; color:#fff;'>
            <p><img src='$siteurl/img/$siteimg' style='width:10%; height:auto;' /></p>
            <p style='font-size:14px; color:#fff;'>
                <span style='font-size:14px; color:#F57C00;'>Dear $vendorName,</span><br>
                $emailMessage
            </p>
            <p>Best regards,<br>
            Learnora Team<br>
            $siteMail | <a href='$siteurl' style='font-size:14px; font-weight:600; color:#F57C00;'>🌐 www.learnora.ng</a></p>
        </div>
    ";

    $mail = new PHPMailer(true);

    try {
        // SMTP config for Brevo
        $mail->isSMTP();
        $mail->Host = 'smtp-relay.brevo.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'ikedike2002@yahoo.com'; // Brevo login email
        $mail->Password = 'H4kDR8YzCvP7FBGX';      // Brevo SMTP key
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Uncomment to debug SMTP connection:
         $mail->SMTPDebug = 3;
        $mail->Debugoutput = 'html';

        $mail->setFrom($siteMail, $siteName);
        $mail->addAddress($vendorEmail, $vendorName);
        $mail->addReplyTo($siteMail, $siteName);
        $mail->addCC($siteMail);

        $mail->isHTML(true);
        $mail->Subject = "$emailSubject - $siteName";
        $mail->Body    = $htmlBody;

        $mail->send();
        return true;

    } catch (Exception $e) {
        // SMTP failed — fallback to mail()
        $headers  = "From: $siteName <$siteMail>\r\n";
        $headers .= "Reply-To: $siteMail\r\n";
        $headers .= "CC: $siteMail\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";

        if (mail($vendorEmail, "$emailSubject - $siteName", $htmlBody, $headers)) {
            return true;
        } else {
            echo "SMTP failed: {$mail->ErrorInfo}. Mail() also failed.";
            return false;
        }
    }
}
function insertWithdraw($con, $user_id, $amount,$bank, $bankname, $bankno, $date, $status) {
$query = "INSERT INTO ln_withdrawal (user,amount,bank,bank_name,bank_number, date, status) VALUES ('$user_id', '$amount', '$bank','$bankname','$bankno','$date', '$status')";
$insert = mysqli_query($con, "UPDATE ln_users SET wallet = CAST(wallet AS DECIMAL(10,2)) - CAST('$amount' AS DECIMAL(10,2)) WHERE s='$user_id'") or die('Could not connect: ' . mysqli_error($con));
    $submit = mysqli_query($con, $query);
    if ($submit) { echo "";} 
    else { die('Could not connect: ' . mysqli_error($con)); }}

function getUserRole() {
    // Replace with your actual role-checking logic
    return $_SESSION['user_role'] ?? 'guest';
}



function showSuccessModal2($statusAction,$statusMessage) {
    echo '<div class="modal fade" id="statusSuccessModal" tabindex="-1" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false">';
    echo '<div class="modal-dialog modal-dialog-centered modal-sm" role="document">';
    echo '<div class="modal-content">';
    echo '<div class="modal-body text-center p-lg-4">';
    echo '<svg version="1.1" class="lazyload" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">';
    echo '<circle class="path circle" fill="none" stroke="#198754" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1" />';
    echo '<polyline class="path check" fill="none" stroke="#198754" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 " />';
    echo '</svg>';
    echo '<h4 class="text-success mt-3">' . $statusAction. '</h4>';
    echo '<p class="mt-3">' . $statusMessage. '</p>';
    echo '<button type="button" class="btn btn-sm mt-3 btn-success" data-bs-dismiss="modal">Okay</button>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '<script>';
    echo 'document.addEventListener("DOMContentLoaded", function() {';
    echo 'var myModal = new bootstrap.Modal(document.getElementById("statusSuccessModal"));';
    echo 'myModal.show();';
    echo '});';
    echo '</script>';
}

function showErrorModal2($statusAction, $statusMessage) {
    echo '<div class="modal fade" id="statusErrorsModal" tabindex="-1" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false">';
    echo '<div class="modal-dialog modal-dialog-centered modal-sm" role="document">';
    echo '<div class="modal-content">';
    echo '<div class="modal-body text-center p-lg-4">';
     echo '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">';
    echo '<circle class="path circle" fill="none" stroke="#db3646" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1" />';
    echo '<polyline class="path check" fill="none" stroke="#db3646" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 " />';
    echo '</svg>';
    echo '<h4 class="text-danger mt-3">' . $statusAction. '</h4>';
    echo '<p class="mt-3">' . $statusMessage. '</p>';
    echo '<button type="button" class="btn btn-sm mt-3 btn-danger" data-bs-dismiss="modal">Okay</button>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '<script>';
    echo 'document.addEventListener("DOMContentLoaded", function() {';
    echo 'var myModal = new bootstrap.Modal(document.getElementById("statusErrorsModal"));';
    echo 'myModal.show();';
    echo '});';
    echo '</script>';
}

function notifyDisputeRecipient($con, $siteprefix, $dispute_id) {
    // Get recipient ID
    $query = "SELECT recipient_id FROM ".$siteprefix."disputes WHERE ticket_number = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $dispute_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $recipient_id = $row['recipient_id'];
    
    if (!$recipient_id) {
        return false;
    }

    $message = "There has been a new update on dispute ($dispute_id). Please check the ticket for more details.";
    $rDetails = getUserDetails($con, $siteprefix, $recipient_id);
    $r_email = $rDetails['email'];
    $r_name = $rDetails['display_name'];
    $r_emailSubject = "Dispute Update ($dispute_id)";
    $r_emailMessage = "<p>There has been a new update on dispute ($dispute_id). Login to your dashboard to check</p>";
    
    //sendEmail($r_email, $r_name, $siteName, $siteMail, $r_emailMessage, $r_emailSubject);
    
    $date = date('Y-m-d H:i:s');
    $status = 0;
    $link = "ticket.php?ticket_number=$dispute_id";
    $msgtype = "Dispute Update";
    
    return insertAlert($con, $recipient_id, $message, $date, $status);
}


function updateDisputeStatus($con, $siteprefix, $dispute_id, $status) {
    $status = mysqli_real_escape_string($con, $status);
    $dispute_id = mysqli_real_escape_string($con, $dispute_id);
    
    $sql = "UPDATE " . $siteprefix . "disputes 
            SET status = '$status', 
                created_at = NOW() 
            WHERE ticket_number = '$dispute_id'";
            
    $result = mysqli_query($con, $sql);
    
    if ($result) {
        return true;
    }
    return false;
}

function deleteRecord($table, $item) {
    global $con;
    global $siteprefix;

    $sql = "DELETE FROM " . $siteprefix . $table . " WHERE s = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $item);

     return $stmt->execute();
}

function getUserColor($status) {
    
    switch ($status) { 
        case 'affiliate':
            return 'info'; // Info for pending payment
        case 'inprogress':
        case 'user':
            return 'success'; // Warning for inprogress or pending review
        default:
            return 'success'; // Success for all other statuses
    }
}

function convertHtmlEntities($input) {
    return html_entity_decode($input, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

function getReadonlyAttribute() {
    $role = getUserRole();
    if ($role === 'admin') {
        return ''; // No restriction
    } elseif ($role === 'sub-admin') {
        return 'readonly';
    }
    return '';
}


  function getDisplayClass() {
    $role = getUserRole();
    return ($role === 'admin') ? '' : 'd-none';
}

function sendEmail2oldd($vendorEmail, $vendorName, $siteName, $siteMail, $emailMessage, $emailSubject, $attachment = []) {
    global $siteimg, $siteurl;

    require 'vendor/autoload.php'; // Load PHPMailer classes

    $mail = new PHPMailer(true);

    try {
        // Server settings (Brevo SMTP)
        $mail->isSMTP();
        $mail->Host       = 'smtp-relay.brevo.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'ikedike2002@yahoo.com'; // Replace with your Brevo login email
        $mail->Password   = 'H4kDR8YzCvP7FBGX';          // Replace with your Brevo SMTP key
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom($siteMail, $siteName);
        $mail->addAddress($vendorEmail, $vendorName);
        $mail->addReplyTo($siteMail, $siteName);
        $mail->addCC($siteMail);

        // Attachments
        foreach ($attachment as $file) {
            if (file_exists($file)) {
                $mail->addAttachment($file);
            }
        }

        // Content
        $mail->isHTML(true);
        $mail->Subject = "$emailSubject - $siteName";

        $mail->Body = "
            <div style='width:600px; padding:40px; background-color:#000000; color:#fff;'>
                <p><img src='$siteurl/img/$siteimg' style='width:10%; height:auto;' /></p>
                <p style='font-size:14px; color:#fff;'>
                    <span style='font-size:14px; color:#F57C00;'>Dear $vendorName,</span><br>
                    $emailMessage
                </p>
                <p>
                    Best regards,<br>
                    Learnora Team<br>
                    $siteMail | <a href='$siteurl' style='font-size:14px; font-weight:600; color:#F57C00;'>🌐 www.learnora.ng</a>
                </p>
            </div>
        ";

        $mail->send();
        return true;

    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
}

function insertWallet($con, $user_id, $amount, $type, $note, $date) {

    $query = "INSERT INTO ln_wallet_history (user, amount, reason, status, date) VALUES ('$user_id', '$amount', '$note', '$type' , '$date')";
    $submit = mysqli_query($con, $query);
    if ($submit) { echo "";} 
    else { die('Could not connect: ' . mysqli_error($con)); }}


    function insertAlert($con, $user_id, $message, $date, $status) {
     $escapedMessage = mysqli_real_escape_string($con, $message);
 
     $query = "INSERT INTO ln_notifications (user, message, date, status) VALUES ('$user_id', '$escapedMessage', '$date', '$status')";
     $submit = mysqli_query($con, $query);
     if ($submit) { echo "";} 
     else { die('Could not connect: ' . mysqli_error($con)); }}


     function getWishlistCountByUser($con, $user_id) {
    $sql = "SELECT COUNT(*) as count FROM ln_wishlist WHERE user = '$user_id'";
    $result = mysqli_query($con, $sql);
    if ($result) {
        $row = mysqli_fetch_array($result);
        return $row['count'];
    }
    return 0;
}
function getBadgeColor($status) {
    switch ($status) {
        case 'cancelled':
            return 'danger'; // Gray for pending contract
        case 'Inactive':
                return 'danger'; // Gray for pending contract
        case 'draft':
            return 'info'; // Info for pending payment
        case 'awaiting-response':
            return 'info'; // Info for pending payment
        case 'pending':
        case 'suspended':
                return 'warning'; // Info for pending payment
        case 'inprogress':
        case 'approved':
            return 'success';
        case 'resolved':
            return 'success';
        case 'under-review':
            return 'danger'; // Gray for pending contract
        default:
            return 'success'; // Success for all other statuses
    }
}
//function to get username and email
function getUserDetails($con, $siteprefix, $user_id) {
    $query = "SELECT * FROM " . $siteprefix . "users WHERE s = '$user_id'";
    $result = mysqli_query($con, $query);
    return mysqli_fetch_assoc($result);
}

function checkActiveLog($active_log) {
    if ($active_log == "0") {
        header("Location: index.php");
        exit(); // Make sure to exit after the redirect
    }
}


    function insertAffliatePurchase($con, $order, $amount, $user,$date) {
        $query = "INSERT INTO ln_affliate_purchases (order_no, amount, affliate,date) VALUES ('$order', '$amount', '$user','$date')";
        $submit = mysqli_query($con, $query);
        if ($submit) { echo "";} 
        else { die('Could not connect: ' . mysqli_error($con)); }}
     
     function insertaffiliateAlert($con,$user, $message, $link, $date, $msgtype, $status) {
        $escapedMessage = mysqli_real_escape_string($con, $message);
    
         $query = "INSERT INTO ln_aff_alerts(message,user,link, date,type, status) VALUES ('$escapedMessage','$user','$link',  '$date', '$msgtype', '$status')";
         $submit = mysqli_query($con, $query);
         if ($submit) { echo "";} 
         else { die('Could not connect: ' . mysqli_error($con)); }}

function insertadminAlert($con, $message, $link, $date, $msgtype, $status) {
    $escapedMessage = mysqli_real_escape_string($con, $message);

     $query = "INSERT INTO ln_alerts(message,link, date,type, status) VALUES ('$escapedMessage','$link',  '$date', '$msgtype', '$status')";
     $submit = mysqli_query($con, $query);
     if ($submit) { echo "";} 
     else { die('Could not connect: ' . mysqli_error($con)); }}


     function showSuccessModal($statusAction,$statusMessage) {
    echo '<div class="modal fade" id="statusSuccessModal" tabindex="-1" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false">';
    echo '<div class="modal-dialog modal-dialog-centered modal-sm" role="document">';
    echo '<div class="modal-content">';
    echo '<div class="modal-body text-center p-lg-4">';
    echo '<svg version="1.1" class="lazyload" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">';
    echo '<circle class="path circle" fill="none" stroke="#198754" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1" />';
    echo '<polyline class="path check" fill="none" stroke="#198754" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 " />';
    echo '</svg>';
    echo '<h4 class="text-success mt-3">' . $statusAction. '</h4>';
    echo '<p class="mt-3">' . $statusMessage. '</p>';
    echo '<button type="button" class="btn btn-sm mt-3 btn-success" data-dismiss="modal">Okay</button>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '<script>';
    echo 'document.addEventListener("DOMContentLoaded", function() {';
    echo 'var myModal = new bootstrap.Modal(document.getElementById("statusSuccessModal"));';
    echo 'myModal.show();';
    echo '});';
    echo '</script>';
}


function showErrorModal($statusAction, $statusMessage) {
    echo '<div class="modal fade" id="statusErrorsModal" tabindex="-1" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false">';
    echo '<div class="modal-dialog modal-dialog-centered modal-sm" role="document">';
    echo '<div class="modal-content">';
    echo '<div class="modal-body text-center p-lg-4">';
     echo '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">';
    echo '<circle class="path circle" fill="none" stroke="#db3646" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1" />';
    echo '<polyline class="path check" fill="none" stroke="#db3646" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 " />';
    echo '</svg>';
    echo '<h4 class="text-danger mt-3">' . $statusAction. '</h4>';
    echo '<p class="mt-3">' . $statusMessage. '</p>';
    echo '<button type="button" class="btn btn-sm mt-3 btn-danger" data-bs-dismiss="modal">Okay</button>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '<script>';
    echo 'document.addEventListener("DOMContentLoaded", function() {';
    echo 'var myModal = new bootstrap.Modal(document.getElementById("statusErrorsModal"));';
    echo 'myModal.show();';
    echo '});';
    echo '</script>';
}


function ifLoggedin($active_log){
    if($active_log=="1"){ header("location: dashboard.php"); 
    }}

function hashPassword($password) {
    // Use password_hash() function to securely hash passwords
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    return $hashedPassword;
}
function checkPassword($password, $hashedPassword) {
    // Use password_verify() function to check if the password matches the hashed password
    return password_verify($password, $hashedPassword);
}



function redirectToDashboardIfSubAdmin() {
    // Assuming roles are strings like 'admin', 'subadmin', 'editor', etc.
    $userRole=getUserRole();
    if ($userRole != 'admin') {
        header("Location: /dashboard.php");
        exit();
    }
}

function getCartCount($con, $siteprefix, $order_id) {
    $sql = "SELECT COUNT(*) as count FROM ".$siteprefix."order_items oi 
    LEFT JOIN ".$siteprefix."orders o ON oi.order_id = o.order_id 
    WHERE o.order_id='$order_id'";
    $sql2 = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($sql2);
    return $row['count'];
}

function formatNumber($number, $no = 2) {
    if (!is_numeric($number) || !is_numeric($no)) {
        return "0.00";
    }
    try {
        return number_format((float)$number, (int)$no);
    } catch (Exception $e) {
        return "0.00";
    }
}
function getUserSeller() {
// Replace with your actual seller-checking logic
$trainer = $_SESSION['user_trainer'] ?? null;
}

function displayMessage($message) {
    echo "<div class='alert alert-warning'>$message</div>";
}
function sellerDisplay() {
    $sellerexist = getUserSeller();
    if ($sellerexist) {
        return ''; // Hide the element
    }else {
        return 'd-none'; // Show the element
    }  
}
//if user is a seller
function userDisplay() {
    $sellerexist = getUserSeller();
    if ($sellerexist) {
        return 'd-none'; // Hide the element
    }else {
        return ''; // Show the element
    }  
}
function formatDateTime2($dateTime) {
    if (empty($dateTime)) { return '';  }
    $timestamp = strtotime($dateTime);
    // Check if the input contains both date and time
    $hasTime = strpos($dateTime, 'T') !== false;
    if ($hasTime) { return date('M j, Y \a\t h:i A', $timestamp); } else {
     return date('M j, Y', $timestamp);
}}


function formatDateTime($dateTimeString) {
    // Create a DateTime object from the input string
    $dateTime = new DateTime($dateTimeString);

    // Format the date and time
    $formattedDate = $dateTime->format('M d Y');
    $formattedTime = $dateTime->format('H:i:s');

    // Combine the formatted date and time
    $formattedDateTime = $formattedDate . ' ' . $formattedTime;

    return $formattedDateTime;
}


function calculateRating($training_id, $con, $siteprefix) {
    $query = "SELECT 
                SUM(rating) as total_rating,
                COUNT(*) as review_count,
                SUM(CASE WHEN rating = 5 THEN 1 ELSE 0 END) as rating_5,
                SUM(CASE WHEN rating = 4 THEN 1 ELSE 0 END) as rating_4,
                SUM(CASE WHEN rating = 3 THEN 1 ELSE 0 END) as rating_3,
                SUM(CASE WHEN rating = 2 THEN 1 ELSE 0 END) as rating_2,
                SUM(CASE WHEN rating = 1 THEN 1 ELSE 0 END) as rating_1
              FROM {$siteprefix}reviews WHERE training_id = ?";

    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "s", $training_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $total_rating, $review_count, $r5, $r4, $r3, $r2, $r1);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    $total_rating = $total_rating ?? 0;
    $review_count = $review_count ?? 0;

    $average_rating = $review_count > 0 ? round($total_rating / $review_count, 1) : 0;

    return [
        'average_rating' => $average_rating,
        'review_count' => $review_count,
        'ratings' => [
            5 => $r5 ?? 0,
            4 => $r4 ?? 0,
            3 => $r3 ?? 0,
            2 => $r2 ?? 0,
            1 => $r1 ?? 0
        ]
    ];
}


function getStarIcons($average) {
    $fullStars = floor($average);
    $halfStar = ($average - $fullStars) >= 0.5;
    $html = '';

    for ($i = 0; $i < $fullStars; $i++) {
        $html .= '<i class="bi bi-star-fill"></i>';
    }
    if ($halfStar) {
        $html .= '<i class="bi bi-star-half"></i>';
    }
    $remaining = 5 - $fullStars - ($halfStar ? 1 : 0);
    for ($i = 0; $i < $remaining; $i++) {
        $html .= '<i class="bi bi-star"></i>';
    }
    return $html;
}

function getRatingBar($star, $count, $total) {
    $percent = $total > 0 ? round(($count / $total) * 100) : 0;
    return "
        <div class='rating-bar'>
            <div class='rating-label'>{$star} star" . ($star > 1 ? "s" : "") . "</div>
            <div class='progress'>
                <div class='progress-bar' role='progressbar' style='width: {$percent}%;' aria-valuenow='{$percent}' aria-valuemin='0' aria-valuemax='100'></div>
            </div>
            <div class='rating-count'>{$count}</div>
        </div>
    ";
}


function deletecategoryRecord($table, $item) {
    global $con;
    global $siteprefix;

    $sql = "DELETE FROM " . $siteprefix . $table . " WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $item);

     return $stmt->execute();
}












?>