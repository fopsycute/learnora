
<?php include "header.php"; ?>
<style>
.modal {
  position: fixed;
  top: 0; left: 0;
  width: 100%; height: 100%;
  background: rgba(0,0,0,0.5);
  z-index: 999;
}

.modal-content {
  background: #fff;
  margin: 10% auto;
  padding: 20px;
  width: 90%;
  max-width: 600px;
  border-radius: 10px;
  position: relative;
}

.close {
  position: absolute;
  right: 20px;
  top: 10px;
  font-size: 24px;
  cursor: pointer;
}
</style>
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
              <input type="text" class="form-control" name="title" required>
            </div>
              <div class="mb-3">
                          <label class="form-label" for="course-id">Training ID</label>
                            <input type="text" id="course-id" name="id" class="form-control" value="TH<?php echo sprintf('%06d', rand(1, 999999)); ?>" readonly required>
                        </div>
            <div class="mb-3">
              <label class="form-label">Cover Image</label>
              <input type="file" class="form-control" name="cover_images" accept="image/*"  required>
            </div>
            <div class="mb-3">
              <label class="form-label">Description</label>
              <textarea class="form-control" name="description" required></textarea>
            </div>
            <div class="mb-3">
              <label class="form-label">Who Should Attend</label>
              <input type="text" class="form-control" name="who_should_attend" placeholder="E.g. Beginners, Entrepreneurs, etc.">
            </div>
            <div class="mb-3">
              <label class="form-label">Event Dates & Times</label>
              <div id="dateTimeRepeater">
                <div class="row mb-2 dateTimeRow">
                  <div class="col">
                    <input type="date" class="form-control" name="event_dates[]" required>
                  </div>
                  <div class="col">
                    <input type="time" class="form-control" name="event_start_times[]" required>
                  </div>
                  <div class="col">
                    <input type="time" class="form-control" name="event_end_times[]" required>
                  </div>
                  <div class="col-auto">
                    <button type="button" class="btn btn-success btn-sm" onclick="addDateTimeRow()"><i class="bx bx-plus me-1"></i></button>
                  </div>
                </div>
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Language</label>
              <input type="text" class="form-control" name="language" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Certification Offered?</label>
              <select class="form-control" name="certification">
                <option value="yes">Yes</option>
                <option value="no">No</option>
              </select>
            </div>
                 <input type="hidden" name="user" value="<?php echo $user_id; ?>">
            <div class="mb-3">
              <label class="form-label">Level</label>
              <select class="form-control" name="level" required>
                <option value="">Select Level</option>
                <option value="beginner">Beginner</option>
                <option value="intermediate">Intermediate</option>
                <option value="advanced">Advanced</option>
              </select>
            </div>

            <h6>Delivery Format</h6>
            <div class="mb-3">
              <select class="form-control" name="delivery_format" id="deliveryFormat" onchange="toggleDeliveryFields()" required>
                <option value="">Select Format</option>
                <option value="physical">Physical (In-person)</option>
                <option value="online">Online (Webinar/Virtual)</option>
                <option value="hybrid">Hybrid (Physical & Online)</option>
                <option value="video">Video</option>
                <option value="text">Text</option>
              </select>
            </div> 
            <!-- Physical Address Fields -->
            <div class="mb-3" id="physicalFields" style="display:none;">
              <label class="form-label">Nigeria or Foreign</label>
              <select class="form-control" id="physicalLocationType" name="physicalLocationType" onchange="togglePhysicalLocationFields()">
                <option value="">Select</option>
                <option value="nigeria">Nigeria</option>
                <option value="foreign">Foreign</option>
              </select>
              <div id="nigeriaPhysicalFields" style="display:none;">
                <label class="form-label mt-2">Nigerian Address</label>
                <input type="text" class="form-control mb-2" name="nigeria_address">
                <input type="text" class="form-control mb-2" name="state" placeholder="State">
                <input type="text" class="form-control mb-2" name="lga" placeholder="LGA">
                <input type="text" class="form-control mb-2" name="country" value="Nigeria" readonly>
              </div>
              <div id="foreignPhysicalFields" style="display:none;">
                <label class="form-label mt-2">Foreign Address</label>
                <input type="text" class="form-control mb-2" name="foreign_address">
              </div>
            </div>
            <!-- Online Address Field -->
            <div class="mb-3" id="onlineFields" style="display:none;">
              <label class="form-label">Web Address (Zoom, YouTube, etc.)</label>
              <input type="url" class="form-control" name="web_address">
            </div>
            <!-- Hybrid Address Fields -->
            <div class="mb-3" id="hybridFields" style="display:none;">
              <label class="form-label">Physical Address</label>
              <input type="text" class="form-control mb-2" name="hybrid_physical_address">
              <label class="form-label">Web Address</label>
              <input type="url" class="form-control mb-2" name="hybrid_web_address">
              <label class="form-label">Nigeria or Foreign</label>
              <select class="form-control" id="hybridLocationType" name="hybridLocationType" onchange="toggleHybridLocationFields()">
                <option value="">Select</option>
                <option value="nigeria">Nigeria</option>
                <option value="foreign">Foreign</option>
              </select>
              <div id="nigeriaHybridFields" style="display:none;">
                <input type="text" class="form-control mb-2" name="hybrid_state" placeholder="State">
                <input type="text" class="form-control mb-2" name="hybrid_lga" placeholder="LGA">
                <input type="text" class="form-control mb-2" name="hybrid_country" value="Nigeria" readonly>
              </div>
              <div id="foreignHybridFields" style="display:none;">
                <input type="text" class="form-control mb-2" name="hybrid_foreign_address" placeholder="Foreign Address">
              </div>
            </div>

            <h6>Course Content Details</h6>
            <div class="mb-3">
              <label class="form-label">Course Description</label>
              <textarea class="form-control" name="course_description" rows="4"></textarea>
            </div>
            <div class="mb-3">
              <label class="form-label">Learning Objectives / Outcomes</label>
              <textarea class="form-control" name="learning_objectives" rows="3" placeholder="List what the learner will be able to do after completing the course."></textarea>
            </div>
            <div class="mb-3">
              <label class="form-label">Target Audience</label>
              <input type="text" class="form-control" name="target_audience" placeholder='E.g. "Beginners in Python", "Entrepreneurs", etc.'>
            </div>
            <div class="mb-3">
              <label class="form-label">Course Requirements / Prerequisites</label>
              <textarea class="form-control" name="prerequisites" rows="2" placeholder="Any knowledge, tools, or skills needed before starting."></textarea>
            </div>

            <h6>Course Content Uploads</h6>
            <div class="mb-3">
              <label class="form-label">Video Lessons (Upload or Embed URL)</label>
              <input type="file" class="form-control mb-2" name="video_lessons[]" multiple accept="video/*">
              <input type="url" class="form-control" name="video_embed_url" placeholder="Or paste video URL">
            </div>
            <div class="mb-3">
              <label class="form-label">Text Modules / PDFs / Readings (Upload)</label>
              <input type="file" class="form-control" name="text_modules[]" multiple accept=".pdf,.txt,.doc,.docx">
            </div>
            <div class="mb-3">
              <div>
              <label class="form-label">Quizzes & Assignments</label>
          </div>
         <label>Choose how to provide quiz/assignment content:</label>
          <select onchange="toggleQuizOption(this.value)" name="quiz_method" class="form-control mb-3">
            <option value="">-- Select Option --</option>
            <option value="text">Text Entry</option>
            <option value="upload">Upload Files</option>
            <option value="form">Use Form Builder</option>
          </select>

        <!-- Option 1: Text Entry -->
        <div id="quizText" style="display:none;">
          <label>Text Entry:</label>
          <textarea name="quiz_text[]" placeholder="e.g., Write a short essay on the impact of AI on job markets..." class="form-control"></textarea>
        </div>

        <!-- Option 2: File Upload -->
      <div id="quizUpload" style="display:none;">
        <label>Upload Quiz or Assignment Files:</label>
        <input type="file" name="quiz_files[]" multiple  class="form-control">
        <small>You can upload multiple files (PDF, Word, Text).</small>
      </div>
