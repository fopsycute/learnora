
<?php
include "header.php";

if (isset($_GET['training'])) {
    $training_id = $_GET['training'];
}

$event_dates = [];
$training_data_set = false;

// Fetch training and event data
$query = "SELECT t.*, u.name AS display_name, tv.video_path, et.name AS event_types, tt.price, tt.ticket_name, tt.benefits, tt.seats,
                 u.photo AS profile_picture, l.category_name AS category, 
                 sc.category_name AS subcategory, ti.picture AS event_image, ti.s AS image_id,
                 tem.event_date, tem.start_time, tem.end_time, tem.s
          FROM {$siteprefix}training t
          LEFT JOIN {$siteprefix}categories l ON t.category = l.id 
          LEFT JOIN {$siteprefix}instructors u ON t.instructors = u.s
          LEFT JOIN {$siteprefix}categories sc ON t.subcategory = sc.id 
          LEFT JOIN {$siteprefix}training_tickets tt ON t.training_id = tt.training_id
          LEFT JOIN {$siteprefix}training_images ti ON t.training_id = ti.training_id 
          LEFT JOIN {$siteprefix}training_videos tv ON t.training_id = tv.training_id AND tv.video_type = 'promo'
          LEFT JOIN {$siteprefix}event_types et ON t.event_type = et.s
          LEFT JOIN {$siteprefix}training_event_dates tem ON t.training_id = tem.training_id
          WHERE t.training_id = '$training_id'";

$result = mysqli_query($con, $query);
if (!$result) {
    die('Query Failed: ' . mysqli_error($con));
}

while ($row = mysqli_fetch_assoc($result)) {
    // Set training info once
    if (!$training_data_set) {
        $training_id = $row['training_id'];
        $title = $row['title'];
        $selected_instructor_id = $row['instructors'];
        $alt_title = $row['alt_title'];
        $description = $row['description'];
        $category = $row['category'];
        $image_id = $row['image_id'];
        $subcategory = $row['subcategory'];
        $loyalty = $row['loyalty'];
        $pricing = $row['pricing'];
        $attendee = $row['attendee'];
        $price = $row['price'];
        $tags = $row['tags'];
        $level = $row['level'];
        $certification = $row['certification'];
        $language = $row['Language'];
        $instructor_name = $row['display_name'];
        $instructor_picture = $imagePath . $row['profile_picture'];
        $target_audience = $row['target_audience'];
        $created_date = $row['created_at'];
        $status = $row['status'];
        $additional_notes = $row['additional_notes'];
        $course_requirrement = $row['course_requirrement'];
        $course_description = $row['course_description'];
        $image_paths = $imagePath . $row['event_image'];
        $quiz_method = $row['quiz_method'];
        $slug = $alt_title;
        $training_video = $imagePath . $row['video_path'];
        $selected_event_type = $row['event_types'] ?? '';
        $format = $row['delivery_format'];
        $selected_resource_type = explode(',', $row['use_case'] ?? '');
        $physical_country = $row['physical_country'];
        $foreign_address = $row['foreign_address'];
        $physical_address = $row['physical_address'];
        $physical_state = $row['physical_state'];
        $physical_lga = $row['physical_lga'];
        $web_address = $row['web_address'];
        $hybrid_physical_address = $row['hybrid_physical_address'];
        $hybrid_web_address = $row['hybrid_web_address'];
        $hybrid_country = $row['hybrid_country'];
        $hybrid_foreign_address = $row['hybrid_foreign_address'];
        $hybrid_state = $row['hybrid_state'];
        $hybrid_lga = $row['hybrid_lga'];
        $training_data_set = true;
    }

    // Add event dates
    if (!empty($row['event_date']) && !empty($row['start_time']) && !empty($row['end_time'])) {
        $event_dates[] = [
            'event_date' => $row['event_date'],
            'start_time' => $row['start_time'],
            'end_time' => $row['end_time'],
            's' => $row['s']
        ];
    }
}

if (!$training_data_set) {
    echo 'Event not found.';
    exit;
}
?>

