
<?php include "header.php"; ?>


    <!-- Hero Section -->
 <section class="ecommerce-hero-1 hero section hero-bg" id="hero">
   <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-7 content-col" data-aos="fade-right" data-aos-delay="100">
            <div class="content">
              <span class="promo-badge">Learnora </span>
              <h1>Nigeria’s<span>Go-To Platform</span> for Learning</h1>
              <p>Learnora is Nigeria’s go-to platform for learning new skills and personal development. Whether you're looking to boost your career, start a business, or grow personally, Learnora offers practical courses, expert insights, and resources tailored to the Nigerian audience. Learn anytime, grow every day.</p>
              <div class="hero-cta">
                <a href="<?php echo $siteurl;?>marketplace" class="btn btn-shop">Shop Now <i class="bi bi-arrow-right"></i></a>

              </div>
          
            </div>
          </div>
          <div class="col-lg-3 image-col" data-aos="fade-left" data-aos-delay="200">

          </div>
        </div>
      </div>
    </section><!-- /Hero Section -->

  

    <!-- Best Sellers Section -->
    <section id="best-sellers" class="best-sellers section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Best Events</h2>
        <p>Join trending events, sharpen your skills, and connect with the best in your field.</p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row g-4">
          <!-- Product 1 -->
          <?php
$query = "SELECT t.*, u.name as display_name, tt.price, u.photo as profile_picture, l.category_name AS category, sc.category_name AS subcategory, ti.picture 
    FROM ".$siteprefix."training t
    LEFT JOIN ".$siteprefix."categories l ON t.category = l.id 
    LEFT JOIN ".$siteprefix."instructors u ON t.instructors = u.s
    LEFT JOIN ".$siteprefix."categories sc ON t.subcategory = sc.id 
    LEFT JOIN ".$siteprefix."training_tickets tt ON t.training_id= tt.training_id
    LEFT JOIN ".$siteprefix."training_images ti ON t.training_id = ti.training_id 
   Where status='approved'  GROUP BY t.s ORDER BY t.s DESC LIMIT 4";
$result = mysqli_query($con, $query);
if ($result) {
while ($row = mysqli_fetch_assoc($result)) {
        $training_id = $row['training_id'];
        $title = $row['title'];
        $alt_title = $row['alt_title'];
        $description = $row['description'];
        $category = $row['category'];
        $subcategory = $row['subcategory'];
        $pricing = $row['pricing'];
        $price = $row['price'];
        $tags = $row['tags'];
        $user = $row['display_name'];
        $user_picture = $imagePath.$row['profile_picture'];
        $created_date = $row['created_at'];
        $status = $row['status'];
        $image_path = $imagePath.$row['picture'];
        $slug = $alt_title;
        $event_type = $row['event_type'] ?? '';
    

            $sql_resource_type = "SELECT name FROM {$siteprefix}event_types WHERE s = $event_type";
            $result_resource_type = mysqli_query($con, $sql_resource_type);

            while ($typeRow = mysqli_fetch_assoc($result_resource_type)) {
                $resourceTypeNames = $typeRow['name'];
            }
$rating_data = calculateRating($training_id, $con, $siteprefix);
    $average_rating = $rating_data['average_rating'];
    $review_count = $rating_data['review_count'];
        include "event-card.php"; // Include the product card template
        }
      
?>
       </div>
  <div class="text-center mt-5" data-aos="fade-up">
          <a href="<?php echo $siteurl; ?>marketplace" class="view-all-btn">View All Events <i class="bi bi-arrow-right"></i></a>

		  <?php } else {  debug('No reports not found.'); }?>
        </div>


        </div>

      </div>

    </section><!-- /Best Sellers Section -->


    
   <!-- Recent Reports Swiper Section -->
    <section id="best-sellers" class="best-sellers section">
  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="section-title text-center mb-4">
      <h2>Recent Events</h2>
      <p>Stay up to date with the latest workshops, trainings, and learning sessions.</p>
    </div>
    <div class="recent-reports-slider swiper init-swiper">
      <script type="application/json" class="swiper-config">
        {
          "loop": true,
          "autoplay": {
            "delay": 4000,
            "disableOnInteraction": false
          },
          "grabCursor": true,
          "speed": 600,
          "slidesPerView": "auto",
          "spaceBetween": 20,
          "navigation": {
            "nextEl": ".recent-swiper-button-next",
            "prevEl": ".recent-swiper-button-prev"
          },
          "breakpoints": {
            "320": {
              "slidesPerView": 2,
              "spaceBetween": 10
            },
            "576": {
              "slidesPerView": 2,
              "spaceBetween": 15
            },
            "768": {
              "slidesPerView": 3,
              "spaceBetween": 20
            },
            "992": {
              "slidesPerView": 4,
              "spaceBetween": 20
            }
          }
        }
      </script>
      <div class="swiper-wrapper">
          <?php
