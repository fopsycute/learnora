<?php include "header.php";


// Get Order ID from URL
if (!isset($_GET['order_id'])) {
    echo "Invalid Order ID.";
    exit();
}

$order_id = $_GET['order_id'];
$user_id = $_GET['user_id'];

// Fetch order details
$sql = "SELECT * FROM ".$siteprefix."orders WHERE order_id = ? AND user = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("ss", $order_id, $user_id);
$stmt->execute();
$order_result = $stmt->get_result();

if ($order_result->num_rows == 0) {
    echo "Order not found.";
    exit();
}

$order = $order_result->fetch_assoc();

// Fetch ordered items
$sql = "SELECT t.title, ti.picture, oi.price, oi.original_price
        FROM ".$siteprefix."order_items oi 
        LEFT JOIN ".$siteprefix."training t  ON  oi.training_id = t.training_id 
        LEFT JOIN ".$siteprefix."training_images ti ON t.training_id = ti.training_id 
        WHERE oi.order_id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $order_id);
$stmt->execute();
$items_result = $stmt->get_result();


?>


<div class="container mt-5 mb-5">
    <h2 class="mb-4">Order Details</h2>
    
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Order ID: #<?php echo $order['order_id']; ?></h5>
            <p><strong>Date:</strong> <?php echo formatDateTime($order['date']); ?></p>
            <p><strong>Status:</strong> 
                <span class="badge bg-<?php echo ($order['status'] == 'Completed') ? 'success' : 'warning'; ?>">
                    <?php echo ucfirst($order['status']); ?>
                </span>
            </p>
            <p><strong>Total Amount:</strong> ₦<?php echo formatNumber($order['total_amount'], 2); ?></p>
        </div>
    </div>

    <h4>Items Purchased</h4>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Item</th>
                    <th>Image</th>
                    <th>Original Price</th>
                    <th>Discounted Price</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($item = $items_result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $item['title']; ?></td>
                        <td><img src="../../<?php echo $imagePath.'/'; echo $item['picture']; ?>" alt="Product Image" style="width:50px; height:auto;"></td>
                        <td>₦<?php echo formatNumber($item['original_price'], 2); ?></td>
                        <td>₦<?php echo formatNumber($item['price'], 2); ?></td>
                        <td>1</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <a href="javascript:history.back()" class="btn btn-primary mt-3">Back to previous page</a>
</div>








<?php include "footer.php"; ?>