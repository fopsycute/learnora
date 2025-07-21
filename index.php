
<?php include "header.php"; ?>

    <!-- Hero Section -->
    <section class="ecommerce-hero-2 hero section" id="hero">
      <div class="container">
        <div class="hero-slider swiper init-swiper" data-aos="fade-up">
          <script type="application/json" class="swiper-config">
            {
              "loop": true,
              "speed": 800,
              "autoplay": {
                "delay": 5000
              },
              "effect": "fade",
              "fadeEffect": {
                "crossFade": true
              },
              "navigation": {
                "nextEl": ".swiper-button-next",
                "prevEl": ".swiper-button-prev"
              }
            }
          </script>
          <div class="swiper-wrapper">
            <!-- Sale Products Slide -->
            <div class="swiper-slide slide-sale">
              <div class="row align-items-center">
                <div class="col-lg-6 content-col" data-aos="fade-right" data-aos-delay="100">
                  <div class="slide-content">
                    <span class="slide-badge">Your Learning Starts Here</span>
                      <h1>Learn <span>Anywhere.</span> Grow on Your Terms</h1>
                    <p>Our platform is designed for modern learners. Whether you're commuting, on a break, or studying at home, Learnora gives you flexible, practical learning — tailored for Nigeria's growing talent.</p>
                    <div class="slide-cta">
                      <a href="<?php echo $siteurl; ?>marketplace.php" class="btn btn-shop">Shop Sale <i class="bi bi-arrow-right"></i></a>
                    </div>
             
                  </div>
                </div>
                <div class="col-lg-6 image-col" data-aos="fade-left" data-aos-delay="200">
                  <div class="sale-showcase">
                    <div class="main-product">
                      <img src="<?php echo $siteurl; ?>assets/img/learnora-hero (2).png" alt="Sale Product">
                      
                    </div>
                   
                  </div>
                </div>
              </div>
            </div>

            <!-- Featured Products Slide -->
            <div class="swiper-slide slide-featured">
              <div class="row align-items-center">
                <div class="col-lg-6 content-col" data-aos="fade-right" data-aos-delay="100">
                  <div class="slide-content">
                    <span class="slide-badge">Learnora</span>
                    <h1>Nigeria’s <span>Go-To Platform</span> for Learning & Growth</h1>
                  
                    <p>From tech and entrepreneurship to personal development, our platform offers relevant, real-world content that fits your lifestyle and goals.</p>
                    <div class="slide-cta">
                      <a href="<?php echo $siteurl; ?>marketplace.php" class="btn btn-shop">Explore Now<i class="bi bi-arrow-right"></i></a>
                    </div>
                   
                  </div>
                </div>
                <div class="col-lg-6 image-col" data-aos="fade-left" data-aos-delay="200">
                  <div class="featured-showcase">
                    <div class="featured-image">
                      <img src="<?php echo $siteurl; ?>assets/img/learnora-hero (1).png" alt="Featured Product">

                    </div>
                    <div class="floating-review" data-aos="fade-up" data-aos-delay="300">
                      <div class="review-stars">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                      </div>
                      <div class="review-text">
                        "Career-Ready Skills That Deliver Results"
                      </div>
                      <div class="review-author">
                        - Satisfied Customer
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="swiper-button-prev"></div>
          <div class="swiper-button-next"></div>
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
   Where status='approved'  GROUP BY t.s ORDER BY t.s DESC LIMIT 20";
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

     <section id="recent-posts" class="recent-posts section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Latest Articles</h2>
        <p></p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4">
 <?php
// Fetch forum posts
// Category filter

    $sql = "SELECT fp.*, u.display_name 
            FROM {$siteprefix}forum_posts fp 
            LEFT JOIN {$siteprefix}users u ON fp.user_id = u.s 
            ORDER BY fp.created_at DESC LIMIT 3";

$result = mysqli_query($con, $sql);


while ($row = mysqli_fetch_assoc($result)) {
    $s = $row['s'];
    $title = htmlspecialchars($row['title']);
    $date = date('d M Y', strtotime($row['created_at']));
    $uploader = htmlspecialchars($row['display_name']);
    $alt_title = htmlspecialchars($row['slug']);
     $image_path = $imagePath.$row['featured_image'];

    // Fetch category names
    $catNames = [];
    $catIds = [];

    if (!empty($row['categories'])) {
        // Break string into array of IDs
        $catIds = preg_split('/\s*,\s*/', trim($row['categories']));
        $catIds = array_filter(array_map('intval', $catIds)); // convert to int & filter empty
        if (!empty($catIds)) {
            $catIdList = implode(',', $catIds);
            $catSql = "SELECT id, category_name FROM {$siteprefix}categories WHERE id IN ($catIdList)";
            $catRes = mysqli_query($con, $catSql);
            while ($catRow = mysqli_fetch_assoc($catRes)) {
                $catNames[] = $catRow['category_name'];
            }
        }
    }
    include 'blog-card.php'; // Include the blog post template
}
?>
         
        </div>
      </div>

    </section><!-- /Recent Posts Section -->



    <!---- affiliate prompt -->

<section class="affiliate-prompt section">
  <div class="container">
    <div class="row align-items-center affiliate-prompt-container">
        <!-- Image Column -->
       <div class="col-md-5 mb-4 mb-md-0">
        <img src="<?php echo $siteurl;?>assets/img/lenora-affliate-2.png" alt="Join Marketplace" class="img-fluid affiliate-prompt-img">
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