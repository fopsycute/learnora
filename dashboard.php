
<?php 
include "header.php";
checkActiveLog($active_log);
 ?>



    <section id="account" class="account section">

      <div class="container-fluid" data-aos="fade-up" data-aos-delay="100">

    

        <div class="row">
            <div class="col-lg-12">
                 <div class="profile-menu">
                 <div class="row">
          <!-- Profile Menu -->
          <div class="col-lg-2">
           
      <!-- User Info -->
              <div class="user-info" data-aos="fade-right">
                <div class="user-avatar">
                  <img src="<?php echo $imagePath.$profile_photo; ?>" alt="Profile" loading="lazy">
                </div>
                <h3> <?php echo htmlspecialchars($display_name); ?></h3>
           </div>
           </div>
		   
		   <div class="col-lg-10">
		   <div class="profile-links" data-aos="fade-left">
		     <?php include "links.php"; ?>
            </div>
             <?php

    //if user is not a trainer yet
    if($trainer == 0 || $trainer == '') { 
        echo '<p class="text-white">You are not a trainer yet update your profile. <a href="settings.php" class="btn btn-primary">Become a Trainer</a></p>';
    } 
    // Fetch last 4 notifications where status is 0
    $sql = "SELECT message, date FROM ".$siteprefix."notifications WHERE user = ? AND status = 0 ORDER BY date DESC LIMIT 4";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $notifications = $result->fetch_all(MYSQLI_ASSOC);
    ?>
    <?php foreach ($notifications as $notification): ?>
    <p class="text-light"><?php echo htmlspecialchars($notification['message']); ?></p>
    <?php endforeach; ?>
 

</div>
   <?php
if ($trainer == 1): // Display only for trainers

// Fetch all report IDs for the trainer
$reportsQuery = "SELECT training_id FROM ".$siteprefix."training WHERE user = $user_id";
$reportsResult = mysqli_query($con, $reportsQuery);
$reportIds = [];
while ($report = mysqli_fetch_assoc($reportsResult)) {
    $reportIds[] = $report['training_id'];
}

$totalOrders = 0;
$totalEarnings = 0;

if (!empty($reportIds)) {
    // Convert report IDs to a comma-separated string with quotes for the query
    $reportIdsString = "'" . implode("','", $reportIds) . "'";

    // Fetch all order IDs from order_items where training_id matches the seller's reports
    $orderItemsQuery = "SELECT DISTINCT order_id FROM ".$siteprefix."order_items WHERE training_id IN ($reportIdsString)";
    $orderItemsResult = mysqli_query($con, $orderItemsQuery);
    $orderIds = [];
    while ($orderItem = mysqli_fetch_assoc($orderItemsResult)) {
        $orderIds[] = $orderItem['order_id'];
    }

    if (!empty($orderIds)) {
        // Convert order IDs to a comma-separated string with quotes for the query
        $orderIdsString = "'" . implode("','", $orderIds) . "'";

        // Fetch total earnings and count orders from the orders table
        $ordersQuery = "SELECT COUNT(order_id) AS total_orders, SUM(total_amount) AS total_earnings 
                        FROM ".$siteprefix."orders 
                        WHERE order_id IN ($orderIdsString) AND status = 'paid'";
        $ordersResult = mysqli_query($con, $ordersQuery);
        $ordersData = mysqli_fetch_assoc($ordersResult);

        $totalOrders = $ordersData['total_orders'];
        $totalEarnings = $ordersData['total_earnings'];
    }
}

// Fetch the number of resources
$resourcesQuery = "SELECT COUNT(*) AS total_resources FROM ".$siteprefix."training WHERE user = $user_id";
$resourcesResult = mysqli_query($con, $resourcesQuery);
$totalResources = mysqli_fetch_assoc($resourcesResult)['total_resources'];

?>
<!-- Seller Statistics Section -->
<div class="col-md-2">
    <a href="models.php">
    <div class="card text-white bg-primary mb-3">
        <div class="card-body">
            <h5 class="card-title text-white"><a href="models.php" style="text-decoration: none; color:#fff;">Resources</a></h5>
            <p class="card-text text-white"><?php echo $totalResources; ?></p>
        </div>
    </div>
</a>
</div>

<div class="col-md-2">
    <a href="sales.php">
    <div class="card text-white bg-secondary mb-3">
        <div class="card-body">
            <h5 class="card-title text-white"><a href="sales.php" style="text-decoration: none; color:#fff;">Orders</a></h5>
            <p class="card-text text-white"><?php echo $totalOrders; ?></p>
        </div>
    </div>
</a>
</div>




<div class="col-md-2">
    <a href="sales.php">
    <div class="card text-white bg-secondary mb-3">
        <div class="card-body">
            <h5 class="card-title text-white"><a href="sales.php" style="text-decoration: none; color:#fff;">Total Earnings</a></h5>
            <p class="card-text text-white"><?php echo $sitecurrency . formatNumber($totalEarnedAmount, 2); ?></p>
        </div>
    </div>
</a>
</div>

<div class="col-md-2 <?php sellerDisplay(); ?>">
    <a href="resources-sold.php">
    <div class="card text-white bg-secondary mb-3">
        <div class="card-body">
            <h5 class="card-title text-white"><a href="resources-sold.php" style="text-decoration: none; color:#fff;">Resource Sold</a></h5>
            <p class="card-text text-white"><?php echo $total_resources_sold;?></p>
        </div>
    </div>
</a>
</div>

<div class="col-md-2 <?php sellerDisplay(); ?>">
    <a href="reviews.php">
    <div class="card text-white bg-secondary mb-3">
        <div class="card-body">
            <h5 class="card-title text-white"><a href="reviews.php" style="text-decoration: none; color:#fff;">My Reviews</a></h5>
            <p class="card-text text-white"><?php echo $reviews_count; ?></p>
        </div>
    </div>
</a>
</div>
<?php endif; ?>




<div class="col-md-2 <?php userDisplay(); ?>">
    <a href="my_orders.php">
    <div class="card text-white bg-secondary mb-3">
        <div class="card-body">
            <h5 class="card-title text-white"><a href="my_orders.php" style="text-decoration: none; color:#fff;">My Purchases</a></h5>
            <p class="card-text text-white"><?php echo $paid_orders_count; ?></p>
        </div>
    </div>
</a>
</div>
 

<div class="col-md-2 <?php userDisplay(); ?>">
    <a href="manual_orders.php">
    <div class="card text-white bg-secondary mb-3">
        <div class="card-body">
            <h5 class="card-title text-white"><a href="manual_orders.php" style="text-decoration: none; color:#fff;">Manual Purchases</a></h5>
            <p class="card-text text-white"><?php echo $pending_payments_count ; ?></p>
        </div>
    </div>
</a>
</div>







		   </div>
              </div>		
			   </div>
           </div>
           </div>

</section>



<?php include "footer.php"; ?>