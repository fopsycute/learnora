<?php 
include "backend/connect.php";  



//previous page

$_SESSION['previous_page'] = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$previousPage=$_SESSION['previous_page'];
$current_page = urlencode(pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME) . '?' . $_SERVER['QUERY_STRING']);;

$code = "";
if (isset($_COOKIE['userID'])) {$code = $_COOKIE['userID'];}
$check = "SELECT * FROM ".$siteprefix."users WHERE s = '" . $code . "'";
$query = mysqli_query($con, $check);
if (mysqli_affected_rows($con) == 0) {


    $active_log = 0;
} else {
    $sql = "SELECT * FROM ".$siteprefix."users  WHERE s  = '".$code."'";
    $sql2 = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_array($sql2)) {
    $id = $row['s'];
    $title                = $row['title'];
    $display_name         = $row['display_name'];
    $first_name           = $row['first_name'];
    $middle_name          = $row['middle_name'];
    $last_name            = $row['last_name'];
    $company_name         = $row['company_name'];
    $company_profile      = $row['company_profile'];
    $company_logo         = $row['company_logo'];
    $biography            = $row['biography'];
    $loyalty_id           = $row['loyalty'];
    $profile_photo        = $row['profile_photo'];
    $age                  = $row['age'];
    $gender               = $row['gender'];
    $email_address        = $row['email_address'];
    $phone_number         = $row['phone_number'];
    $skills_hobbies       = $row['skills_hobbies'];
    $language             = $row['language'];
    $bank_name = $row['bank_name'];
    $bank_accname = $row['bank_accname'];
    $bank_number = $row['bank_number'];
    $proficiency          = $row['proficiency'];
    $n_office_address     = $row['n_office_address'];
    $f_office_address     = $row['f_office_address'];
    $category             = $row['category'];
    $subcategory          = $row['subcategory'];
    $facebook             = $row['facebook'];
    $last_login           = $row['last_login'];
    $created_date         = $row['created_date'];
    $instagram            = $row['instagram'];
    $twitter              = $row['twitter'];
    $linkedin             = $row['linkedin'];
    $state                = $row['state'];
    $lga                  = $row['lga'];
    $country              = $row['country'];
    $user_type            = $row['type'];
    $wallet = $row['wallet'];
    $trainer              = $row['trainer'];
    $reset_token          = $row['reset_token'];
    $reset_token_expiry   = $row['reset_token_expiry'];
// ...existing code... 
        $_SESSION['user_role'] = $user_type;
        $_SESSION['user_id'] = $id;
        $_SESSION['user_trainer'] = $trainer;

        $active_log = 1;
        $user_id = $id;
        $username = $display_name;
        $user_reg_date = formatDateTime($created_date);
        $user_lastseen=formatDateTime($last_login);


}}

include "backend/start_order.php";
include "backend/actions.php"; 

?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Index - FashionStore Bootstrap Template</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/drift-zoom/drift-basic.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: FashionStore
  * Template URL: https://bootstrapmade.com/fashion-store-bootstrap-template/
  * Updated: Apr 26 2025 with Bootstrap v5.3.5
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">

  <header id="header" class="header position-relative">
    <!-- Top Bar -->
    <div class="top-bar py-2 d-lg-block">
      <div class="container-fluid container-xl">
        <div class="row align-items-center">
           
          <!-- Add this block for your links, visible on all screens -->
<div class="col-12 my-2 my-lg-0">
  <ul class="list-unstyled d-flex flex-wrap mb-0 justify-content-center justify-content-lg-start">
    <li class="bg-secondary text-white p-2 me-2">
      <a class="text-white text-small" href="<?php echo $siteurl; ?>loyalty-program.php">Loyalty Program</a>
    </li>
    <li class="bg-primary text-white p-2 me-2">
      <a class="text-white text-small" href="<?php echo $siteurl; ?>affiliate-details.php">Affiliate Program</a>
    </li>
    <li class="bg-secondary text-white p-2 me-2 ">
      <a class="text-white text-small" href="<?php echo $siteurl; ?>marketplace.php">Marketplace</a>
    </li>
     <?php if($active_log==0){ ?>
                    <li class="bg-dark-orange p-2"><a class="" href="<?php echo $siteurl; ?>become_a_trainer.php">Become a Trainer</a></li>
                    <?php } else {?>
                    <li class="bg-dark-orange p-2"><a class="" href="<?php echo $siteurl; ?>logout.php">Logout</a></li>
                    <?php } ?>
  </ul>
