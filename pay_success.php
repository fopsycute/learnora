<?php include "header.php"; 

// Get reference number (user ID) from Paystack
global $ref;
$ref = $_GET['ref'];
$date = date('Y-m-d H:i:s');
$attachment = [];


// Get order details and order items
$sql_order = "SELECT * FROM ".$siteprefix."orders WHERE order_id = '$ref' AND status = 'unpaid'";
$sql_order_result = mysqli_query($con, $sql_order);
if (mysqli_affected_rows($con) > 0) {
    while ($row_order = mysqli_fetch_array($sql_order_result)) {
        $order_id = $row_order['order_id']; 
        $user_id = $row_order['user']; 
        $status = $row_order['status']; 
        $total_amount = $row_order['total_amount']; 
        $date = $row_order['date']; 
    }




// Fetch buyer's details
$sql_buyer = "SELECT email_address, display_name FROM ".$siteprefix."users WHERE s = '$user_id'";
$result_buyer = mysqli_query($con, $sql_buyer);

if ($result_buyer && mysqli_num_rows($result_buyer) > 0) {
    $buyer = mysqli_fetch_assoc($result_buyer);
    $email = $buyer['email_address']; // Buyer's email
    $username = $buyer['display_name']; // Buyer's name
}

// Get order items
$sql_items = "SELECT oi.*, t.title as resource_title
              FROM ".$siteprefix."order_items oi
              JOIN ".$siteprefix."training t ON oi.training_id = t.training_id
              WHERE oi.order_id = '$ref'";   
$sql_items_result = mysqli_query($con, $sql_items);

if (mysqli_affected_rows($con) > 0) {
    while ($row_item = mysqli_fetch_array($sql_items_result)) {
        $s = $row_item['s']; 
        $training_id = $row_item['training_id'];
        $price = $row_item['price']; 
        $original_price = $row_item['original_price']; 
        $loyalty_id = $row_item['loyalty_id']; 
        $affiliate_id = $row_item['affiliate_id']; 
        $order_id = $row_item['order_id']; 
        $date = $row_item['date'];   
        $resourceTitle = $row_item['resource_title']; // Fetch the resource title
      

      

        // Check if the item has an affiliate
        if ($affiliate_id != 0) {
            // Get affiliate details
            $sql_affiliate = "SELECT * FROM ".$siteprefix."users WHERE affliate = '$affiliate_id'";
            $sql_affiliate_result = mysqli_query($con, $sql_affiliate);
            if (mysqli_affected_rows($con) > 0) {
                while ($row_affiliate = mysqli_fetch_array($sql_affiliate_result)) {
                    $affiliate_user_id = $row_affiliate['s']; 
                    $affiliate_amount = $price * ($affiliate_percentage / 100);
                    
                    // Update affiliate wallet
                    $sql_update_affiliate_wallet = "UPDATE ".$siteprefix."users SET wallet = wallet + $affiliate_amount WHERE affliate = '$affiliate_id'";
                    mysqli_query($con, $sql_update_affiliate_wallet);
                    
                    // Insert into affiliate transactions
                    $note = "Affiliate Earnings from Order ID: ".$order_id;
                    $type = "credit";
                    insertWallet($con, $affiliate_user_id, $affiliate_amount, $type, $note, $date);
                    
                    // Notify affiliate
                    $message = "You have earned $sitecurrency$affiliate_amount from Order ID: $order_id";
                    $link = "wallet.php";
                    $msgtype = "wallet";
                    $status = 0;
                    insertaffiliateAlert($con, $affiliate_user_id, $message, $link, $date, $msgtype, $status);
                    insertAffliatePurchase($con, $s, $affiliate_amount, $affiliate_id,$date);
                }
            }
        }


        // Get seller ID
        $sql_seller = "SELECT u.s AS user, u.* FROM ".$siteprefix."users u LEFT JOIN ".$siteprefix."training t ON t.user=u.s WHERE t.training_id = '$training_id'";
        $sql_seller_result = mysqli_query($con, $sql_seller);
        if (mysqli_affected_rows($con) > 0) {
            while ($row_seller = mysqli_fetch_array($sql_seller_result)) {
                $seller_id = $row_seller['user']; 
                $vendorEmail = $row_seller['email_address'];
                $vendorName = $row_seller['display_name'];
                $sellertype = $row_seller['type'];
                $admin_commission=0;

                if($sellertype=="user"){
        // Admin commission deduction
        $admin_commission = $price * ($escrowfee / 100);
        $sql_insert_commission = "INSERT INTO ".$siteprefix."profits (amount, training_id, order_id,type, date) VALUES ('$admin_commission', '$training_id', '$order_id', 'Order Payment','$date')";
        mysqli_query($con, $sql_insert_commission);
        
        // Notify admin
        $message = "Admin Commission of $sitecurrency$admin_commission from Order ID: $order_id";
        $link = "profits.php";
        $msgtype = "profits";
        insertadminAlert($con, $message, $link, $date, $msgtype, 0);
        } 

        
  else if($sellertype=="admin"||$sellertype=="sub-admin"){
        // Admin commission deduction
        $admin_commission = $price;
        $sql_insert_commission = "INSERT INTO ".$siteprefix."profits (amount, training_id, order_id,type, date) VALUES ('$admin_commission', '$training_id', '$order_id', 'Order Payment','$date')";
        mysqli_query($con, $sql_insert_commission);
            
        // Notify admin
        $message = "Admin Commission of $sitecurrency$admin_commission from Order ID: $order_id";
        $link = "profits.php";
        $msgtype = "profits";
        insertadminAlert($con, $message, $link, $date, $msgtype, 0);
        }
                
                // Credit seller
                $seller_amount = $price - $admin_commission;
                $sql_update_seller_wallet = "UPDATE ".$siteprefix."users SET wallet = wallet + $seller_amount WHERE s = '$seller_id'";
                mysqli_query($con, $sql_update_seller_wallet);
                
                // Insert seller transactions
                $note = "Payment from Order ID: ".$order_id;
                $type = "credit";
                insertWallet($con, $seller_id, $seller_amount, $type, $note, $date);
                
                // Notify seller
                insertAlert($con, $seller_id, "You have received $sitecurrency$seller_amount from Order ID: $order_id", $date, 0);
                
// Enhanced email content
$emailSubject = "New Sale on Project Report Hub. Let's Keep the Momentum Going!";
$emailMessage = "<p>Great news! A new sale has just been made on $siteurl.</p>
<p><strong>Title of Resource:</strong> $resourceTitle</p>
<p><strong>Price:</strong> $sitecurrencyCode$price</p>
<p><strong>Earning:</strong> $sitecurrencyCode$seller_amount</p>
<p>This is a win for our community and a reminder that students and researchers are actively exploring and purchasing resources from our platform every day.</p>
<p>If you havenâ€™t updated your listings recently, now is a great time to:</p>
<ol>
    <li>Refresh your content and pricing</li>
    <li>Promote your reports on social media</li>
    <li>Add new documents that reflect trending industries</li>
</ol>
<p>The more visible and updated your resources are, the more sales opportunities you create.</p>
<p>Let's keep the momentum going and continue providing high-value insights to Nigeria and the world!</p>";

// Send email to seller
sendEmail($vendorEmail, $vendorName, $siteName, $siteMail, $emailMessage, $emailSubject);
            }
        }
    }
}

// Update order status to paid
$sql_update_order = "UPDATE ".$siteprefix."orders SET status = 'paid',date='$currentdatetime' WHERE order_id = '$ref'";
mysqli_query($con, $sql_update_order);

// Send order confirmation email
$subject = "Order Confirmation";
// Email content with the table
// Generate the table for purchased reports
$tableRows = "";
$sql_items = "SELECT 
    oi.*, 
    t.*, 
    tem.event_date, 
    tem.start_time, 
    tem.end_time, 
    tt.ticket_name
FROM {$siteprefix}order_items oi
JOIN {$siteprefix}training t ON oi.training_id = t.training_id
LEFT JOIN {$siteprefix}training_event_dates tem ON t.training_id = tem.training_id
LEFT JOIN {$siteprefix}training_tickets tt ON t.training_id = tt.training_id
WHERE oi.order_id = '$ref'";
$sql_items_result = mysqli_query($con, $sql_items);

$emailDetails = [];
while ($row = mysqli_fetch_assoc($sql_items_result)) {
    $event_dates = [];
    if (!empty($row['event_date']) && !empty($row['start_time']) && !empty($row['end_time'])) {
        $event_dates[] = [
            'event_date' => $row['event_date'],
            'start_time' => $row['start_time'],
            'end_time' => $row['end_time']
        ];
    }
    $date_str = '';
    $time_str = '';
    if (count($event_dates) > 0) {
        $first = $event_dates[0];
        $last = end($event_dates);
        $date_str = date('M d, Y', strtotime($first['event_date']));
        if (count($event_dates) > 1 && $last['event_date'] !== $first['event_date']) {
            $date_str .= ' – ' . date('M d, Y', strtotime($last['event_date']));
        }
        $time_str = date('h:i A', strtotime($first['start_time'])) . ' – ' . date('h:i A', strtotime($first['end_time']));
    }
    $format = ucfirst($row['delivery_format']);
    $details = '';
    if ($format === 'Physical') {
        $fields = [
            'physical_address' => 'Address',
            'physical_state' => 'State',
            'physical_lga' => 'LGA',
            'physical_country' => 'Country',
            'foreign_address' => 'Foreign Address'
        ];
        foreach ($fields as $col => $label) {
            if (!empty($row[$col])) {
                $details .= "<li><strong>$label:</strong> " . htmlspecialchars($row[$col]) . "</li>";
            }
        }
    } elseif ($format === 'Hybrid') {
        $fields = [
            'hybrid_physical_address' => 'Physical Address',
            'hybrid_web_address' => 'Web Address',
            'hybrid_state' => 'State',
            'hybrid_lga' => 'LGA',
            'hybrid_country' => 'Country',
            'hybrid_foreign_address' => 'Foreign Address'
        ];
        foreach ($fields as $col => $label) {
            if (!empty($row[$col])) {
                $details .= "<li><strong>$label:</strong> " . htmlspecialchars($row[$col]) . "</li>";
            }
        }
    } elseif ($format === 'Online') {
        if (!empty($row['web_address'])) {
            $details .= "<li><strong>Link to join:</strong> <a href='" . htmlspecialchars($row['web_address']) . "'>" . htmlspecialchars($row['web_address']) . "</a></li>";
        }
    }
    $training_title = $row['title'];
    $ticket_name = $row['ticket_name'];
    $amount_paid = number_format($row['price'], 2);
    $emailDetails[] = [
        'training_title' => $training_title,
        'date_str' => $date_str,
        'time_str' => $time_str,
        'format' => $format,
        'ticket_name' => $ticket_name,
        'amount_paid' => $amount_paid,
        'details' => $details
    ];
}
$user_first_name = explode(' ', $username)[0];
$emailMessage = "<p>Hi $user_first_name,</p>";
$emailMessage .= "<p>Thank you for registering for:</p>";
foreach ($emailDetails as $ed) {
    $emailMessage .= "<ul>
        <li>🎓 <strong>Training:</strong> {$ed['training_title']}</li>
        <li>📅 <strong>Date(s):</strong> {$ed['date_str']}</li>
        <li>🕓 <strong>Time:</strong> {$ed['time_str']}</li>
        <li>📍 <strong>Format:</strong> {$ed['format']}</li>
        <li>🎟️ <strong>Ticket:</strong> {$ed['ticket_name']}</li>
        <li>💰 <strong>Amount Paid:</strong> ₦{$ed['amount_paid']}</li>
    </ul>
    <p>Here’s what to expect:</p>
    <ul>
        {$ed['details']}
        <li>You’ll get a reminder 24 hours before the event.</li>
        <li>Save this email — it contains your access details.</li>
    </ul>
    <hr>";
}
$subject = "Your Training Registration Details";
sendEmail2($email, $username, $siteName, $siteMail, $emailMessage, $subject, $attachment);

}
?>

