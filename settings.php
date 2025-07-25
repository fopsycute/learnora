
<?php 
include "header.php";
checkActiveLog($active_log);
 ?>



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
<div class="col-md-2">
    <a href="my_orders.php">
    <div class="card text-white bg-secondary mb-3">
        <div class="card-body">
            <h5 class="card-title text-white"><a href="my_orders.php" style="text-decoration: none; color:#fff;">My Purchases</a></h5>
            <p class="card-text text-white"><?php echo $paid_orders_count; ?></p>
        </div>
    </div>
</a>
</div>
<div class="col-md-2">
    <a href="manual_orders.php">
    <div class="card text-white bg-secondary mb-3">
        <div class="card-body">
            <h5 class="card-title text-white"><a href="manual_orders.php" style="text-decoration: none; color:#fff;">Manual Purchases</a></h5>
            <p class="card-text text-white"><?php echo $pending_payments_count ; ?></p>
        </div>
    </div>
</a>
</div>
		   </div>
              </div>		
			   </div>
           </div>
           </div>

</section>

    <!-- Checkout Section -->
    <section id="checkout" class="checkout section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row">
          <div class="col-lg-8 mx-auto">


   <!-- Checkout Forms Container -->
            <div class="checkout-forms" data-aos="fade-up" data-aos-delay="150">
              <!-- Step 1: Customer Information -->
              <div class="checkout-form active" data-form="1">
                <div class="form-header">
                  <h3>PERSONAL DETAILS</h3>
                 
                </div>
            <form class="checkout-form-element" method="post" enctype="multipart/form-data">
              <input type="hidden" name="action" value="">
  <!-- PERSONAL DETAILS -->
  <div class="row">
    <div class="col-md-3 form-group">
      <label for="title">Title</label>
      <input type="text" name="title" class="form-control" id="title" placeholder="Mr, Mrs, Miss, Ms, etc." value="<?php echo $title; ?>" required>
    </div>
    <div class="col-md-3 form-group">
      <label for="first-name">First Name</label>
      <input type="text" name="first-name" class="form-control" id="first-name" placeholder="Your First Name"  value="<?php echo $first_name; ?>" required>
    </div>
    <div class="col-md-3 form-group">
      <label for="middle-name">Middle Name</label>
      <input type="text" name="middle-name" class="form-control" id="middle-name" placeholder="Your Middle Name"  value="<?php echo $middle_name; ?>">
    </div>
    <div class="col-md-3 form-group">
      <label for="last-name">Last Name</label>
      <input type="text" name="last-name" class="form-control" id="last-name" placeholder="Your Last Name" required  value="<?php echo $last_name; ?>">
    </div>
  </div>

  <div class="form-group mt-3">
    <label for="profile">Tell Us About Yourself</label>
    <textarea class="form-control" name="profile" id="profile" placeholder="Your Profile" required><?php echo $biography; ?></textarea>
  </div>

  <div class="row mt-3">
    <div class="col-md-4 form-group">
      <label for="photo">Photo</label>
      <input type="file" name="photo" class="form-control" id="photo">
    </div>
    <div class="col-md-4 form-group">
      <label for="age">Age</label>
      <input type="number" name="age" class="form-control" id="age" placeholder="Must be 18 years and above" required min="18" value="<?php echo $age; ?>">
    </div>
    <div class="col-md-4 form-group">
      <label for="gender">Gender</label>
      <select class="form-control" id="gender" name="gender" required>
                                    <option value="">-Select Gender-</option>
                                    <option value="Male" <?php echo ($gender == 'Male') ? 'selected' : ''; ?>>Male</option>
                                    <option value="Female" <?php echo ($gender == 'Female') ? 'selected' : ''; ?>>Female</option>
                                    </select> 
    </div>
  </div>

  <div class="row mt-3">
    <div class="col-md-6 form-group">
      <label for="email">Email Address</label>
      <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required value="<?php echo $email_address;?>">
    </div>
    <div class="col-md-6 form-group">
      <label for="phone">Phone Number</label>
      <input type="tel" class="form-control" name="phone" id="phone" placeholder="Your Phone Number" value="<?php echo $phone_number; ?>" required>
    </div>
  </div>