</div>
          
        </div>
      </div>
    </div>

    <!-- Main Header -->
    <div class="main-header">
      <div class="container-fluid container-xl">
        <div class="d-flex py-3 align-items-center justify-content-between">

          <!-- Logo -->
          <a href="index" class="logo d-flex align-items-center">
            <!-- Uncomment the line below if you also wish to use an image logo -->
       <img src="<?php echo $siteurl . $imagePath . $siteimg; ?>" alt=""> 
        
          </a>

          <!-- Search -->
          <form class="search-form desktop-search-form" action="<?php echo $siteurl;?>search.php" method="get">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Search for events..." name="searchterm"  id="search_input">
              <button class="btn search-btn" type="submit">
                <i class="bi bi-search"></i>
              </button>
            </div>
          </form>

          <!-- Actions -->
          <div class="header-actions d-flex align-items-center justify-content-end">

            <!-- Mobile Search Toggle -->
            <button class="header-action-btn mobile-search-toggle d-xl-none" type="button" data-bs-toggle="collapse" data-bs-target="#mobileSearch" aria-expanded="false" aria-controls="mobileSearch">
              <i class="bi bi-search"></i>
            </button>

            <!-- Account -->
                     <!-- Account -->
            <div class="dropdown account-dropdown">
              <button class="header-action-btn" data-bs-toggle="dropdown">
                <i class="bi bi-person"></i>
              </button>
            <div class="dropdown-menu">
  <div class="dropdown-header">
    <h6>Welcome to <span class="sitename"><?php echo $sitename; ?></span></h6>
    <?php if($active_log==0){ ?>
      <p class="mb-0">Access account &amp; manage orders</p>
  </div>
  <div class="dropdown-footer">
    <a href="<?php echo $siteurl; ?>login" class="btn btn-primary w-100 mb-2">Sign In</a>
    <a href="<?php echo $siteurl; ?>register" class="btn btn-outline-primary w-100">Register</a>
  </div>
    <?php } else { ?>
      </div>
      <div class="dropdown-body">
        <a class="dropdown-item d-flex align-items-center" href="<?php echo $siteurl; ?>dashboard">
          <i class="bi bi-person-circle me-2"></i>
          <span>My Profile</span>
        </a>
        <a class="dropdown-item d-flex align-items-center" href="<?php echo $siteurl; ?>my_orders">
          <i class="bi bi-bag-check me-2"></i>
          <span>My Orders</span>
        </a>
        <a class="dropdown-item d-flex align-items-center" href="<?php echo $siteurl; ?>my_wishlist">
          <i class="bi bi-heart me-2"></i>
          <span>My Wishlist</span>
        </a>
        <a class="dropdown-item d-flex align-items-center" href="<?php echo $siteurl; ?>settings">
          <i class="bi bi-gear me-2"></i>
          <span>Settings</span>
        </a>
      </div>
      <div class="dropdown-footer">
        <a href="<?php echo $siteurl; ?>logout.php" class="btn btn-primary w-100 mb-2">Log Out</a>
      </div>
    <?php } ?>
</div>
            </div>
 <!-- Wishlist -->
             <?php
$wishlist_count = 0;
if (isset($user_id) && !empty($user_id)) {
    $wishlist_count = getWishlistCountByUser($con, $user_id);
    if ($wishlist_count === null) $wishlist_count = 0;
}
?>
          <a href="<?php echo $siteurl; ?>my_wishlist" class="header-action-btn d-none d-md-block">
  <i class="bi bi-heart"></i>
  <span class="badge wishlist-count"><?php echo $wishlist_count; ?></span>
