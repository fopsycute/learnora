
<?php 
include "header.php"; 
include "event-details.php";

//get and decode affliate_id if it exists
$affliate_id = isset($_GET['affiliate']) ? base64_decode($_GET['affiliate']) : 0;
$event_passed = false;
if (!empty($event_dates)) {
    $now = date('Y-m-d H:i:s');
    $all_past = true;
    foreach ($event_dates as $ed) {
        $event_end = $ed['event_date'] . ' ' . $ed['end_time'];
        if ($event_end >= $now) {
            $all_past = false;
            break;
        }
    }
    $event_passed = $all_past;
}


$is_in_cart = false;
if (isset($order_id)) {
   
    $sql = "SELECT COUNT(*) as count FROM {$siteprefix}order_items WHERE training_id = '$training_id' AND order_id = '$order_id'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    if ($row['count'] > 0) {
        $is_in_cart = true;
    }
}


// Check if user has purchased THIS product
$purchase_query = "SELECT * FROM ".$siteprefix."orders o 
JOIN ".$siteprefix."order_items oi ON o.order_id = oi.order_id 
WHERE o.user = ? AND oi.training_id = ? AND o.status = 'paid'";
$stmt = $con->prepare($purchase_query);
$stmt->bind_param("ss", $user_id, $training_id);
$stmt->execute();
$purchase_result = $stmt->get_result();
$user_purchased= $purchase_result->num_rows > 0;

// Check if user already left a review
$existing_review_query = "SELECT * FROM ".$siteprefix."reviews WHERE user = ? AND training_id = ?";
$stmt = $con->prepare($existing_review_query);
$stmt->bind_param("si", $user_id, $training_id);
$stmt->execute();
$existing_review_result = $stmt->get_result();
$user_review = $existing_review_result->fetch_assoc();

 
?>
 <!-- Product Details Section -->
    <section id="product-details" class="product-details section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gx-2 gy-1">
		
          <!-- Product Images Column -->
          <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-right" data-aos-delay="200">
		  <div class="row">
		  <div class="col-12">
		  		  <div class="product-data">
              <!-- Product Meta -->
              <div class="product-meta">
                     <div class="d-flex justify-content-between align-items-center mb-3">
                  <span class="product-category"><?php echo $event_type; ?></span>
                  <div class="product-share">
                    <button class="share-btn" id="webShareBtn" aria-label="Share product">
                      <i class="bi bi-share"></i>
                    </button>
                    <div class="share-dropdown">
                   <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode($siteurl . 'events?slug=' . $slug); ?>&text=<?php echo urlencode($title); ?>" 
     target="_blank" rel="noopener" title="Share on Twitter">
    <i class="bi bi-twitter"></i>
  </a>

  <!-- Facebook -->
  <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($siteurl . 'events?slug=' . $slug); ?>" 
     target="_blank" rel="noopener" title="Share on Facebook">
    <i class="bi bi-facebook"></i>
  </a>

  <!-- LinkedIn -->
  <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode($siteurl . 'events?slug=' . $slug); ?>&title=<?php echo urlencode($title); ?>" 
     target="_blank" rel="noopener" title="Share on LinkedIn">
    <i class="bi bi-linkedin"></i>
  </a>

                    </div>
                  </div>
                </div>
			      <h4 class="product-title"><?php echo $title; ?></h4>
				  
				      <div class="row mb-1">
                    <div class="col-6">
                        <h6>Created by: </h6>
                      <div class="user_info mb-1 d-flex">
                    <img src="<?php echo $siteurl . $imagePath . $siteimg; ?>" alt="<?php echo $sitename; ?>" class="user-image rounded-circle me-2" width="32" height="32">
                    <span class="mt-3"><?php echo $sitename; ?></span>
                </div>
             </div>
                <div class="col-6">
              
                <div class="product-rating">
                  <div class="stars">
                    <?php
                     for ($i = 1; $i <= 5; $i++) {
        if ($average_rating >= $i) {
            echo '<i class="bi bi-star-fill"></i>';
        } elseif ($average_rating >= $i - 0.5) {
            echo '<i class="bi bi-star-half"></i>';
        } else {
            echo '<i class="bi bi-star"></i>';
        }
    }
    ?>
    <span class="rating-value"><?php echo htmlspecialchars($average_rating, ENT_QUOTES, 'UTF-8'); ?></span>
                  </div>
                 
                </div>
              </div>

                  <div class="col-6">
        <!-- Instructor Section -->
        <h6>Instructor:</h6>
        <div class="user_info mb-1 d-flex">
            <img src="<?php echo $siteurl . $instructor_picture; ?>" alt="<?php echo $instructor_name; ?>" class="user-image rounded-circle me-2" width="32" height="32">
            <span class="mt-3"><?php echo $instructor_name; ?></span>
        </div>
    </div>
            </div>
			  </div>
            </div>
            <div class="product-gallery mb-3">
            
              <!-- Main Image -->
              <div class="main-image-wrapper">
                <div class="image-zoom-container">
                  <a href="<?php echo $siteurl.$image_paths; ?>" class="glightbox" data-gallery="product-gallery">
                    <img src="<?php echo $siteurl.$image_paths; ?>" alt="Product Image" class="img-fluid main-image drift-zoom" id="main-product-image" data-zoom="<?php echo $siteurl.$image_paths; ?>">
                    <div class="zoom-overlay">
                      <i class="bi bi-zoom-in"></i>
                    </div>
                  </a>
                </div>
              </div>
			  </div>
			   </div>
			  
			  
			    
