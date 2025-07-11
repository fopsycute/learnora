
<?php include "header.php"; ?>


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
              <input type="hidden" name="action" value="register">
  <!-- PERSONAL DETAILS -->
  <div class="row">
    <div class="col-md-3 form-group">
      <label for="title">Title</label>
      <input type="text" name="title" class="form-control" id="title" placeholder="Mr, Mrs, Miss, Ms, etc." required>
    </div>
    <div class="col-md-3 form-group">
      <label for="first-name">First Name</label>
      <input type="text" name="first-name" class="form-control" id="first-name" placeholder="Your First Name" required>
    </div>
    <div class="col-md-3 form-group">
      <label for="middle-name">Middle Name</label>
      <input type="text" name="middle-name" class="form-control" id="middle-name" placeholder="Your Middle Name">
    </div>
    <div class="col-md-3 form-group">
      <label for="last-name">Last Name</label>
      <input type="text" name="last-name" class="form-control" id="last-name" placeholder="Your Last Name" required>
    </div>
  </div>

  <div class="form-group mt-3">
    <label for="profile">Tell Us About Yourself</label>
    <textarea class="form-control" name="profile" id="profile" placeholder="Your Profile" required></textarea>
  </div>

  <div class="row mt-3">
    <div class="col-md-4 form-group">
      <label for="photo">Photo</label>
      <input type="file" name="photo" class="form-control" id="photo" required>
    </div>
    <div class="col-md-4 form-group">
      <label for="age">Age</label>
      <input type="number" name="age" class="form-control" id="age" placeholder="Must be 18 years and above" required min="18">
    </div>
    <div class="col-md-4 form-group">
      <label for="gender">Gender</label>
      <select class="form-control" id="gender" name="gender" required>
        <option value="">-Select Gender-</option>
        <option value="Female">Female</option>
        <option value="Male">Male</option>
      </select>
    </div>
  </div>

  <div class="row mt-3">
    <div class="col-md-6 form-group">
      <label for="email">Email Address</label>
      <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
    </div>
    <div class="col-md-6 form-group">
      <label for="phone">Phone Number</label>
      <input type="tel" class="form-control" name="phone" id="phone" placeholder="Your Phone Number" required>
    </div>
  </div>
<div class="row mt-3">
					  <div class="col-md-6 form-group">
					  <label>Password:</label>
				   <div class="input-group">
					<input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
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
                                        <input type="password" class="form-control" id="retypePassword" name="retypePassword" placeholder="Password" required>
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
    <textarea class="form-control" name="skills" id="skills" placeholder="List your skills and hobbies" required></textarea>
  </div>

  <!-- LANGUAGE SECTION -->
  <div class="row mt-3">
    <div class="col-md-6 form-group">
      <label for="language">Language</label>
      <input type="text" name="language" class="form-control" id="language" placeholder="Language">
    </div>
    <div class="col-md-6 form-group">
      <label for="proficiency">Proficiency</label>
      <select name="proficiency" class="form-control" id="proficiency">
          <option value="">Select Option</option>
        <option value="Unspecified">Unspecified</option>
        <option value="Basic">Basic</option>
        <option value="Conversational">Conversational</option>
        <option value="Fluent">Fluent</option>
        <option value="Native/Bilingual">Native/Bilingual</option>
      </select>
    </div>
  </div>

  <!-- COMPANY DETAILS -->
  <hr class="mt-5 mb-4">
  <h5>Company Details</h5>

  <div class="form-group mt-3">
    <label for="company-name">Company Name</label>
    <input type="text" name="company-name" class="form-control" id="company-name" placeholder="Company Name">
  </div>

  <div class="form-group mt-3">
    <label for="company-profile">Company Profile</label>
    <textarea name="company-profile" class="form-control" id="company-profile" placeholder="Tell us about the company"></textarea>
  </div>

  <div class="form-group mt-3">
    <label for="company-logo">Company Logo</label>
    <input type="file" name="company_profile_picture" class="form-control" id="company-logo">
  </div>

  <!-- Nigerian Office -->
  <div class="form-group mt-3">
    <label for="nigeria-office">Nigerian Office Address</label>
    <textarea name="nigeria-office" class="form-control" id="nigeria-office" placeholder="Full address in Nigeria"></textarea>
  </div>

  <div class="row mt-3">
    <div class="col-md-4 form-group">
      <label for="state">State</label>
      <input type="text" name="state" class="form-control" id="state" placeholder="State">
    </div>
    <div class="col-md-4 form-group">
      <label for="lga">LGA</label>
      <input type="text" name="lga" class="form-control" id="lga" placeholder="Local Government Area">
    </div>
    <div class="col-md-4 form-group">
      <label for="country">Country</label>
      <input type="text" name="country" class="form-control" id="country" placeholder="Country">
    </div>
  </div>

  <!-- Foreign Office -->
  <div class="form-group mt-3">
    <label for="foreign-office">Foreign Office Address</label>
    <textarea name="foreign-office" class="form-control" id="foreign-office" placeholder="Full address of foreign office (if any)"></textarea>
  </div>

  <div class="form-group mt-3">
      <div class="row mt-3">
    <div class="col-md-6 form-group">
    <label for="specialization">Areas of Specialization & Expertise</label>
                        <select class="form-control" name="category" aria-label="Default select example" required>
                          <option selected>- Select Category -</option>
                          <?php
                    $sql = "SELECT * FROM " . $siteprefix . "categories WHERE parent_id IS NULL ";
                     $sql2 = mysqli_query($con, $sql);
                     while ($row = mysqli_fetch_array($sql2)) {
                     echo '<option value="' . $row['id'] . '">' . $row['category_name'] . '</option>'; }?>
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

  <!-- Social Media -->
  <div class="row mt-3">
    <div class="col-md-3 form-group">
      <label for="facebook">Facebook</label>
      <input type="text" name="facebook" class="form-control" id="facebook" placeholder="Facebook profile URL">
    </div>
    <div class="col-md-3 form-group">
      <label for="twitter">Twitter</label>
      <input type="text" name="twitter" class="form-control" id="twitter" placeholder="Twitter profile URL">
    </div>
    <div class="col-md-3 form-group">
      <label for="instagram">Instagram</label>
      <input type="text" name="instagram" class="form-control" id="instagram" placeholder="Instagram profile URL">
    </div>
    <div class="col-md-3 form-group">
      <label for="linkedin">LinkedIn</label>
      <input type="text" name="linkedin" class="form-control" id="linkedin" placeholder="LinkedIn profile URL">
    </div>
  </div>

  <div class="text-end mt-4">
    <button type="submit" name="register-user" class="btn btn-primary">Submit</button>
  </div>
</form>

              </div>

            </div>
          </div>
        </div>
      </div>
    </section>

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