$query = "SELECT t.*, u.name as display_name, tt.price, u.photo as profile_picture, l.category_name AS category, sc.category_name AS subcategory, ti.picture 
    FROM ".$siteprefix."training t
    LEFT JOIN ".$siteprefix."categories l ON t.category = l.id 
    LEFT JOIN ".$siteprefix."instructors u ON t.instructors = u.s
    LEFT JOIN ".$siteprefix."categories sc ON t.subcategory = sc.id 
    LEFT JOIN ".$siteprefix."training_tickets tt ON t.training_id= tt.training_id
    LEFT JOIN ".$siteprefix."training_images ti ON t.training_id = ti.training_id 
   Where status='approved'  GROUP BY t.s ORDER BY t.s DESC LIMIT 10";
$result = mysqli_query($con, $query);
if ($result) {
while ($row = mysqli_fetch_assoc($result)) {
        $training_id = $row['training_id'];
        $title = $row['title'];
        $alt_title = $row['alt_title'];
        $description = $row['description'];
        $category = $row['category'];
        $subcategory = $row['subcategory'];
        $pricing = $row['pricing'];
        $price = $row['price'];
        $tags = $row['tags'];
        $user = $row['display_name'];
        $user_picture = $imagePath.$row['profile_picture'];
        $created_date = $row['created_at'];
        $status = $row['status'];
        $image_path = $imagePath.$row['picture'];
        $slug = $alt_title;
        $event_type = $row['event_type'] ?? '';
    

            $sql_resource_type = "SELECT name FROM {$siteprefix}event_types WHERE s = $event_type";
            $result_resource_type = mysqli_query($con, $sql_resource_type);

            while ($typeRow = mysqli_fetch_assoc($result_resource_type)) {
                $resourceTypeNames = $typeRow['name'];
            }
$rating_data = calculateRating($training_id, $con, $siteprefix);
    $average_rating = $rating_data['average_rating'];
    $review_count = $rating_data['review_count'];
            // Each slide
            include "swiper-card.php"; // Use your existing product card template
          }
        }
        ?>
      </div>
      <div class="recent-swiper-button-next swiper-button-next"></div>
      <div class="recent-swiper-button-prev swiper-button-prev"></div>
    </div>
  </div>
</section>



    <!---- affiliate prompt -->

<section class="affiliate-prompt section">
  <div class="container">
    <div class="row align-items-center affiliate-prompt-container">

      <!-- Image Column -->
      <div class="col-md-5 mb-4 mb-md-0">
        <img src="<?php echo $siteurl;?>assets/img/lenora-affliate.png" alt="Join Marketplace" class="img-fluid affiliate-prompt-img">
      </div>
      <!-- Content Column -->
      <div class="col-md-7">
        <div class="affiliate-prompt-content text-center text-md-start">
          <h2 class="mb-3">Join Affiliate</h2>
          <p class="mb-4">Want to turn your followers, friends, or blog readers into real cash?
Join the Learnora.ng Affiliate Program and start earning 8% commission on every course sale — effortlessly!

📚 Learnora.ng is Nigeria’s leading online learning platform, with in-demand courses in tech, business, personal growth, and more. The best part? You don’t need to be a pro — just share your unique link and earn every time someone signs up through you</p>
          <div class="affiliate-buttons d-flex justify-content-center justify-content-md-start gap-3 flex-wrap">
            <a href="<?php echo $siteurl; ?>affiliate-details" class="btn btn-primary register-btn">Join Affiliate</a>
          
          </div>
          </div>
        </div>
      </div>
    
  </div>
 
</section>















<?php include "footer.php"; ?>