<!-- Course Info & Review Tabs Column -->
<div class="col-12 mb-3" data-aos="fade-left" data-aos-delay="300">
  <div class="card shadow-sm">
    <div class="card-body">
      <!-- Nav tabs -->
      <ul class="nav nav-tabs mb-3" id="courseTab" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab" aria-controls="info" aria-selected="true">
            Course Info
          </button>
        </li>
          <?php if ($user_purchased) { ?>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="review-tab" data-bs-toggle="tab" data-bs-target="#review" type="button" role="tab" aria-controls="review" aria-selected="false">
            Review
          </button>
        </li>

        <?php } ?>
      </ul>
      <!-- Tab panes -->
      <div class="tab-content" id="courseTabContent">
        <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
                 <div class="row" data-aos="fade-up">
          <div class="col-12">
            <div class="product-details-accordion">     
                   <?php if (!empty($course_description)) { ?>
        <!-- Description Accordion -->
              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#description" aria-expanded="true" aria-controls="description">
                    Course Description
                  </button>
                </h2>
                <div id="description" class="accordion-collapse collapse show">
                  <div class="accordion-body">
                    <div class="product-description">
<?php
$desc_words = explode(' ', strip_tags($course_description));
$desc_short = implode(' ', array_slice($desc_words, 0, 30));
$isLongDesc = count($desc_words) > 30;
?>
<p>
  <span class="desc-short"><?php echo htmlspecialchars($desc_short); ?><?php if ($isLongDesc) echo '...'; ?></span>
  <?php if ($isLongDesc): ?>
    <span class="desc-full" style="display:none;"><?php echo $course_description; ?></span>
    <br>
    <button type="button" class="btn btn-link btn-sm p-0 desc-read-more" style="text-decoration: none;">Read More</button>
    <button type="button" class="btn btn-link btn-sm p-0 desc-read-less" style="text-decoration: none; display:none;">Read Less</button>
  <?php endif; ?>
</p>
                    </div>
                  </div>
                </div>
				 </div>
                <?php } ?>
                <?php
                if (!empty($course_requirrement)) {

                    ?>
                  <!-- Specifications Accordion -->
              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#specifications" aria-expanded="false" aria-controls="specifications">
                    Course Requirements 
                  </button>
                </h2>
                <div id="specifications" class="accordion-collapse collapse">
                  <div class="accordion-body">
                    <div class="product-specifications">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="specs-group">
                            <p><?php echo $course_requirrement; ?></p>
                              </div>
                        </div>
                            </div>
                </div>
                </div>
              </div>
            </div>
			<?php } ?>
			
			      
                   <?php if (!empty($learning_objectives)) { ?>
        <!-- Description Accordion -->
              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#objective" aria-expanded="true" aria-controls="objective">
                    Course Description
                  </button>
                </h2>
                <div id="objective" class="accordion-collapse collapse show">
                  <div class="accordion-body">
                    <div class="product-description">

                      <p><?php echo $learning_objectives; ?></p>
                    </div>
                  </div>
                </div>
				</div>
                <?php } ?>

                <!--- training video -->
                <?php if (!empty($training_video)): ?>
