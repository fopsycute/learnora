


<?php include "header.php"; ?>
  <main class="main">
    <!-- Checkout Section -->
    <section id="checkout" class="checkout section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row">
          <div class="col-lg-9 mx-auto">
            <div class="checkout-container" data-aos="fade-up">
              <form method="post" enctype="multipart/form-data" novalidate="novalidate">
                <!-- Customer Information -->
                <div class="checkout-section">
                  <div class="section-header">
                   <!--- <div class="section-number">1</div>
                    <h3>Customer Information</h3>  --->
                  </div>
                       
                  <div class="section-content">
				     <!-- Name Fields -->
                    <div class="row">
                      <div class="col-md-4 form-group">
                      <input type="text" class="form-control" name="first_name" placeholder="First Name" required>
                      </div>
                      <div class="col-md-4 form-group">
                      <input type="text" class="form-control" name="middle_name" placeholder="Middle Name">
                      </div>
                    <div class="col-md-4 form-group">
                      <input type="text" class="form-control" name="last_name" placeholder="Last Name">
                      </div> 
					  </div>
                   
                <div class="row mb-3">
                  <div class="col-md-4 form-group">
                  
                   <select class="form-control" id="gender" name="gender" required>
                                    <option value="">-Select Gender-</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    </select>
                  </div>
                  <div class="col-md-4 form-group">
                    
                    <input type="email" class="form-control" name="email" placeholder="Email Address" required>
                  </div>
                  <div class="col-md-4 form-group">
                    <input type="text" class="form-control" name="phone" placeholder="Phone Number" required>
                  </div>
				  </div>
                 <div class="row mb-3">

                   <div class="col-md-6 form-group">
      <select class="form-control" name="country" id="country">
              <option value="">-- Select Country --</option>
              <?php
              $result = mysqli_query($con, "SELECT id, name FROM ln_country ORDER BY name ASC");
              if ($result && mysqli_num_rows($result) > 0) {
                  while ($row = mysqli_fetch_assoc($result)) {
                      echo '<option value="' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['name']) . '</option>';
                  }
              }
              ?>
          </select>          
		  </div>
                 
		  <div class="col-md-6 form-group">
		   <input type="text" class="form-control" name="address" placeholder="Address" required>
		   </div>
		  </div>
		  
		  
						  <div class="row mb-3">
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
								   <div class="row mb-3">
                 <div class="col-md-12 form-group">
                   
								      <select class="form-control" name="referral_source" required>
                                    <option value="">Select</option>
                                    <option value="Referral">Referral</option>
                                    <option value="Instagram">Instagram</option>
                                    <option value="Twitter">Twitter</option>
                                    <option value="Facebook">Facebook</option>
                                </select>
                           
                            
                                </div>
								 </div>
				  <div class="row mb-3">
                 <div class="col-md-12 form-group">
                   
								 <input type="checkbox" value="1" id="agree_terms" name="agree_terms" required>
                                <span for="agree_terms">I agree to the terms and conditions</span>
                                    </div>
						 <div class="col-md-12 form-group">			
					<button type="submit" value="submit" name="register-affiliate" class="btn btn-primary w-100">
                    <span class="btn-text">Submit</span>
                  </button>
							 </div>	 
								 </div>
           
				</div>
</form>
           		</div>
			    </div>
				</div>
			    </div>

    </section><!-- /Checkout Section -->

  </main>


<?php include 'footer.php'; ?>