<div class="container mt-5 mb-5">
    <div class="alert alert-success" role="alert">
        <h4 class="alert-heading">Payment Successful!</h4>
        <p>Your payment was successful. An email has been sent to you with your invoice.</p>
        <hr>
        <p class="mb-0">Thank you for your order.</p>
    </div>
    <div class="card text-center">
        <div class="card-header bg-success text-white">Thank You for Your Purchase!</div>
        <div class="card-body">
            <h5 class="card-title">Order processed successfully.</h5>
            <a href="my_orders.php" class="btn btn-primary mt-4"> Back to My Orders</a>
        </div>
        <div class="card-footer text-muted">We appreciate your business! ðŸ’–</div>
    </div>
    <!-- Table of Purchased Reports -->
<div class="mt-5">
    <h3>Your Purchased Trainings</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Training Title</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql_items = "SELECT t.title 
                          FROM {$siteprefix}order_items oi
                          JOIN {$siteprefix}training t ON oi.training_id = t.training_id
                          WHERE oi.order_id = '$ref'";
            $sql_items_result = mysqli_query($con, $sql_items);

            if (mysqli_num_rows($sql_items_result) > 0) {
                while ($row_item = mysqli_fetch_assoc($sql_items_result)) {
                    $training_title = $row_item['title'];
                    echo "<tr><td>$training_title</td></tr>";
                }
            } else {
                echo "<tr><td>No trainings found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
       <div class="alert alert-info mt-3">
        Please check your email for your event access details and confirmation.<br>
        You can also go to your <a href="dashboard.php" class="btn btn-primary btn-sm">Dashboard</a> to view your trainings.
    </div>
</div>
<?php include "footer.php"; ?>