<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <div class="col-xl">
      <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h4 class="mb-0">Add New Training Listings</h4>
        </div>
        <div class="card-body">
          <form method="POST" enctype="multipart/form-data">

            <h6>Event Details</h6>
            <div class="mb-3">
              <label class="form-label">Title</label>
              <input type="text" class="form-control" name="title" value="<?php echo $title; ?>" required>
            </div>
            
                            <input type="hidden" id="training-id" name="training-id" class="form-control" value="<?php echo $training_id; ?>" readonly required>
                <div class="image-preview">
                          <img class="preview-image" src="<?php echo $siteurl . $image_paths ?>" alt="Training Image">
                           <button type="button" class="delete-btn delete-image" data-image-id="<?php echo $image_id; ?>">X</button>
                            </div>
            <div class="mb-3">
              <label class="form-label">Cover Image</label>
              <input type="file" class="form-control" name="cover_images" accept="image/*"  required>
            </div>
            <div class="mb-3">
              <label class="form-label">Description</label>
              <textarea class="form-control" name="description" required><?php echo $description; ?></textarea>
            </div>
            <div class="mb-3">
              <label class="form-label">Who Should Attend</label>
              <input type="text" class="form-control" name="who_should_attend" placeholder="E.g. Beginners, Entrepreneurs, etc." value="<?php echo $attendee; ?>">
            </div>
          <div class="mb-3">
  <label class="form-label">Event Dates & Times</label>
 <div id="dateTimeRepeater">
  <?php foreach ($event_dates as $ev) { ?>
    <div class="row mb-2 dateTimeRow">
      <input type="hidden" name="event_ids[]" value="<?= $ev['s'] ?>">
      <div class="col">
        <input type="date" class="form-control" name="event_dates[]" value="<?= $ev['event_date'] ?>" required>
      </div>
      <div class="col">
        <input type="time" class="form-control" name="event_start_times[]" value="<?= $ev['start_time'] ?>" required>
      </div>
      <div class="col">
        <input type="time" class="form-control" name="event_end_times[]" value="<?= $ev['end_time'] ?>" required>
      </div>
      <div class="col-auto">
        <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.dateTimeRow').remove()">-</button>
      </div>
    </div>
  <?php } ?>
</div>

<button type="button" class="btn btn-success btn-sm mt-2" onclick="addDateTimeRow()">
  <i class="bx bx-plus me-1"></i> Add
</button>

</div>

<div class="mb-3">
              <label class="form-label">Language</label>
              <input type="text" class="form-control" name="language" value="<?php echo $language; ?>" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Certification Offered?</label>
              <select class="form-control" name="certification">
                <option value="yes" <?php echo ($certification == 'yes') ? 'selected' : ''; ?>>Yes</option>
                <option value="no" <?php echo ($certification == 'no') ? 'selected' : ''; ?>>No</option>
              </select>
            </div>
                 <input type="hidden" name="user" value="<?php echo $user_id; ?>">
            <div class="mb-3">
              <label class="form-label">Level</label>
              <select class="form-control" name="level" required>
                <option value="">Select Level</option>
                <option value="beginner" <?php echo ($level == 'beginner') ? 'selected' : ''; ?>>Beginner</option>
                <option value="intermediate" <?php echo ($level == 'intermediate') ? 'selected' : ''; ?>>Intermediate</option>
                <option value="advanced" <?php echo ($level == 'advanced') ? 'selected' : ''; ?>>Advanced</option>
              </select>
            </div>

              <h6>Delivery Format</h6>
<div class="mb-3">
  <select class="form-control" name="delivery_format" id="deliveryFormat" onchange="toggleDeliveryFields()" required>
    <option value="">Select Format</option>
    <option value="physical" <?= ($format == 'physical') ? 'selected' : '' ?>>Physical (In-person)</option>
    <option value="online" <?= ($format == 'online') ? 'selected' : '' ?>>Online (Webinar/Virtual)</option>
    <option value="hybrid" <?= ($format == 'hybrid') ? 'selected' : '' ?>>Hybrid (Physical & Online)</option>
    <option value="video" <?= ($format == 'video') ? 'selected' : '' ?>>Video</option>
    <option value="text" <?= ($format == 'text') ? 'selected' : '' ?>>Text</option>
  </select>
</div>

