
<?php include "header.php"; ?>



<main class="main">

    <!-- Page Title -->
    <div class="page-title light-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Blog</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php">Home</a></li>
            <li class="current">Blog</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

<section id="recent-posts" class="recent-posts section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>All Posts</h2>
        <p></p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4">
 <?php

// Pagination setup
$postsPerPage = 3; // Number of posts per page
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $postsPerPage;

// Category filter
$categoryFilter = isset($_GET['category']) ? intval($_GET['category']) : 0;

// Count total posts for pagination
$countSql = "SELECT COUNT(*) as total FROM {$siteprefix}forum_posts";
if ($categoryFilter > 0) {
    $countSql .= " WHERE FIND_IN_SET($categoryFilter, categories)";
}
$countRes = mysqli_query($con, $countSql);
$totalPosts = mysqli_fetch_assoc($countRes)['total'];
$totalPages = ceil($totalPosts / $postsPerPage);

// Build SQL with LIMIT and OFFSET
if ($categoryFilter > 0) {
    $sql = "SELECT fp.*, u.display_name 
            FROM {$siteprefix}forum_posts fp 
            LEFT JOIN {$siteprefix}users u ON fp.user_id = u.s 
            WHERE FIND_IN_SET($categoryFilter, fp.categories)
            ORDER BY fp.created_at DESC
            LIMIT $offset, $postsPerPage";
} else {
    $sql = "SELECT fp.*, u.display_name 
            FROM {$siteprefix}forum_posts fp 
            LEFT JOIN {$siteprefix}users u ON fp.user_id = u.s 
            ORDER BY fp.created_at DESC
            LIMIT $offset, $postsPerPage";
}
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

<div class="pagination-container text-center mt-4">
  <?php if ($totalPages > 1): ?>
    <nav>
      <ul class="pagination justify-content-center">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
          <li class="page-item<?php if ($i == $page) echo ' active'; ?>">
            <a class="page-link" href="?page=<?php echo $i; ?><?php if ($categoryFilter > 0) echo '&category=' . $categoryFilter; ?>">
              <?php echo $i; ?>
            </a>
          </li>
        <?php endfor; ?>
      </ul>
    </nav>
  <?php endif; ?>
</div>
    </section><!-- /Recent Posts Section -->
</main>


<?php include 'footer.php'; ?>