<!-- Video Accordion -->
<div class="accordion-item">
  <h2 class="accordion-header">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#trainingVideo" aria-expanded="false" aria-controls="trainingVideo">
      Course Video
    </button>
  </h2>
  <div id="trainingVideo" class="accordion-collapse collapse">
    <div class="accordion-body">
      <div class="product-video">
        <video controls width="100%">
          <source src="<?php echo $training_video; ?>" type="video/mp4">
          Your browser does not support the video tag.
        </video>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>
              
                </div>
                </div>
              </div>
        </div>
	
<?php if ($user_purchased) { ?>
        <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
          <!-- Review Content -->
           <div class="product-details-accordion"> 
  <!-- Reviews Accordion -->
              <div class="accordion-item" id="reviews">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#reviewsContent" aria-expanded="true" aria-controls="reviewsContent">
                    Write a Review
                  </button>
                </h2>
                <div id="reviewsContent" class="accordion-collapse collapse show">
                  <div class="accordion-body">
                    <div class="product-reviews">
                     <div class="review-form-container mt-5">
                        <h4>Write a Review</h4>
                             <form class="review-form" method="POST">
                         <input type="hidden" name="training_id" value="<?php echo $training_id; ?>">
                        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                        <div class="rating-select mb-4">
                          <label class="form-label">Your Rating</label>
                          <div class="star-rating">
                            <input type="radio" id="star5" name="rating" value="5"><label for="star5" title="5 stars"><i class="bi bi-star-fill"></i></label>
                              <input type="radio" id="star4" name="rating" value="4"><label for="star4" title="4 stars"><i class="bi bi-star-fill"></i></label>
                              <input type="radio" id="star3" name="rating" value="3"><label for="star3" title="3 stars"><i class="bi bi-star-fill"></i></label>
                              <input type="radio" id="star2" name="rating" value="2"><label for="star2" title="2 stars"><i class="bi bi-star-fill"></i></label>
                              <input type="radio" id="star1" name="rating" value="1"><label for="star1" title="1 star"><i class="bi bi-star-fill"></i></label>
                          </div>
                        </div>
                        <div class="mb-4">
                          <label for="review-content" class="form-label">Your Review</label>
                          <textarea class="form-control" id="review-content" rows="4" name="review" required=""></textarea>

                        </div>

                        <div class="d-grid">
                          <button type="submit" name="submit-review" class="btn btn-primary">Submit Review</button>
                        </div>
                      </form>
                      </div>
                      </div>
                      </div>
                      </div>
                      </div>
					  
             <?php
// Fetch all reviews for the product
$all_reviews_query = "SELECT r.*, u.display_name AS user_name 
                      FROM {$siteprefix}reviews r
                      JOIN {$siteprefix}users u ON r.user = u.s
                      WHERE r.training_id = ?
                      ORDER BY r.date DESC";

$stmt = $con->prepare($all_reviews_query);
$stmt->bind_param("i", $training_id);
$stmt->execute();
$all_reviews_result = $stmt->get_result();
$all_reviews = $all_reviews_result->fetch_all(MYSQLI_ASSOC);
?>
					     <?php if (!empty($all_reviews)): ?>
                    <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#reviewssummary" aria-expanded="false" aria-controls="reviewssummary">
                 All Reviews
                  </button>
                </h2>
                <div id="reviewssummary" class="accordion-collapse collapse">
                  <div class="accordion-body">
                     <div class="product-reviews">
<div class="reviews-summary">
  <div class="row">
    <div class="col-lg-4">
      <div class="overall-rating">
        <div class="rating-number"><?php echo number_format($average_rating, 1); ?></div>
        <div class="rating-stars">
          <?php
          for ($i = 1; $i <= 5; $i++) {
            if ($average_rating >= $i) {
              echo '<i class="bi bi-star-fill"></i>';
            } elseif ($average_rating >= $i - 0.5) {
              echo '<i class="bi bi-star-half"></i>';
            } else {
              echo '<i class="bi bi-star"></i>';
            }
          }
          ?>
        </div>
        <div class="rating-count">
          Based on <?php echo (int)$review_count; ?> review<?php echo ($review_count == 1 ? '' : 's'); ?>
        </div>
      </div>
    </div>
    <div class="col-lg-8">
      <div class="rating-breakdown">
        <?php
          for ($i = 5; $i >= 1; $i--) {
              echo getRatingBar($i, $ratings[$i], $review_count);
          }
        ?>
      </div>
    </div>
  </div>
</div>
                      </div>

<div class="reviews-list mt-5" id="reviews-list">
  <h4>Customer Reviews</h4>

  <?php foreach ($all_reviews as $i => $review): ?>
    <div class="review-item mb-4" style="<?php echo $i > 2 ? 'display:none;' : ''; ?>">
      <div class="review-header d-flex justify-content-between align-items-center">
        <div class="reviewer-info d-flex align-items-center">
          <div>
            <h5 class="reviewer-name mb-0"><?php echo htmlspecialchars($review['user_name']); ?></h5>
            <div class="review-date"><?php echo date('m/d/Y', strtotime($review['date'])); ?></div>
          </div>
        </div>
        <div class="review-rating">
          <?php
            $rating = (int)$review['rating'];
            for ($j = 1; $j <= 5; $j++) {
              echo $j <= $rating ? '<i class="bi bi-star-fill"></i>' : '<i class="bi bi-star"></i>';
            }
          ?>
        </div>
      </div>
      <div class="review-content mt-2">
        <p><?php echo nl2br(htmlspecialchars($review['review'])); ?></p>
      </div>
    </div>
  <?php endforeach; ?>

  <?php if (count($all_reviews) > 3): ?>
    <div class="text-center">
      <button id="loadMoreReviews" class="btn btn-outline-primary btn-sm">Load More</button>
    </div>
  <?php endif; ?>


</div>



        </div>
		
      </div>
    </div>
	

    <?php else: ?>
  <p>No reviews yet.</p>
    <?php endif; ?>
	</div>
  </div>
  <?php }  ?>

