 <div class="swiper-slide">
<?php
 // Fetch all images for this training
$images = [];
$sql_images = "SELECT picture FROM {$siteprefix}training_images WHERE training_id = '$training_id'";
$result_images = mysqli_query($con, $sql_images);
while ($imgRow = mysqli_fetch_assoc($result_images)) {
    $images = $imagePath . $imgRow['picture'];
}
?>

  <div class="product-card" >
        
            <div class="product-image">
                             
    <img src="<?php echo $siteurl . $images; ?>" class="main-image img-fluid" alt="event" loading="lazy">
                <div class="product-badge">
                    <span class="badge badge-text"><?php echo $category; ?></span>
                    <span class="badge badge-text"><?php echo $subcategory; ?></span>
                </div>
              </div>
              <div class="product-details">
                <div class="product-category"><?php echo $resourceTypeNames; ?></div>
                <h4 class="product-title"><a href="<?php echo $siteurl; ?>events?slug=<?php echo $alt_title; ?>"><?php echo $title; ?></a></h4>
                <div class="product-meta">
              <div class="product-price">
    <?php
      if ($pricing === 'paid') {
        echo $sitecurrency.$price;
      } elseif ($pricing === 'free') {
        echo 'Free';
      } elseif ($pricing === 'donation') {
        echo 'Donate';
      }
    ?>
  </div>
                  <div class="product-rating">
                    <i class="bi bi-star-fill"></i>
                    <?php echo number_format($average_rating, 1); ?> <span>(<?php echo $review_count; ?>)</span>
                  </div>
                </div>
              </div>
            </div>
          </div>