<div id="quizFormButton" style="display:none;">
  <label>Use the Form Builder to Add Structured Questions:</label><br>
  <button type="button" onclick="openQuizModal()" class="btn btn-success"><i class="bx bx-plus me-1"></i>Add Quiz/Assignment Questions</button>
</div>

      <div id="quizModal" class="modal" style="display:none;">
  <div class="modal-content">
    <span class="close" onclick="closeQuizModal()">&times;</span>
    <h3>🧠 Add Quiz Questions</h3>
    
    <div id="quizBuilderModal">
      <div class="mb-3">
        <label>Instructions:</label>
        <textarea name="quiz_instructions" placeholder="Quiz Instructions" class="form-control mb-2"></textarea>
      </div>
      <div class="question-block">
        <div class="mb-3">
          <label>Question:</label>
        <input type="text" name="questions[]" placeholder="Question" class="form-control mb-2">
        </div>
        <div class="mb-3">
        <input type="text" name="option_a[]" placeholder="Option A">
        <input type="text" name="option_b[]" placeholder="Option B">
        <input type="text" name="option_c[]" placeholder="Option C">
        <input type="text" name="option_d[]" placeholder="Option D">
          </div>
        <div class="mb-3">
        <label>Correct Answer:</label>
        <select name="correct_answer[]" class="form-select mb-3">
          <option value="a">A</option>
          <option value="b">B</option>
          <option value="c">C</option>
          <option value="d">D</option>
        </select>
         </div>
        <hr>
      </div>
    </div>

    <button type="button" onclick="addQuizQuestionModal()" class="btn btn-secondary"><i class="bx bx-plus me-1"></i>Add Another Question</button>
    <br><br>
    <button type="button" onclick="closeQuizModal()" class="btn btn-primary">✅ Done</button>
  </div>