</div>
   </div>
     </div>
	 </div>
            </div>
          </div>


          <!-- Product Info Column -->
          <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
		  <div class="row">
		  <div class="col-12">
            <div class="product-info-wrapper" id="product-info-sticky">
              <!-- Product Meta -->
              <div class="product-meta">
               <div class="product-short-description">
                <p>   
                     <?php 
    $words = explode(' ', $description);
    $shortDesc = implode(' ', array_slice($words, 0, 10));
    $isLong = str_word_count($description) > 10;
    ?>

    <span class="short-description"><?php echo htmlspecialchars($shortDesc); ?><?php if ($isLong) echo '...'; ?></span>

    <?php if ($isLong): ?>
        <span class="full-description" style="display: none;"><?php echo nl2br(htmlspecialchars($description)); ?></span>
        <br>
        <button type="button" class="btn btn-link btn-sm p-0 read-more-btn" style="text-decoration: none;">Read More</button>
        <button type="button" class="btn btn-link btn-sm p-0 read-less-btn" style="text-decoration: none; display:none;">Read Less</button>
    <?php endif; ?>
</p>
              </div>
              <!-- Product Price -->
              <div class="product-price-container">
                <div class="price-wrapper">
                  <span class="current-price">
            <?php
                if ($pricing === 'paid') {
                echo $sitecurrency . $price;
                } elseif ($pricing === 'free') {
                echo 'Free';
                } elseif ($pricing === 'donation') {
                echo 'Donate';
                }
            ?>
            </span>
              </div>
             <div class="mb-1">
                 <?php if ($loyalty == 1): ?>
				 
        <span class="badge text-light bg-danger mb-1">Loyalty Material</span>

        <?php endif; ?>
        <?php if ($loyalty_id < 1 && $price > 0 ): ?>
        <h6>Buy for Less – <a href="<?php echo $siteurl;?>loyalty-program.php">Sign up</a> as a loyalty member today!</h6>
       <div class="product-loyalty-container mb-4">
            
             <?php
// Fetch all loyalty plans
$loyalty_query = "SELECT name, discount FROM {$siteprefix}subscription_plans WHERE status = 'active'";
$loyalty_result = mysqli_query($con, $loyalty_query);

if ($loyalty_result && mysqli_num_rows($loyalty_result) > 0) {
    $loyalty_badges = [];
    while ($row = mysqli_fetch_assoc($loyalty_result)) {
        $plan_name = $row['name'];
        $discount = $row['discount']; // Discount percentage
        $discounted_price = $price - ($price * ($discount / 100)); // Calculate discounted price
        // Add a data-discount attribute for JS
        ?>
        <span class="badge text-light bg-primary me-1 loyalty-badge"
              data-discount="<?php echo $discount; ?>"
              data-plan="<?php echo htmlspecialchars($plan_name); ?>">
            <a href="<?php echo $siteurl;?>loyalty-program.php" class="text-white text-decoration-none">
                <span class="loyalty-plan-name"><?php echo $plan_name; ?></span> - ₦
                <span class="loyalty-price"><?php echo formatNumber($discounted_price, 2); ?></span>
            </a>
        </span>
        <?php
    }
} ?>
          </div>

    <?php endif; ?>