<div class="row mt-3">
					  <div class="col-md-6 form-group">
					  <label>Password:</label>
				   <div class="input-group">
					<input type="password" class="form-control" id="password" name="password" placeholder="Password">
					<div class="input-group-append">
					<span class="input-group-text p-3" onclick="togglePasswordVisibility('password')">
						<i class="bi bi-eye" id="togglePasswordIcon"></i>
														</span>
													</div>
												</div>
					</div>
                   <div class="col-md-6 form-group">
                  <label>Password:</label>
                                  <div class="input-group">
                                        <input type="password" class="form-control" id="retypePassword" name="retypePassword" placeholder="Password" >
                                        <div class="input-group-append">
                                            <span class="input-group-text p-3" onclick="togglePasswordVisibility('retypePassword')">
                                                <i class="bi bi-eye" id="toggleRetypePasswordIcon"></i>
                                            </span>
                                        </div>
                                    </div>
                                  </div>
                                </div>
  <div class="form-group mt-3">
    <label for="skills">Skills and Hobbies</label>
    <textarea class="form-control" name="skills" id="skills" placeholder="List your skills and hobbies" required><?php echo $skills_hobbies; ?></textarea>
  </div>

  <!-- LANGUAGE SECTION -->
  <div class="row mt-3">
    <div class="col-md-6 form-group">
      <label for="language">Language</label>
      <input type="text" name="language" class="form-control" id="language" placeholder="Language" value="<?php echo $language; ?>">
    </div>
    <div class="col-md-6 form-group">
      <label for="proficiency">Proficiency</label>
      <select name="proficiency" class="form-control" id="proficiency">
          <option value="">Select Option</option>
        <option value="Unspecified" <?php echo ($proficiency == 'Unspecified') ? 'selected' : ''; ?>>Unspecified</option>
        <option value="Basic" <?php echo ($proficiency == 'Basic') ? 'selected' : ''; ?>>Basic</option>
        <option value="Conversational" <?php echo ($proficiency == 'Conversational') ? 'selected' : ''; ?>>Conversational</option>
        <option value="Fluent" <?php echo ($proficiency == 'Fluent') ? 'selected' : ''; ?>>Fluent</option>
        <option value="Native/Bilingual" <?php echo ($proficiency == 'Native/Bilingual') ? 'selected' : ''; ?>>Native/Bilingual</option>
      </select>
    </div>
  </div>

  <!-- COMPANY DETAILS -->
  <hr class="mt-5 mb-4">
  <h5>Company Details</h5>

  <div class="form-group mt-3">
    <label for="company-name">Company Name</label>
    <input type="text" name="company-name" class="form-control" id="company-name" placeholder="Company Name" value="<?php echo $company_name; ?>" required>
  </div>

  <div class="form-group mt-3">
    <label for="company-profile">Company Profile</label>
    <textarea name="company-profile" class="form-control" id="company-profile" placeholder="Tell us about the company"><?php echo $company_profile; ?></textarea>
  </div>

  <div class="form-group mt-3">
    <label for="company-logo">Company Logo</label>
    <input type="file" name="company_profile_picture" class="form-control" id="company-logo">
  </div>

  <!-- Nigerian Office -->
  <div class="form-group mt-3">
    <label for="nigeria-office">Nigerian Office Address</label>
    <textarea name="nigeria-office" class="form-control" id="nigeria-office" placeholder="Full address in Nigeria"><?php echo $n_office_address; ?></textarea>
  </div>

  <div class="row mt-3">
    <div class="col-md-4 form-group">
      <label for="state">State</label>
      <input type="text" name="state" class="form-control" id="state" placeholder="State" value="<?php echo $state; ?>">
    </div>
    <div class="col-md-4 form-group">
      <label for="lga">LGA</label>
      <input type="text" name="lga" class="form-control" id="lga" placeholder="Local Government Area" value="<?php echo $lga; ?>">
    </div>
    <div class="col-md-4 form-group">
      <label for="country">Country</label>
      <input type="text" name="country" class="form-control" id="country" placeholder="Country" value="<?php echo $country; ?>">
    </div>
  </div>

  <!-- Foreign Office -->
  <div class="form-group mt-3">
    <label for="foreign-office">Foreign Office Address</label>
    <textarea name="foreign-office" class="form-control" id="foreign-office" placeholder="Full address of foreign office (if any)"><?php echo $f_office_address; ?></textarea>
  </div>

  <div class="form-group mt-3">
      <div class="row mt-3">
    <div class="col-md-6 form-group">
    <label for="specialization">Areas of Specialization & Expertise</label>
                         <select class="form-control" name="category" aria-label="Default select example" required>
    <option value="">- Select Category -</option>
    <?php
    $sql = "SELECT * FROM " . $siteprefix . "categories WHERE parent_id IS NULL ";
    $sql2 = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_array($sql2)) {
        $selected = ($category == $row['id']) ? 'selected' : '';
        echo '<option value="' . $row['id'] . '" ' . $selected . '>' . htmlspecialchars($row['category_name']) . '</option>';
    }
    ?>