</div>


            </div>
            <div class="mb-3">
              <label class="form-label">Course Trailer/Intro Video (Optional)</label>
              <input type="file" class="form-control" name="trailer_video" accept="video/*">
            </div>

          <?php
          // Fetch event types from the database
          $eventTypes = [];
          $eventTypeQuery = mysqli_query($con, "SELECT s, name FROM {$siteprefix}event_types");
          while ($row = mysqli_fetch_assoc($eventTypeQuery)) {
              $eventTypes[] = $row;
          }
          ?>
          <!-- ...existing code... -->

          <div class="mb-3">
            <label class="form-label">Type of Training & Events</label>
            <select class="form-control" name="event_type" required>
              <option value="">Select Type</option>
              <?php foreach ($eventTypes as $type): ?>
                <option value="<?php echo htmlspecialchars($type['s']); ?>">
                  <?php echo htmlspecialchars($type['name']); ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="mb-3">
  <label class="form-label">Pricing</label>
  <select class="form-control" name="pricing" id="pricingSelect" onchange="togglePricingFields()" required>
    <option value="">Select Pricing</option>
    <option value="donation">Donation</option>
    <option value="free">Free</option>
    <option value="paid">Paid</option>
  </select>
</div>

<!-- Donation Info -->
<div class="mb-3" id="donationFields" style="display:none;">
  <p>This event allows attendees to pay any amount they choose as a donation.</p>
</div>

<!-- Free Info -->
<div class="mb-3" id="freeFields" style="display:none;">
  <p>This event is free for all attendees.</p>
</div>


<!-- Paid Ticket Fields -->
<div class="mb-3" id="paidFields" style="display:none;">
  <label class="form-label">Ticket Name</label>
  <input type="text" class="form-control mb-2" name="ticket_name" placeholder="e.g. General Admission">
  <label class="form-label">Benefits</label>
  <input type="text" class="form-control mb-2" name="ticket_benefits" placeholder="e.g. Certificate, Lunch, Materials">
  <label class="form-label">Price</label>
  <input type="number" class="form-control mb-2" name="ticket_price" min="0" step="0.01" placeholder="e.g. 5000">
  <label class="form-label">Number of Seats Available</label>
  <input type="number" class="form-control" name="ticket_seats" min="1" placeholder="e.g. 100">
