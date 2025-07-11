

<?php include "header.php"; 


$limit = 16; // Number of reports per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$filter = isset($_GET['filter']) ? $_GET['filter'] : '';

$order_by = "t.training_id DESC"; // Default order
switch ($filter) {
    case 'low to high':
        $order_by = "tt.price ASC";
        break;
    case 'high to low':
        $order_by = "tt.price DESC";
        break;
    case 'newest':
        $order_by = "t.created_at DESC";
        break;
    case 'oldest':
        $order_by = "t.created_at ASC";
        break;
    case 'a-z':
        $order_by = "t.title ASC";
        break;
    case 'z-a':
        $order_by = "t.title DESC";
        break;
}

$query = "SELECT t.*, u.name as display_name, tt.price, u.photo as profile_picture, l.category_name AS category, sc.category_name AS subcategory, ti.picture 
    FROM ".$siteprefix."training t
    LEFT JOIN ".$siteprefix."categories l ON t.category = l.id 
    LEFT JOIN ".$siteprefix."instructors u ON t.instructors = u.s
    LEFT JOIN ".$siteprefix."categories sc ON t.subcategory = sc.id 
    LEFT JOIN ".$siteprefix."training_tickets tt ON t.training_id= tt.training_id
    LEFT JOIN ".$siteprefix."training_images ti ON t.training_id = ti.training_id 
WHERE t.status = 'approved' 
GROUP BY t.training_id 
ORDER BY $order_by 
LIMIT $limit OFFSET $offset";
$result = mysqli_query($con, $query);
//if (!$result) {die('Error in SQL query: ' . mysqli_error($con));}
$report_count = mysqli_num_rows($result);


// Get total number of reports
// Get total number of reports
$total_query = "SELECT COUNT(*) as total FROM ".$siteprefix."training WHERE status = 'approved'";
$total_result = mysqli_query($con, $total_query);
if (!$total_result) {
    die('Error in total query: ' . mysqli_error($con));
}
$total_row = mysqli_fetch_assoc($total_result);
$total_reports = $total_row['total'];
$total_pages = ceil($total_reports / $limit);
?>

    <!-- Search Results Header Section -->
    <section id="search-results-header" class="search-results-header section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="search-results-header">
          <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
              <div class="results-count" data-aos="fade-right" data-aos-delay="200">
                
               <div class="active-filters">
                    
                      <div class="filter-tags">
                       
                        <button class="clear-all-btn">Found <?php echo $report_count; ?> report(s)</button>
                      </div>
                    </div>
              </div>
            </div>
               <div class="col-lg-6 text-lg-end mt-3 mt-lg-0">
                  <div class="search-filters mt-4" data-aos="fade-up" data-aos-delay="400">
                   <form id="filter-form" method="GET" action="marketplace.php">
                <input type="hidden" name="page" value="<?php echo $page; ?>">
                <div class="sort-options">
                  <label for="sort-select" class="me-2">Sort by:</label>
                  <select  id="filter-select" name="filter" class="form-select form-select-sm d-inline-block w-auto" onchange="document.getElementById('filter-form').submit();">
                    <option value="">- Filter by -</option>
                    <option value="low to high">Price (low to high)</option>
                            <option value="high to low">Price (high to low)</option>
                            <option value="newest">Newest</option>
                            <option value="oldest">Oldest</option>
                            <option value="a-z">Title A-Z</option>
                            <option value="z-a">Title Z-A</option>
                  </select>
                </div>
              </div>
              </div>
          </div>

        </div>
      </div>

    </section><!-- /Search Results Header Section -->


    <section id="best-sellers" class="best-sellers section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row g-4">
          <?php
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
                } else {
                    debug('No events found.');
                }
                ?>
         

        </div>

      </div>

    </section><!-- /Search Product List Section -->
 <!-- Category Pagination Section -->
    <section id="category-pagination" class="category-pagination section">

      <div class="container">
        <nav class="d-flex justify-content-center" aria-label="Page navigation">
          <ul>
                <?php if ($page > 1): ?>
                   <li>
              <a href="?searchterm=<?php echo $filter; ?>&page=<?php echo $page - 1; ?>" aria-label="Previous page">
                <i class="bi bi-arrow-left"></i>
                <span class="d-none d-sm-inline">Previous</span>
              </a>
            </li>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
         <li> <a href="?searchterm=<?php echo $filter; ?>&page=<?php echo $i; ?>" class="btn btn-secondary <?php if ($i == $page) echo 'active'; ?>"><?php echo $i; ?></a>  </li>
    <?php endfor; ?>

    <?php if ($page < $total_pages): ?>
         <li>
              <a href="#" aria-label="Next page">
                <span class="d-none d-sm-inline">Next</span>
                <i class="bi bi-arrow-right"></i>
              </a>
            </li>
        
    <?php endif; ?>

          
          </ul>
        </nav>
      </div>

    </section><!-- /Category Pagination Section -->



</main>














<?php include "footer.php"; ?>