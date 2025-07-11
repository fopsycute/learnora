<?php include "header.php"; ?>

  <main class="main">



 <!-- Cart Section -->
    <section id="cart" class="cart section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">
	   <div class="row g-4">
            
          <div class="col-lg-8" data-aos="fade-up" data-aos-delay="200">
            <div class="cart-items">
              <div class="cart-header d-none d-lg-block">
                <div class="row align-items-center gy-4">
                  <div class="col-lg-6">
                    <h5>Product</h5>
                  </div>
                  <div class="col-lg-2 text-center">
                    <h5>Price</h5>
                  </div>
                  <div class="col-lg-2 text-center">
                    <h5>Quantity</h5>
                  </div>
                  <div class="col-lg-2 text-center">
                    <h5>Total</h5>
                  </div>
                </div>
              </div>

                    <?php 
                    if($active_log== 0) {
                        $message="You need to login to view your cart. <a href='login.php'>Login here</a>";
                        displayMessage($message);
                    } else if (getCartCount($con, $siteprefix, $order_id) == 0) {
                        $message="Your cart is empty. <a href='marketplace.php'>Start shopping here</a>";
                        displayMessage($message);
                    } else {
                    // Assuming database connection exists

                         $sql = "SELECT oi.*, t.title as training_title, t.alt_title, oi.price, ti.picture 
                        FROM ".$siteprefix."order_items oi
                        JOIN ".$siteprefix."training t ON oi.training_id = t.training_id
                        LEFT JOIN ".$siteprefix."training_images ti ON t.training_id = ti.training_id
                        WHERE oi.order_id = ? 
                        GROUP BY oi.s";

                    $stmt = mysqli_prepare($con, $sql);
                    mysqli_stmt_bind_param($stmt, 's', $order_id);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    
                    while ($item = mysqli_fetch_assoc($result)):
    $picture = $imagePath . $item['picture'];
    $title = $item['training_title'];
    $alt_title = $item['alt_title'];
    $slug = $alt_title;

       
?>

             <!-- Cart Item 1 -->
   <div class="cart-item" data-aos="fade-up" data-aos-delay="100" id="cart-item-<?php echo htmlspecialchars($item['s']); ?>">
        <div class="row align-items-center gy-4">
            <div class="col-lg-6 col-12 mb-3 mb-lg-0">
                <div class="product-info d-flex align-items-center">
                    <div class="product-image">
                        <img src="<?php echo htmlspecialchars($picture); ?>" alt="<?php echo htmlspecialchars($item['training_title']); ?>" class="img-fluid" loading="lazy">
                    </div>
                    <div class="product-details">
                        <a href="<?php echo $siteurl; ?>product/<?php echo $slug; ?>">
                            <h6 class="product-title"><?php echo htmlspecialchars($item['training_title']); ?></h6>
                        </a>
                        <div class="product-meta">
                           
                        </div>
                        <button class="remove-item"  data-item-id="<?php echo htmlspecialchars($item['s']); ?>">
                            <i class="bi bi-trash"></i> Remove
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-2 text-center">
                <div class="price-tag">
                    <span class="current-price"><?php echo $sitecurrency; echo formatNumber($item['price'], 2); ?></span>
                </div>
            </div>
            <div class="col-12 col-lg-2 text-center">
                <div class="quantity-selector">
                    <input type="number" class="quantity-input" value="1" min="1" max="10" readonly>
                </div>
            </div>
            <div class="col-12 col-lg-2 text-center mt-3 mt-lg-0">
                <div class="item-total">
                    <span><?php echo $sitecurrency; echo formatNumber($item['price'], 2); ?></span>
                </div>
            </div>
        </div>
    </div>
<?php endwhile;
                    mysqli_stmt_close($stmt); }
                    ?>
                 
                </div>
            </div>
			      <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
      <?php if($active_log != 0): ?>
<div class="cart-summary">
  <div class="summary-total">
    <span class="summary-label">Total</span>

    <span class="summary-value"><?php echo $sitecurrency; ?><strong class='cart-total'><?php echo $order_total;?></strong></span>
  </div>
  <div class="checkout-button">
    <a href="checkout.php" class="btn btn-accent w-100">
      Proceed to Checkout <i class="bi bi-arrow-right"></i>
    </a>
  </div>
  <div class="continue-shopping">
    <a href="marketplace.php" class="btn btn-link w-100">
      <i class="bi bi-arrow-left"></i> Continue Shopping
    </a>
  </div>
</div>
<?php endif; ?>
          </div>
		     </div>

      </div>

    </section><!-- /Cart Section -->

  </main>
    <?php include "footer.php"; ?>