</div>
            

              <!-- Action Buttons -->

<div class="product-actions">
    <?php if ($event_passed): ?>
        <span class="badge bg-danger">Event Passed</span>
    <?php elseif ($user_purchased): ?>
        <a href="<?php echo $siteurl; ?>dashboard.php" class="btn btn-success">
            <i class="bi bi-person"></i> Go to Dashboard
        </a>
    <?php else: ?>
        <?php if ($pricing === 'paid' || $pricing === 'free') : ?>
            <?php if ($is_in_cart): ?>
                <a href="<?php echo $siteurl; ?>cart.php" class="btn btn-primary add-to-cart-btn">
                    <i class="bi bi-cart-check"></i> View Cart
                </a>
            <?php else: ?>
                <input type="hidden" name="affliate_id" id="affliate_id" value="<?php echo $affliate_id; ?>">
                <input type="hidden" name="training_id" id="current_training_id" value="<?php echo $training_id; ?>">
                <button class="btn btn-primary add-to-cart-btn" data-report="<?php echo $training_id; ?>" name="add" id="addCart">
                    <i class="bi bi-cart-plus"></i> Add to Cart
                </button>
            <?php endif; ?>
        <?php elseif ($pricing === 'donation'): ?>
            <button class="btn btn-primary donate-btn" type="button"
                id="donateBtn"
                data-training-id="<?php echo $training_id; ?>"
                data-affiliate-id="<?php echo $affliate_id; ?>"
                data-orders_id="<?php echo uniqid('OD'); ?>">
                <i class="bi bi-cash-coin"></i> Donate
            </button>
        <?php endif; ?>

        <!-- Wishlist button is always shown if event hasn't passed -->
      <button class="btn btn-outline-secondary wishlist-btn<?php echo $theinitialicon ? ' '.$theinitialicon : ''; ?>" data-product-id="<?php echo $training_id; ?>" aria-label="Add to wishlist">
            <i class="bi bi-heart"></i>
        </button>
    <?php endif; ?>
    
</div>

<div class="inhouse-proposal my-3 p-3 border rounded bg-light">
    <h6 class="mb-2"><i class="bi bi-building"></i> REQUEST AN IN-HOUSE PROPOSAL</h6>
    <p class="mb-1">
        Want this Seminar for your Organization? Please let us know if you wish to conduct this seminar on an in-house basis.
    </p>
    <a href="<?php echo $siteurl; ?>inhouse-proposal.php?training_id=<?php echo $training_id; ?>" class="btn btn-outline-primary btn-sm">
        Request In-House Proposal
    </a>
</div>

<div>

<a href="attendees.php?training_id=<?php echo $training_id; ?>" class="btn btn-primary">
    See Who’s Attending
</a>

        </div>

		  </div>
      </div>
	    </div>
      </div>
	  
	  <div class="col-12 mb-3" data-aos="fade-left" data-aos-delay="300">
       <!-- Language and Event Dates/Times Table (Borderless) -->
               <div class="table-actions">
 <table class="table table-borderless mt-3">
    <tbody>
        <tr>
            <td><i class="bi bi-bar-chart"></i> Level:</td>
            <td><?php echo htmlspecialchars($level); ?></td>
        </tr>
        <tr>
            <td><i class="bi bi-translate"></i> Language:</td>
            <td><?php echo htmlspecialchars($language); ?></td>
        </tr>
        <tr>
            <td><i class="bi bi-people"></i> Target Audience:</td>
            <td><?php echo htmlspecialchars($target_audience); ?></td>
        </tr>

        <!-- ✅ Insert Delivery Format Location Info -->
        <?php echo $delivery_details; ?>

        <!-- ✅ Event Dates -->
        <?php if (!empty($event_dates)): ?>
            <?php foreach ($event_dates as $ed): ?>
                <tr>
                    <td><i class="bi bi-calendar-event"></i> Date & Time:</td>
                    <td>
                        <?php
                        echo date('D, M j, Y', strtotime($ed['event_date'])) . ' — ';
                        echo date('g:ia', strtotime($ed['start_time'])) . ' to ' . date('g:ia', strtotime($ed['end_time']));
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td><i class="bi bi-calendar-event"></i> Date & Time:</td>
                <td>No scheduled dates yet.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

                </div>

                    </div>

                
