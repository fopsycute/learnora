
<?php

  //check if its in wishlist
         $theinitialicon="";
        if($active_log==1){
        $checkEmail = mysqli_query($con, "SELECT * FROM ".$siteprefix."wishlist WHERE user='$user_id' AND product='$training_id'");
        if(mysqli_num_rows($checkEmail) >= 1 ) {
        $theinitialicon="added";}}

        // Fetch all images for this training
 // Fetch all images for this training
$images = [];
$sql_images = "SELECT picture FROM {$siteprefix}training_images WHERE training_id = '$training_id'";
$result_images = mysqli_query($con, $sql_images);
while ($imgRow = mysqli_fetch_assoc($result_images)) {
    $images = $imagePath . $imgRow['picture'];
}

?>

<div class="col-6 col-lg-3">
            <div class="product-card" data-aos="zoom-in">
            <div class="product-image">
                             
    <img src="<?php echo $siteurl . $images; ?>" class="main-image img-fluid" alt="event" loading="lazy">
       <div class="product-actions">

                <form method="post" style="display:inline;" >
        <input type="hidden" name="remove_wishlist_id" value="<?php echo $training_id; ?>">
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
        <button class="btn-remove action-btn" type="submit" name="remove_wishlist" aria-label="Remove from wishlist">
            <i class="bi bi-trash"></i>
        </button>
    </form>
                </div>
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
        echo 'Donate Any Amount';
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



         