</div>

                         <div class="mb-3">
                        <select class="form-select" name="category" aria-label="Default select example" required>
                          <option selected>- Select Category -</option>
                          <?php
                    $sql = "SELECT * FROM " . $siteprefix . "categories WHERE parent_id IS NULL ";
                     $sql2 = mysqli_query($con, $sql);
                     while ($row = mysqli_fetch_array($sql2)) {
                     echo '<option value="' . $row['id'] . '">' . $row['category_name'] . '</option>'; }?>
                        </select>
                        </div>

                        <div class="mb-3" id="subcategory-container" style="display:none;">
                          <select class="form-select" name="subcategory" id="subcategory-select" required>
                            <option selected>- Select Subcategory -</option>
                          </select>
                        </div>

                            <?php
    // Fetch instructors from the database
    $instructors = [];
    $instructorQuery = mysqli_query($con, "SELECT s, name, photo FROM {$siteprefix}instructors");
    while ($row = mysqli_fetch_assoc($instructorQuery)) {
        $instructors[] = $row;
    }
    ?>
    <!-- ...existing code... -->

    <h6>Instructor Information</h6>
    <div class="mb-3">
      <label class="form-label">Select Instructor</label>
      <select class="form-control" name="instructor" id="instructorSelect" onchange="displayInstructorInfo()" required>
        <option value="">-- Select Instructor --</option>
        <?php foreach ($instructors as $inst): ?>
          <option value="<?php echo htmlspecialchars($inst['s']); ?>"
            data-name="<?php echo htmlspecialchars($inst['name']); ?>"
            data-photo="<?php echo $adminimagePath.$inst['photo']; ?>">
            <?php echo htmlspecialchars($inst['name']); ?>
          </option>
        <?php endforeach; ?>
        <option value="add_new">+ Add New Instructor</option>
      </select>
    </div>


    <!-- Display selected instructor info -->
<div class="mb-3" id="instructorInfo" style="display:none;">
  <img id="instructorPhoto" src="" alt="Instructor Photo" style="width:50px;height:50px;border-radius:50%;object-fit:cover;">
  <span id="instructorName" style="margin-left:10px;font-weight:bold;"></span>
</div>

<!-- Add New Instructor Fields (hidden by default) -->
<div class="mb-3" id="addInstructorFields" style="display:none;">
  <label class="form-label">Instructor Name</label>
  <input type="text" class="form-control mb-2" name="new_instructor_name" placeholder="Enter instructor name">
   <label class="form-label">Instructor Email</label>
  <input type="email" class="form-control mb-2" name="new_instructor_email" placeholder="Enter instructor email">
  <label class="form-label">Instructor Bio</label>
  <textarea class="form-control mb-2" name="new_instructor_bio" placeholder="Enter instructor bio"></textarea>
  <label class="form-label">Instructor Photo</label>
  <input type="file" class="form-control" name="new_instructor_photo" accept="image/*">
</div>

<div class="mb-3">
  <label class="form-label">Promo Video (Optional)</label>
  <input type="file" class="form-control" name="promo_video" accept="video/*">
</div>

<div class="mb-3">
  <label class="form-label">Additional Instructions or Notes</label>
  <textarea class="form-control" name="additional_notes" rows="3"></textarea>
</div>


<div class="mb-3">
  <label class="form-label">Tags</label>
  <input type="text" class="form-control" name="tags" placeholder="E.g. finance, business, marketing">
</div>


 <?php if($user_type === 'admin'): ?>
                        <div class="mb-3">
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="loyalty" name="loyalty">
                            <label class="form-check-label" for="loyalty">List under our Loyalty Program</label>
                          </div>
                        </div>
                        <?php endif; ?>
                      
            <div class="mb-3">
                          <label class="form-label" for="status-type">Approval Status</label>
                          <select id="status-type" name="status" class="form-control" required <?= getReadonlyAttribute() ?>>
                            <option value="pending" selected>Pending</option>
                            <option value="approved">Approved</option>
                          </select>
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