<!-- Physical Format Fields -->
<div id="physicalFields" class="mb-3" style="display: none;">
  <label class="form-label">Nigeria or Foreign</label>
  <select class="form-control" id="physicalLocationType" name="physicalLocationType" onchange="togglePhysicalLocationFields()">
    <option value="">Select</option>
    <option value="nigeria" <?= ($physical_country === 'Nigeria') ? 'selected' : '' ?>>Nigeria</option>
    <option value="foreign" <?= (!empty($foreign_address)) ? 'selected' : '' ?>>Foreign</option>
  </select>

  <!-- Nigeria -->
  <div id="nigeriaPhysicalFields" style="display: none;">
    <label class="form-label mt-2">Nigerian Address</label>
    <input type="text" class="form-control mb-2" name="nigeria_address" value="<?= $physical_address ?>">
    <input type="text" class="form-control mb-2" name="state" placeholder="State" value="<?= $physical_state ?>">
    <input type="text" class="form-control mb-2" name="lga" placeholder="LGA" value="<?= $physical_lga ?>">
    <input type="text" class="form-control mb-2" name="country" value="Nigeria" readonly>
  </div>

  <!-- Foreign -->
  <div id="foreignPhysicalFields" style="display: none;">
    <label class="form-label mt-2">Foreign Address</label>
    <input type="text" class="form-control mb-2" name="foreign_address" value="<?= $foreign_address ?>">
  </div>
</div>

<!-- Online Format -->
<div id="onlineFields" class="mb-3" style="display:none;">
  <label class="form-label">Web Address (Zoom, YouTube, etc.)</label>
  <input type="url" class="form-control" name="web_address" value="<?= $web_address ?>">
</div>

<!-- Hybrid Format -->
<div id="hybridFields" class="mb-3" style="display:none;">
  <label class="form-label">Physical Address</label>
  <input type="text" class="form-control mb-2" name="hybrid_physical_address" value="<?= $hybrid_physical_address ?>">

  <label class="form-label">Web Address</label>
  <input type="url" class="form-control mb-2" name="hybrid_web_address" value="<?= $hybrid_web_address ?>">

  <label class="form-label">Nigeria or Foreign</label>
  <select class="form-control" id="hybridLocationType" name="hybridLocationType" onchange="toggleHybridLocationFields()">
    <option value="">Select</option>
    <option value="nigeria" <?= ($hybrid_country === 'Nigeria') ? 'selected' : '' ?>>Nigeria</option>
    <option value="foreign" <?= (!empty($hybrid_foreign_address)) ? 'selected' : '' ?>>Foreign</option>
  </select>

  <!-- Nigeria -->
  <div id="nigeriaHybridFields" style="display: none;">
    <input type="text" class="form-control mb-2" name="hybrid_state" placeholder="State" value="<?= $hybrid_state ?>">
    <input type="text" class="form-control mb-2" name="hybrid_lga" placeholder="LGA" value="<?= $hybrid_lga ?>">
    <input type="text" class="form-control mb-2" name="hybrid_country" value="Nigeria" readonly>
  </div>

  <!-- Foreign -->
  <div id="foreignHybridFields" style="display: none;">
    <input type="text" class="form-control mb-2" name="hybrid_foreign_address" placeholder="Foreign Address" value="<?= $hybrid_foreign_address; ?>">
  </div>
</div>
                        
            <div class="mb-3">
              <button type="submit" name="add_event" class="btn btn-primary">Add Event / Course</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>



                    <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        toggleQuizOption("<?= $quiz_type ?>");
                    });
                    </script>

          
                        <script>
                        document.querySelector('select[name="category"]').addEventListener('change', function() {
                          let parentId = this.value;
                          let subSelect = document.getElementById('subcategory-container');
                          let subcategorySelect = document.getElementById('subcategory-select');
                          
                          fetch(`get_subcategories.php?parent_id=${parentId}`)
                            .then(response => response.json())
                            .then(data => {
                              console.log('Received data:', data);
                              if (data.length > 0) {
                                subcategorySelect.innerHTML = '<option selected>- Select Subcategory -</option>';
                                data.forEach(cat => {
                                  console.log('Processing category:', cat);
                                  subcategorySelect.innerHTML += `<option value="${cat.s}">${cat.title}</option>`;
                                });
                                subSelect.style.display = 'block';
                              } else {
                                console.log('No subcategories found');
                                subSelect.style.display = 'none';
                              }
                            })
                            .catch(error => {
                              console.error('Error fetching subcategories:', error);
                            });
                        });
                        </script>

  <script>
  // Call on page load to preserve selected values only for this page
  document.addEventListener('DOMContentLoaded', function () {
    toggleDeliveryFields();
    togglePhysicalLocationFields();
    toggleHybridLocationFields();
  });
</script>




            <?php include "footer.php"; ?>

