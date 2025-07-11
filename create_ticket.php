<?php include "header.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
  <main class="main">
    <!-- Page Title -->
    <div class="page-title light-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Create Ticket</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php">Home</a></li>
            <li class="active"><a href="tickets.php">All Tickets</a></li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->
    <!-- Checkout Section -->
    <section id="checkout" class="checkout section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row">
          <div class="col-lg-9 mx-auto">
            <div class="checkout-container" data-aos="fade-up">
              <form method="post" enctype="multipart/form-data">
                <!-- Customer Information -->
                <div class="checkout-section">
                  <div class="section-header">
                   <!--- <div class="section-number">1</div> --->
                    <h3>Create Ticket</h3>  
                  </div>
                       
                  <div class="section-content">
				     <!-- Name Fields -->
                    <div class="row">
                      <div class="col-12 form-group">
                        <label>Dispute Category:</label>
                       <select name="category" class="form-control"  required>
    <option value="Product Quality Issues">Product Quality Issues</option>
        <option value="Wrong Item Received">Wrong Item Received</option>
        <option value="Item Not Delivered">Item Not Delivered</option>
        <option value="Refund Issues">Refund Issues</option>
        <option value="Login/Access Problems">Login/Access Problems</option>
        <option value="Account Security">Account Security</option>
        <option value="Technical Bugs">Technical Bugs</option>
        <option value="User Experience Issues">User Experience Issues</option>
        <option value="Poor Support Experience">Poor Support Experience</option>
        <option value="Policy Disputes">Policy Disputes</option>
        <option value="Loyalty Program">Loyalty Program</option>
        <option value="Affiliate Program">Affiliate Program</option>
        <option value="Fake or Misleading Reviews">Fake or Misleading Reviews</option>
        <option value="Payment Issues">Payment Issues</option>
    </select>
                      </div>
                      
					  </div>    
                <div class="row mb-3">
                  <div class="col-md-12 form-group">
                  
                 <label>Order Reference:</label>
    <select name="order_id" id="order_id" class="form-control" required onchange="getOrderDetails(this.value)">
        <option value="">Select Order</option>
        <?php 
        $sql = "SELECT * FROM ".$siteprefix."orders WHERE user = '$user_id' ORDER BY date DESC";
        $result = mysqli_query($con, $sql);
        while ($row = mysqli_fetch_assoc($result)): ?>
            <option value="<?= $row['order_id']; ?>"><?= $row['order_id']; ?>(<?= $row['status']; ?>)</option>
        <?php endwhile; ?>
    </select>

    <p>Recipient Involved</p>
  <div id="orderDetails">
    
    </div>
        </div>
				  </div>


                 <div class="row mb-3">
                  <div class="col-md-12 form-group">
        
		   </div>
		  </div>
		  
		  
			<div class="mb-3"><label>Issue Title:</label>
    <textarea name="issue" class="form-control" maxlength="100" rows="3"></textarea>
    </div>
    
    <div class="mb-3"><label>Upload Evidence:</label>
    <input type="file" name="evidence[]" class="form-control" multiple required>
    </div>
	 
	 
	 
	 			<div class="row mb-3">

						 <div class="col-md-12 form-group">			
					<button type="submit" value="submit" name="create_dispute" class="btn btn-primary w-100">
                    <span class="btn-text">Submit</span>
                  </button>
							 </div>	 
								 </div>
           
				</div>
</form>
           		</div>
			    </div>
				</div>
			    </div>

    </section><!-- /Checkout Section -->
  </main>
<script>
document.addEventListener('DOMContentLoaded', () => {
  const orderIdInput = document.getElementById('order_id');
  const orderId = orderIdInput ? orderIdInput.value : null;

  if (orderId) {
    getOrderDetails(orderId);
  }
});

function getOrderDetails(orderId) {
  if (!orderId) {
    console.warn('No order ID provided.');
    return;
  }

  fetch('get_order_details.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: new URLSearchParams({ order_id: orderId })
  })
  .then(response => {
    if (!response.ok) {
      throw new Error('Network response was not OK');
    }
    return response.text(); // Expecting HTML from PHP
  })
  .then(html => {
    const orderDetailsEl = document.getElementById('orderDetails');
    if (orderDetailsEl) {
      orderDetailsEl.innerHTML = html;
    }
  })
  .catch(error => {
    console.error('Error fetching order details:', error);
  });
}


</script>
<?php include 'footer.php'; ?>