</select> 
  
    </div>  
     <div class="col-md-6 form-group">
         <label for="subcategory">Subcategory</label>

 <select class="form-control" name="subcategory" id="subcategory-select" required>
                            <option selected>- Select Subcategory -</option>
                          
                        </select>

     </div>   
  </div>     
</div>
		</div> <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
    <div class="row mt-3">
       <div class="col-md-6 form-group p_star mb-3">
                                <input type="text" class="form-control" name="bank_name" placeholder="Bank Name" value="<?php echo htmlspecialchars($bank_name); ?>">
                            </div>
                            <div class="col-md-6 form-group p_star mb-3">
                                <input type="text" class="form-control" name="bank_accname" placeholder="Bank Account Name" value="<?php echo htmlspecialchars($bank_accname); ?>">
                            </div>
                            <div class="col-md-6 form-group p_star mb-3">
                                <input type="text" class="form-control" name="bank_number" placeholder="Bank Account Number" value="<?php echo htmlspecialchars($bank_number); ?>">
                            </div>
                            </div>
  <!-- Social Media -->
  <div class="row mt-3">
    <div class="col-md-3 form-group">
      <label for="facebook">Facebook</label>
      <input type="text" name="facebook" class="form-control" id="facebook" placeholder="Facebook profile" value="<?php echo $facebook; ?>">
    </div>
    <div class="col-md-3 form-group">
      <label for="twitter">Twitter</label>
      <input type="text" name="twitter" class="form-control" id="twitter" placeholder="Twitter profile" value="<?php echo $twitter; ?>">
    </div>
    <div class="col-md-3 form-group">
      <label for="instagram">Instagram</label>
      <input type="text" name="instagram" class="form-control" id="instagram" placeholder="Instagram profile" value="<?php echo $instagram; ?>">
    </div>
    <div class="col-md-3 form-group">
      <label for="linkedin">LinkedIn</label>
      <input type="text" name="linkedin" class="form-control" id="linkedin" placeholder="LinkedIn profile" value="<?php echo $linkedin; ?>">
    </div>
  </div>
  <?php 
 if($trainer == 0 || $trainer == ''){ ?>
   <div class="mb-4 form-group d-flex align-items-center">
                <input type="checkbox" value="1" id="register_as_trainer" name="register_as_trainer" <?php echo isset($_POST['register_as_trainer']) ? 'checked' : ''; ?> class="me-2">
                <label for="register_as_trainer" class="mb-0">Become a trainer</label>
            </div>
            <?php }  ?>

  <div class="text-end mt-4">
    <button type="submit" name="update-profile" class="btn btn-primary">Submit</button>
  </div>
</form>

              </div>

            </div>
          </div>
        </div>
      </div>
    </section>
<script>
var currentSubcategory = "<?php echo isset($subcategory) ? $subcategory : ''; ?>";

document.querySelector('select[name="category"]').addEventListener('change', function() {
  let parentId = this.value;
  let subSelect = document.getElementById('subcategory-container');
  let subcategorySelect = document.getElementById('subcategory-select');

  fetch('get_subcategories.php?parent_id=' + parentId)
    .then(response => response.json())
    .then(data => {
      subcategorySelect.innerHTML = '<option selected>- Select Subcategory -</option>';
      let found = false;
      data.forEach(cat => {
        let selected = (cat.s == currentSubcategory) ? 'selected' : '';
        if (selected) found = true;
        subcategorySelect.innerHTML += `<option value="${cat.s}" ${selected}>${cat.title}</option>`;
      });
      subSelect.style.display = data.length > 0 ? 'block' : 'none';
      // If editing and the category matches, set the subcategory
      if (found) subcategorySelect.value = currentSubcategory;
    })
    .catch(error => {
      console.error('Error fetching subcategories:', error);
    });
});

// On page load, if editing, trigger the change event to load subcategories
window.addEventListener('DOMContentLoaded', function() {
  if (currentSubcategory) {
    document.querySelector('select[name="category"]').dispatchEvent(new Event('change'));
  }
});
</script>


<?php include "footer.php"; ?>