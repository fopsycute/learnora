
<?php 

include "header.php"; 

if (isset($_GET['slugs'])) {
    $raw_slug = $_GET['slugs'];
  
    $category_names = $raw_slug; // convert to lowercase for ma


    // Prepare SQL: match using LOWER to handle case insensitivity
    $sql = "SELECT * FROM " . $siteprefix . "categories WHERE slug = '$category_names'";
    $sql2 = mysqli_query($con, $sql);

    if (!$sql2) {
        die("Query failed: " . mysqli_error($con));
    }

    $count = 0;
    while ($row = mysqli_fetch_array($sql2)) {
        $id = $row['id'];
        $category_name = $row['category_name'];
        // You can use other fields here too if needed
    }
} else {
    header("Location: " . $siteurl . "index.php");
    exit();
}
$limit = 16; // Number of reports per page
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Handle sorting
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'relevance';
$order_by = "t.training_id DESC"; // Default sorting by relevance
if ($sort === 'price_high') {
    $order_by = "tt.price DESC";
} elseif ($sort === 'price_low') {
    $order_by = "tt.price ASC";
}

// Handle subcategory filtering
$subcategory_filter = isset($_GET['subcategory']) ? $_GET['subcategory'] : '';
$subcategory_condition = '';

if (!empty($subcategory_filter) && $subcategory_filter !== 'all') {
    $subcategory_condition = "AND sc.slug = '".mysqli_real_escape_string($con, $subcategory_filter)."'";
}

$query = "SELECT t.*, u.name as display_name, tt.price, u.photo as profile_picture, l.category_name AS category, sc.category_name AS subcategory, ti.picture 
    FROM ".$siteprefix."training t
    LEFT JOIN ".$siteprefix."categories l ON t.category = l.id 
    LEFT JOIN ".$siteprefix."instructors u ON t.instructors = u.s
    LEFT JOIN ".$siteprefix."categories sc ON t.subcategory = sc.id 
    LEFT JOIN ".$siteprefix."training_tickets tt ON t.training_id= tt.training_id
    LEFT JOIN ".$siteprefix."training_images ti ON t.training_id = ti.training_id
          WHERE t.status = 'approved' AND t.category='$id' $subcategory_condition 
          GROUP BY t.training_id
          ORDER BY $order_by 
          LIMIT $limit OFFSET $offset";
$result = mysqli_query($con, $query);
$report_count = mysqli_num_rows($result);

// Get total number of reports

$total_query = "SELECT COUNT(*) as total 
                FROM ".$siteprefix."training t 
                LEFT JOIN ".$siteprefix."categories sc ON t.subcategory = sc.id 
                WHERE t.status = 'approved' AND t.category='$id' $subcategory_condition";
