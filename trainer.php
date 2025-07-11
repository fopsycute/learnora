<?php
   include 'backend/connect.php';

if (empty($_GET['user_login'])) {
    header("Location: register.php");
    exit();
}

$id = mysqli_real_escape_string($con, $_GET['user_login']);

// Fetch user data
$user_query = mysqli_query($con, "SELECT * FROM ".$siteprefix."users WHERE s='$id'");
$user = mysqli_fetch_assoc($user_query);

// Example assignments (adjust field names as needed)
$freelancer_representative = $user['company_name'] ?? '';
$freelancer_address = $user['n_office_address'] ?? '';
$freelancer_name = $user['display_name'] ?? '';
$freelancer_phone = $user['phone_number'] ?? '';
$freelancer_email = $user['email_address'] ?? '';


if (isset($_POST['trainer_submit'])){
    // Update user status in the database
 
    $stmt = $con->prepare("UPDATE ln_users SET trainer = 1 WHERE s = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $stmt->close();


    $emailSubject = "Confirm Your Email";
        $emailMessage = "
        <p>Thank you for signing up on <strong>Learnora</strong>! To complete your registration
        and start exploring our platform, please verify your email address by clicking the link below:</p>
        <p><a href='$siteurl/verifymail.php?verify_status=$id'>Click here to verify your email</a></p>
        <p>Once verified, you can log in and start accessing premium reports, upload your content,
        or manage your dashboard.</p>";

        $adminmessage = "A new user has been registered($freelancer_name)";
        $link="users.php";
        $msgtype='New User';
        $message_status=1;
        $emailMessage_admin="<p>A new user has been successfully registered!</p>";
        $emailSubject_admin="New User Registeration";
        insertadminAlert($con, $adminmessage, $link, $date, $msgtype, $message_status); 
        sendEmail($email, $freelancer_name, $siteName, $siteMail, $emailMessage, $emailSubject);
        sendEmail($siteMail, $adminName, $siteName, $siteMail, $emailMessage_admin, $emailSubject_admin);

    // Redirect to login page
    header("Location: login.php?user_login=". $id);
    exit();
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>TRAINING SERVICES</title>
</head>
<body width="70%">
    <center><h1>KYNELI BUSINESS SUPPORT SERVICES</h1>
    <h6>LEARNORA ….. The One Stop Shop for Trainings in Nigeria!</h6>
    <p>61-65 Egbe- Isolo Road,<br>
    Iyana Ejigbo Shopping Arcade,<br>
    Block A, Suite 19,<br>
    Iyana Ejigbo Bus Stop,<br>
    Ejigbo, Lagos.</p>
    <p>Tel: +234 (0) 803 3782 777; +234 (01) 29 52 413</p>
    <p>Email: hello@learnora.ng<br>
    Website: <a href="http://www.learnora.ng">www.learnora.ng</a></p>
    <h2>SALES AND MARKETING AGREEMENT FOR THE PROVISION OF TRAINING SERVICES </h2>
    <p>THIS AGREEMENT IS MADE THIS DAY</p>
    <p><?php echo date("F j, Y"); ?></p>
    <form method="post" action="">
        <h3>BETWEEN</h3></center>
        <table border="1">
            <tr>
                <td>COMPANY:</td>
                <td>KYNELI BUSINESS SUPPORT SERVICES</td>
            </tr>
            <tr>
                <td>URL:</td>
                <td><a href="http://www.learnora.ng">www.learnora.ng</a></td>
            </tr>
            <tr>
                <td>ADDRESS:</td>
                <td>61-65 Egbe- Isolo Road, Iyana Ejigbo Shopping Arcade, Block A, Suite 19, Iyana Ejigbo Bus Stop, Ejigbo, Lagos State, Nigeria.</td>
            </tr>
            <tr>
                <td>REPRESENTED BY:</td>
                <td>Anaekwe Everistus Nnamdi</td>
            </tr>
            <tr>
                <td>JOB TITLE:</td>
                <td>MD/CEO</td>
            </tr>
            <tr>
                <td>PHONE:</td>
                <td>+234 -1- 29 52 413</td>
            </tr>
            <tr>
                <td>E-MAIL ADDRESS:</td>
                <td>hello@learnora.ng</td>
            </tr>
        </table>
        <p>[HEREINAFTER CALLED THE “COMPANY”]</p>
        <h3>AND</h3>
        <table  border="1">
            <tr>
            <td>COMPANY:</td>
            <td><?php echo $freelancer_representative; ?></td>
            </tr>
            <tr>
            <td>ADDRESS:</td>
            <td><?php echo $freelancer_address; ?></td>
            </tr>
            <tr>
            <td>REPRESENTED BY:</td>
            <td><?php echo $freelancer_name; ?></td>
            </tr>
             <tr>
            <td>JOB TITLE</td>
            <td>Trainer</td>
            </tr>
            <tr>
            <td>PHONE:</td>
            <td><?php echo $freelancer_phone; ?></td>
            </tr>
            <tr>
            <td>E-MAIL ADDRESS:</td>
            <td><?php echo $freelancer_email; ?></td>
            </tr>
        </table>
        <p>[HEREINAFTER CALLED THE “TRAINING COMPANY/TRAINER”]</p>
<p>This Agreement is entered into as of the date of acceptance ("Effective Date") by and between:</p>

<p>
    Learnora.ng, a digital learning platform operated in Nigeria (hereinafter referred to as “Learnora” or “the Platform”),
    <br><br>
    and
    <br><br>
    <?php echo htmlspecialchars($freelancer_representative); ?>, with a principal place of business at <?php echo htmlspecialchars($freelancer_address); ?> (hereinafter referred to as “Trainer” or “Training Company”). Collectively referred to as “the Parties.”
</p>
<h3>1.  Purpose</h3>
<p>This Agreement outlines the terms and conditions under which the Trainer/Training Company will offer training programs through the Learnora.ng platform.</p>

<h3>2.  Obligations of the Trainer/Training Company</h3>
<p>
    <ul style="list-style-type: none; padding-left: 0;">
    <li>- Provide accurate and verifiable credentials and course information.</li>
    <li>- Deliver high-quality training content, including live sessions, recorded materials, and assessments.</li>
    <li>- Ensure timely and professional engagement with learners.</li>
    <li>- Abide by all applicable laws, including copyright, privacy, and data protection regulations.</li>
</ul>
</p>

<h3>3. Obligations of Learnora.ng</h3>
<ul style="list-style-type: none; padding-left: 0;">
    <li>- Host and market the training programs through its platform and associated channels.</li>
    <li>- Provide access to tools for content creation, learner management, and analytics.</li>
    <li>- Process payments from learners on behalf of the Trainer/Training Company.</li>
</ul>

<h3>4. Revenue Sharing</h3>
<p>
    The ticket amount (course fee) shall be divided as follows:
</p>
<ul style="list-style-type: none; padding-left: 0;">
    <li>- 70% to the Trainer/Training Company.</li>
    <li>- 30% to Learnora.ng as platform commission.</li>
</ul>
<p>
    Payouts will be processed on a monthly basis, within 10 business days of the close of each calendar month, via the bank details provided by the Trainer/Training Company.
</p>

<h3>5. Intellectual Property</h3>
<p>
    All training content created by the Trainer/Training Company remains their intellectual property. Learnora.ng is granted a non-exclusive, royalty-free license to host, display, and promote the content for the duration of this agreement.
</p>

<h3>6. Term and Termination</h3>
<p>
    This Agreement shall continue until terminated by either party with 30 days’ written notice. Learnora.ng reserves the right to suspend or terminate the agreement immediately in the event of misconduct, policy violation, or legal infringement.
</p>

<h3>7. Confidentiality</h3>
<p>
    Both parties agree to maintain confidentiality on all sensitive information exchanged during the term of this agreement.
</p>

<h3>8. Governing Law</h3>
<p>
    This Agreement shall be governed and construed in accordance with the laws of the Federal Republic of Nigeria.
</p>
<p>IN WITNESS WHEREOF, the parties have executed this Agreement as of the Effective Date.

</p>

<p>Publisher: Foraminifera Market Research Limited<br>
Name: Anaekwe Everistus Nnamdi Ikechukwu<br>
Signature: Anaekwe Everistus Nnamdi Ikechukwu<br>
Date: <?php echo date("F j, Y"); ?></p>

<p>Freelancer:<br>
Name: <?php echo $freelancer_name; ?> <br>
Signature: <?php echo $freelancer_name; ?> <br>
Date: <?php echo date("F j, Y"); ?></p>

<p><input type="submit" name="trainer_submit" value="SUBMIT" style="width:100%; background-color: #4CAF50; color: white; padding: 15px 32px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer; border: none; border-radius: 4px;"></p>

</form>


</body>
</html>