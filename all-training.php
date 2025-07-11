
<?php include "header.php"; ?>

    <section id="account" class="account section">

      <div class="container-fluid" data-aos="fade-up" data-aos-delay="100">

    

        <div class="row">
            <div class="col-lg-12">
                 <div class="profile-menu">
                 <div class="row">
          <!-- Profile Menu -->
          <div class="col-lg-2">
           
      <!-- User Info -->
              <div class="user-info" data-aos="fade-right">
                <div class="user-avatar">
                  <img src="<?php echo $imagePath.$profile_photo; ?>" alt="Profile" loading="lazy">
                </div>
                <h3> <?php echo htmlspecialchars($display_name); ?></h3>
           </div>
           </div>
		   
		   <div class="col-lg-10">
		   <div class="profile-links" data-aos="fade-left">
		     <?php include "links.php"; ?>
            </div>
</div>
		   </div>
              </div>		
			   </div>
           </div>
           </div>

</section>
    <section id="best-sellers" class="best-sellers section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
          <div class="row">
                        <?php
                        // 1. Get all PAID orders by the user
$orders = mysqli_query($con, "SELECT order_id FROM {$siteprefix}orders WHERE user = '$user_id' AND status = 'paid'");
$training_ids = [];

while ($order = mysqli_fetch_assoc($orders)) {
    $order_id = $order['order_id'];

    // 2. Get training IDs linked to this order (assuming there's a join table)
    $trainings = mysqli_query($con, "SELECT training_id FROM {$siteprefix}order_items WHERE order_id = '$order_id'");
    while ($t = mysqli_fetch_assoc($trainings)) {
        $training_ids[] = $t['training_id'];
    }
}

// Remove duplicates if multiple orders contain same training
$training_ids = array_unique($training_ids);

// 3. Loop through training IDs
foreach ($training_ids as $id) {

    $sql = "SELECT t.*, u.name AS display_name, u.photo AS profile_picture,
                   tv.video_path, et.name AS event_types, tt.price, 
                   l.category_name AS category, sc.category_name AS subcategory, 
                   ti.picture AS event_image, tem.event_date, tem.start_time, tem.end_time
            FROM {$siteprefix}training t
            LEFT JOIN {$siteprefix}categories l ON t.category = l.id 
            LEFT JOIN {$siteprefix}instructors u ON t.instructors = u.s
            LEFT JOIN {$siteprefix}categories sc ON t.subcategory = sc.id 
            LEFT JOIN {$siteprefix}training_tickets tt ON t.training_id = tt.training_id
            LEFT JOIN {$siteprefix}training_images ti ON t.training_id = ti.training_id 
            LEFT JOIN {$siteprefix}training_videos tv ON t.training_id = tv.training_id AND tv.video_type = 'promo'
            LEFT JOIN {$siteprefix}event_types et ON t.event_type = et.s
            LEFT JOIN {$siteprefix}training_event_dates tem ON t.training_id = tem.training_id
            WHERE t.status = 'approved' AND t.training_id = '$id'
            ORDER BY tem.event_date, tem.start_time
            LIMIT 1";

    $result = mysqli_query($con, $sql);
    if (!$result || mysqli_num_rows($result) == 0) continue;

    $row = mysqli_fetch_assoc($result);

    // Extract values
    $training_id = $row['training_id'];
    $title = $row['title'];
    $instructor_name = $row['display_name'];
    $image_paths = 'uploads/' . ($row['event_image'] ?: 'default.jpg');
    $training_video = 'uploads/' . $row['video_path'];
    $price = $row['price'];
    $format = ucfirst($row['delivery_format']);
    $category = $row['category'];
    $subcategory = $row['subcategory'];
    $tags = $row['tags'];
    $alt_title = $row['alt_title'];

    // Collect event dates
    $event_dates = [];
    mysqli_data_seek($result, 0); // reset pointer to loop again
    while ($d = mysqli_fetch_assoc($result)) {
        if (!empty($d['event_date'])) {
            $event_dates[] = [
                'event_date' => $d['event_date'],
                'start_time' => $d['start_time'],
                'end_time' => $d['end_time']
            ];
        }
    }

include "training-card.php"; // Include the card template
} // end foreach
?>








</div>
</div>
</section>

























<?php include "footer.php"; ?>