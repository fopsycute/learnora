<?php
if (isset($_GET['slug'])) {
    $raw_slug = $_GET['slug'];
    $title = mysqli_real_escape_string($con, $raw_slug);

    // Get training ID from slug
    $slug_sql = "SELECT training_id FROM {$siteprefix}training 
                 WHERE LOWER(alt_title) = LOWER('$title') AND status = 'approved' LIMIT 1";
    $slug_result = mysqli_query($con, $slug_sql);

    if ($slug_row = mysqli_fetch_assoc($slug_result)) {
        $id = $slug_row['training_id'];

        // Fetch all data including event dates
        $sql = "SELECT t.*, u.name AS display_name, tv.video_path, et.name AS event_types, tt.price, 
                       u.photo AS profile_picture, l.category_name AS category, 
                       sc.category_name AS subcategory, ti.picture AS event_image,
                       tem.event_date, tem.start_time, tem.end_time
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
                ORDER BY tem.event_date, tem.start_time";

        $result = mysqli_query($con, $sql);
        if (!$result) {
            die("Query failed: " . mysqli_error($con));
        }

        if (mysqli_num_rows($result) == 0) {
            header("Location: $previousPage");
            exit();
        }

        // Initialize
        $event_dates = [];
        $rowCounter = 0;

        // Loop through all results (for event dates)
        while ($row = mysqli_fetch_assoc($result)) {
            if ($rowCounter === 0) {
                // Set training info from first row
                $training_id = $row['training_id'];
                $title = $row['title'];
                $alt_title = $row['alt_title'];
                $description = $row['description'];
                $category = $row['category'];
                $subcategory = $row['subcategory'];
                $loyalty = $row['loyalty'];
                $pricing = $row['pricing'];
               
                $price = $row['price'];
                $tags = $row['tags'];
                $level = $row['level'];
                $language = $row['Language'];
                $instructor_name = $row['display_name'];
                $instructor_picture =  $imagePath .$row['profile_picture'];
                $target_audience = $row['target_audience'];
                $created_date = $row['created_at'];
                $status = $row['status'];
                $course_requirrement = $row['course_requirrement'];
                $course_description = $row['course_description'];
                $image_paths = $imagePath . $row['event_image'];
                $slug = $alt_title;
                $training_video = $imagePath . $row['video_path'];
                $event_type = $row['event_types'] ?? '';
                $format = ucfirst($row['delivery_format']);
            }

            $delivery_details = '';

if ($format === 'Physical') {
    $fields = [
        'physical_address' => 'Address',
        'physical_state' => 'State',
        'physical_lga' => 'LGA',
        'physical_country' => 'Country',
        'foreign_address' => 'Foreign Address'
    ];
    foreach ($fields as $col => $label) {
        if (!empty($row[$col])) {
            $delivery_details .= "<tr><td><i class='bi bi-geo-alt'></i> $label:</td><td>" . htmlspecialchars($row[$col]) . "</td></tr>";
        }
    }
} elseif ($format === 'Hybrid') {
    $fields = [
        'hybrid_physical_address' => 'Physical Address',
        'hybrid_state' => 'State',
        'hybrid_lga' => 'LGA',
        'hybrid_country' => 'Country',
        'hybrid_foreign_address' => 'Foreign Address'
    ];
    foreach ($fields as $col => $label) {
        if (!empty($row[$col])) {
            $delivery_details .= "<tr><td><i class='bi bi-geo-alt'></i> $label:</td><td>" . htmlspecialchars($row[$col]) . "</td></tr>";
        }
    }
} elseif ($format === 'Online') {
    $delivery_details .= "<tr><td><i class='bi bi-geo-alt'></i> Format:</td><td>Online (Link will be sent after registration)</td></tr>";
}
            // Append each event date
            if (!empty($row['event_date']) && !empty($row['start_time']) && !empty($row['end_time'])) {
                $event_dates[] = [
                    'event_date' => $row['event_date'],
                    'start_time' => $row['start_time'],
                    'end_time' => $row['end_time']
                ];
            }

            $rowCounter++;
        }
          // ✅ Add this here
    
    } else {
        header("Location: $previousPage");
        exit();
    }
} else {
    header("Location: $previousPage");
    exit();
}

// $loyalty_id=0;
if($active_log != 1){
$loyalty_id=0;
}

$rating_data = calculateRating($training_id, $con, $siteprefix);
$average_rating = $rating_data['average_rating'];
$review_count = $rating_data['review_count'];
$ratings = $rating_data['ratings'];

 $theinitialicon="";
        if($active_log==1){
        $checkEmail = mysqli_query($con, "SELECT * FROM ".$siteprefix."wishlist WHERE user='$user_id' AND product='$training_id'");
        if(mysqli_num_rows($checkEmail) >= 1 ) {
        $theinitialicon="added";}}
?>