</a>

            <!-- Cart -->
            <a href="<?php echo $siteurl; ?>cart.php" class="header-action-btn">
               <?php
                $cart_count = getCartCount($con, $siteprefix, $order_id);
                     ?>
              <i class="bi bi-cart3"></i>
               <?php if($cart_count >= 0): ?>
              <span class="badge cart-count"><?php echo $cart_count; ?></span>
              <?php endif; ?>
            </a>

            <!-- Mobile Navigation Toggle -->
            <i class="mobile-nav-toggle d-xl-none bi bi-list me-0"></i>

          </div>
        </div>
      </div>
    </div>

    <!-- Navigation -->
    <div class="header-nav">
      <div class="container-fluid container-xl">
        <div class="position-relative">
          <nav id="navmenu" class="navmenu">
            <ul>
              <li><a href="<?php echo $siteurl; ?>index.php" class="active">Home</a></li>
              <li><a href="<?php echo $siteurl; ?>about.php">About Us</a></li>
            <!---  <li><a href="<?php echo $siteurl; ?>blog.php">Blog</a></li> --->
              <li><a href="<?php echo $siteurl; ?>loyalty-program.php">Loyalty Program</a></li>


              <li class="products-megamenu-2">
  <a href="#">
    <span>Marketplace</span>
    <i class="bi bi-chevron-down toggle-dropdown"></i>
  </a>
  <!-- Mobile Mega Menu for Marketplace -->
  <ul class="mobile-megamenu">
    <?php
      $sql = "SELECT * FROM " . $siteprefix . "categories WHERE parent_id IS NULL";
      $sql2 = mysqli_query($con, $sql);
      while ($row = mysqli_fetch_array($sql2)) {
          $category_name = $row['category_name'];
          $slugs = $row['slug'];
          echo '<li><a href="' . $siteurl . 'category/' . $slugs . '">' . $category_name . '</a></li>';
      }
    ?>
    <li>
      <a class="font-weight-bold" href="<?php echo $siteurl; ?>marketplace.php">View Marketplace</a>
    </li>
  </ul>
  <!-- Desktop Mega Menu for Marketplace -->
  <div class="desktop-megamenu">
    <div class="row py-4 px-3">
      <?php
        $sql = "SELECT * FROM " . $siteprefix . "categories WHERE parent_id IS NULL";
        $sql2 = mysqli_query($con, $sql);
        $count = 0;
        while ($row = mysqli_fetch_array($sql2)) {
            $category_name = $row['category_name'];
            $slugs = $row['slug'];
            echo '<div class="col-md-4 col-6 mb-1">';
            echo '<a class="dropdown-item" style="white-space: normal;" href="' . $siteurl . 'category.php?slugs=' . $slugs . '">' . $category_name . '</a>';
            echo '</div>';
            $count++;
        }
      ?>
      <div class="col-12 mt-2">
        <a class="dropdown-item font-weight-bold" style="white-space: normal;" href="<?php echo $siteurl; ?>marketplace.php">View Marketplace</a>
      </div>
    </div>
  </div>
</li>

              <li><a href="<?php echo $siteurl; ?>contact.php">Contact</a></li>

            </ul>
          </nav>
        </div>
      </div>
    </div>

    <!-- Mobile Search Form -->
    <div class="collapse" id="mobileSearch">
      <div class="container">
        <form class="search-form">
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Search for products">
            <button class="btn" type="submit">
              <i class="bi bi-search"></i>
            </button>
          </div>
        </form>
      </div>
    </div>
   <input type="hidden" id="siteurl" value="<?php echo $siteurl; ?>">

    <!-- hidden form input ---->
    <input type="hidden" id="order_id" value="<?php echo $order_id; ?>">
     <input type="hidden" id="user_id" value="<?php if($active_log==1){echo $user_id; }?>">
  </header>