<div class="col-12">
  <div class="table-requirements">

    <!-- Visa Requirement Section -->
    <div class="collapsible-section mb-4">
      <h6>Visa Requirement</h6>
      <?php
      $visa_text = "<strong>Nigerian Trainings:</strong> If you do not live in Nigeria and wish to attend one of our conferences, you may need to secure a visitor visa. Advance travel planning and early visa application are important, since applications are subject to a greater degree of scrutiny than in the past.

You can download a letter of invitation if needed. <strong>Please Note:</strong> we do not provide personalized letters of invitation. Attendees who are citizens of Visa Waiver Program participating countries generally do not need a letter of invitation.

Visit <a href=\"https://portal.immigration.gov.ng/pages/welcome\" target=\"_blank\">https://portal.immigration.gov.ng/pages/welcome</a> for complete information on how to apply for a visitor visa.

<strong>Foreign Trainings:</strong> If you want to attend the training outside Nigeria, you would need a visa. 365 Market Research Reports does not secure visa on behalf of trainees. Please visit the embassy of the country where the training will take place for your visa.";
      $visa_words = explode(' ', strip_tags($visa_text));
      $visa_short = implode(' ', array_slice($visa_words, 0, 30));
      $visa_long = $visa_text;
      $visa_is_long = count($visa_words) > 30;
      ?>
      <p>
        <span class="short-desc"><?php echo $visa_short; ?><?php if ($visa_is_long) echo '...'; ?></span>
        <?php if ($visa_is_long): ?>
          <span class="full-desc" style="display:none;"><?php echo $visa_long; ?></span>
          <br>
          <button type="button" class="btn btn-link btn-sm p-0 read-more-btn" style="text-decoration: none;">Read More</button>
          <button type="button" class="btn btn-link btn-sm p-0 read-less-btn" style="text-decoration: none; display:none;">Read Less</button>
        <?php endif; ?>
      </p>
    </div>

    <!-- Cancellation Policy Section -->
    <div class="collapsible-section">
      <h6>Cancellation Policy</h6>
      <?php
      $cancel_text = "All cancellations must be received in writing. Cancellations made after three (3) days to the event date will result in full registration fee.

Cancellations would attract twenty percent (20%) of the ticket price as penalty. Persons who sign up for the training but do not attend will be charged the full registration price.

Substitutions or name changes can be made at any time. Cancellation requests can be sent by email to <a href=\"mailto:hello@learnora.ng\">hello@learnora.ng</a> or by call to <a href=\"tel:+2348033782777\">+234 (0) 803 3782 777</a> or <a href=\"tel:+23412952413\">+234 (01) 29 52 413</a>.";
      $cancel_words = explode(' ', strip_tags($cancel_text));
      $cancel_short = implode(' ', array_slice($cancel_words, 0, 30));
      $cancel_long = $cancel_text;
      $cancel_is_long = count($cancel_words) > 30;
      ?>
      <p>
        <span class="short-desc"><?php echo $cancel_short; ?><?php if ($cancel_is_long) echo '...'; ?></span>
        <?php if ($cancel_is_long): ?>
          <span class="full-desc" style="display:none;"><?php echo $cancel_long; ?></span>
          <br>
          <button type="button" class="btn btn-link btn-sm p-0 read-more-btn" style="text-decoration: none;">Read More</button>
          <button type="button" class="btn btn-link btn-sm p-0 read-less-btn" style="text-decoration: none; display:none;">Read Less</button>
        <?php endif; ?>
      </p>
    </div>

  </div>
</div>
        </div>               
</div>
	    </div>
      </div>

     

    </section><!-- /Product Details Section -->

<script>

document.getElementById('webShareBtn').addEventListener('click', function() {
  if (navigator.share) {
    navigator.share({
      title: "<?php echo addslashes($title); ?>",
      text: "<?php echo addslashes($title); ?>",
      url: "<?php echo $siteurl . 'events/' . $slug; ?>"
    });
  } else {
    alert('Sharing is not supported in this browser. Please use the social icons.');
  }
});


</script>



<?php include "footer.php"; ?>