$total_result = mysqli_query($con, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_reports = $total_row['total'];
$total_pages = ceil($total_reports / $limit);
?>

  <main class="main">

    <!-- Page Title -->
    <div class="page-title light-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0"><?php echo $category_name; ?></h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.html">Home</a></li>
            <li class="current">Category</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

        <div class="container" data-aos="fade-up">
       <div class="row mb-3">
        <div class="col-lg-12">

          <!-- Category Header Section -->
          <section id="category-header" class="category-header section">

            <div class="container" data-aos="fade-up">

              <!-- Filter and Sort Options -->
              <div class="filter-container mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="row g-3">
                  <div class="col-12 col-md-6 col-lg-4">
				    <div class="filter-item">
                      <label for="priceRange" class="form-label">filter By Subcategory</label>
                   <select id="subcategory-select" class="form-select" onchange="filterBySubcategory(this.value)">
                <option value="">Filter by Subcategory</option>
                <option value="all" <?php if (!isset($_GET['subcategory']) || $_GET['subcategory'] === 'all') echo 'selected'; ?>>Show All</option>
                <?php
                $subcat_query = "SELECT DISTINCT slug, category_name AS subcategory 
                                 FROM ".$siteprefix."categories 
                                 WHERE parent_id = $id";
                $subcat_result = mysqli_query($con, $subcat_query);
                while ($subcat_row = mysqli_fetch_assoc($subcat_result)) {
                     $subcategorySlug = $subcat_row['slug'];
    $selected = (isset($_GET['subcategory']) && $_GET['subcategory'] === $subcategorySlug) ? 'selected' : '';
    echo '<option value="'.htmlspecialchars($subcategorySlug).'" '.$selected.'>'.htmlspecialchars($subcat_row['subcategory']).'</option>';
                }
                ?>
            </select>
                  </div>
				    </div>

                      <div class="col-12 col-md-6 col-lg-6">
                    <div class="filter-item">
                      <label for="sortBy" class="form-label">Sort By</label>
                      <select id="sort-select" class="form-select" onchange="sortReports(this.value)">
                        <option value="" <?php if ($sort === '') echo 'selected'; ?> disabled>- Sort By -</option>
                <option value="relevance" <?php if ($sort === 'relevance') echo 'selected'; ?>>Relevance</option>
                <option value="price_high" <?php if ($sort === 'price_high') echo 'selected'; ?>>Price - High To Low</option>
                <option value="price_low" <?php if ($sort === 'price_low') echo 'selected'; ?>>Price - Low To High</option>
            </select>
                    </div>
                  </div>
                   </div>

                             <div class="row mt-3">
                  <div class="col-12" data-aos="fade-up" data-aos-delay="200">
                    <div class="active-filters">
                    
                      <div class="filter-tags">
                       
                        <button class="clear-all-btn">Found <?php echo $report_count; ?> report(s)</button>
                      </div>
                    </div>
                  </div>
                </div>
                 </div>

            </div>

          </section><!-- /Category Header Section -->

            <!-- Category Product List Section -->
          <section id="category-product-list" class="best-sellers section">

            <div class="container" data-aos="fade-up" data-aos-delay="100">

              <div class="row gy-4">
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
    echo "<p>No reports found.</p>";
}
?>
            </div>

                 </div>

      

          </section><!-- /Category Product List Section -->


                  <!-- Category Pagination Section -->
          <section id="category-pagination" class="category-pagination section">

            <div class="container">
              <nav class="d-flex justify-content-center" aria-label="Page navigation">
                <ul>
                      <?php if ($page > 1): ?>
                      <li>
                    <a href="?id=<?php echo $id; ?>&page=<?php echo $page - 1; ?>&sort=<?php echo $sort; ?>" aria-label="Previous page">
                      <i class="bi bi-arrow-left"></i>
                      <span class="d-none d-sm-inline">Previous</span>
                    </a>
                  </li>
                <?php endif; ?>
               

                
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                     <li> <a href="?id=<?php echo $id; ?>&page=<?php echo $i; ?>&sort=<?php echo $sort; ?>" class="btn btn-secondary <?php if ($i == $page) echo 'active'; ?>"><?php echo $i; ?></a></li>
                <?php endfor; ?>

                 <?php if ($page < $total_pages): ?>
                   <li> <a href="?id=<?php echo $id; ?>&page=<?php echo $page + 1; ?>&sort=<?php echo $sort; ?>" class="btn btn-primary"><span class="d-none d-sm-inline">Next</span>
                      <i class="bi bi-arrow-right"></i></a></li>
                <?php endif; ?>
                  
                </ul>
              </nav>
            </div>

          </section><!-- /Category Pagination Section -->
		     </div>
			    </div>
				 </div>

</main>

<script>
    function sortReports(sortValue) {
        const urlParams = new URLSearchParams(window.location.search);
        urlParams.set('sort', sortValue);
        window.location.search = urlParams.toString();
    }
</script>
<script>
    function filterBySubcategory(subcategory) {
        const urlParams = new URLSearchParams(window.location.search);
        if (subcategory === "all") {
            urlParams.delete('subcategory'); // Remove subcategory filter if "Show All" is selected
        } else {
            urlParams.set('subcategory', subcategory); // Set the selected subcategory
        }
        window.location.search = urlParams.toString(); // Reload the page with updated query parameters
    }
</script>

          <?php include "footer.php"; ?>