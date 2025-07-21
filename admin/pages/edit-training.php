
<?php
include "header.php";

if (isset($_GET['training'])) {
    $training_id = $_GET['training'];
}
$event_rows = [];
    // Fetch training details from the database
    $query = "SELECT t.*, u.name AS display_name, tv.video_path, et.name AS event_types, tt.price, tt.ticket_name,tt.benefits,tt.seats,
                       u.photo AS profile_picture, l.category_name AS category, 
                       sc.category_name AS subcategory, ti.picture AS event_image,ti.s AS image_id,
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
              WHERE t.training_id = '$training_id'";
$result = mysqli_query($con, $query);
if (!$result) {
    die('Query Failed: ' . mysqli_error($con));
}
$row = mysqli_fetch_assoc($result);
if ($row) {
     // Set training info from first row
              
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
                $instructor_picture =  $imagePath .$row['profile_picture'];
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
                $format = ucfirst($row['delivery_format']);

 // Append each event date
            if (!empty($row['event_date']) && !empty($row['start_time']) && !empty($row['end_time'])) {
                $event_dates[] = [
                    'event_date' => $row['event_date'],
                    'start_time' => $row['start_time'],
                    'end_time' => $row['end_time']
                ];
            }

 $slug =$alt_title;
$selected_resource_type = explode(',', $row['use_case'] ?? ''); // assuming stored as comma-separated
} else {
    echo 'Event not found.';
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
  <?php foreach ($event_rows as $ev) { ?>
    <div class="row mb-2 dateTimeRow">
      <input type="hidden" name="event_ids[]" value="<?= $ev['id'] ?>">
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
</div>
<button type="button" class="btn btn-success btn-sm mt-2" onclick="addDateTimeRow()">
  <i class="bx bx-plus me-1"></i> Add
</button>

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


            <?php include "footer.php"; ?>

