    <?php include "header.php"; ?>


<div class="container-xxl flex-grow-1 container-p-y">

              <!-- Hoverable Table rows -->
              <div class="card">
                <h5 class="card-header">Manage Training</h5>
                <div class="table-responsive text-nowrap ">
                  <table class="table table-hover">
                  <thead>
                  <tr>
                      <th>S/N</th>
                  <th>Training Title</th>
                  <th>Category</th>
                  <th>Subcategory</th>
                  <th>Pricing</th>
                  <th>Price</th>
                  <th>Tags</th>
                  <th>Loyalty</th>
                  <th>Uploaded by</th>
                  <th>Created Date</th>
                  <th>Status</th>
                  <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody class="table-border-bottom-0">
                  <?php
                  $query = "SELECT t.*, u.name as display_name,lu.display_name AS nameupload, tt.price, u.photo as profile_picture, l.category_name AS category, sc.category_name AS subcategory, ti.picture 
    FROM ".$siteprefix."training t
    LEFT JOIN ".$siteprefix."categories l ON t.category = l.id 
    LEFT JOIN ".$siteprefix."instructors u ON t.instructors = u.s
    LEFT JOIN ".$siteprefix."users lu ON t.user = lu.s
    LEFT JOIN ".$siteprefix."categories sc ON t.subcategory = sc.id 
    LEFT JOIN ".$siteprefix."training_tickets tt ON t.training_id= tt.training_id
    LEFT JOIN ".$siteprefix."training_images ti ON t.training_id = ti.training_id 
   Where t.status='approved'";
      $result = mysqli_query($con, $query);
                if (!$result) {
                    die('Query Failed: ' . mysqli_error($con));
                }
                $result = mysqli_query($con, $query);
                $i = 1;
                while($row = mysqli_fetch_assoc($result)) {
                     $training_id = $row['training_id'];
        $title = $row['title'];
        $alt_title = $row['alt_title'];
        $description = $row['description'];
        $category = $row['category'];
        $subcategory = $row['subcategory'];
        $pricing = $row['pricing'];
        $price = $row['price'];
        $tags = $row['tags'];
        $uploaded_by = $row['nameupload'];
        $user = $row['display_name'];
        $user_picture = $imagePath.$row['profile_picture'];
        $created_date = $row['created_at'];
        $status = $row['status'];
        $image_path = $imagePath.$row['picture'];
        $slug = $alt_title;
        $event_type = $row['event_type'] ?? '';
         $loyalty = $row['loyalty'];
                ?>
                  <tr>
                  <td><strong><?php echo $i; ?></strong></td>
                  <td><?php echo $title; ?></td>
                  <td><?php echo $category; ?></td>
                  <td><?php echo $subcategory; ?></td>
                  <td><?php echo $pricing; ?></td>
                  <td><?php echo $price; ?></td>
                  <td><?php echo $tags; ?></td>
                  <td><?php echo $loyalty; ?></td>
                  <td><?php echo $uploaded_by; ?></td>
                  <td><?php echo $created_date; ?></td>
                 
                  <td><span class="badge bg-label-<?php echo getBadgeColor($status); ?> me-1"><?php echo $status; ?></span></td>
                  <td>
                    <div class="dropdown">
                    <button type="button" class="btn btn-primary text-small dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                    <i class="bx bx-dots-vertical-rounded"></i>Manage
                    </button>
                    <div class="dropdown-menu">
                    <a class="dropdown-item" href="edit-training.php?training=<?php echo $training_id; ?>"><i class="bx bx-edit-alt me-1"></i> Edit Training</a>
                    <a class="dropdown-item delete" href="delete.php?action=delete&table=training&item=<?php echo $training_id; ?>&page=<?php echo $current_page; ?>"><i class="bx bx-trash me-1"></i> Delete</a>
                    </div>
                    </div>
                  </td>
                  </tr>
                  <?php $i++; } ?>
                  </tbody>
                  </table>
                </div>
                </div>
              </div>
              <!--/ Hoverable Table rows -->

            

            </div>




<?php include "footer.php"; ?>
