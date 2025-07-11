
<?php include "header.php"; ?>


    <!-- Checkout Section -->
    <section id="register" class="register section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row">
          <div class="col-lg-8 mx-auto">


   <!-- Checkout Forms Container -->
            <div class="registration-form-wrapper aos-init aos-animate" data-aos="fade-up" data-aos-delay="150">
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
      <input type="number" name="age" class="form-control" id="age" placeholder="" required >
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
    <button type="submit" name="register-newuser" class="btn btn-primary">Submit</button>
  </div>
</form>
								  </div>
                                    </div>
                                  </div>
                                </div>
								</div>
</section>
                                <?php include "footer.php"; ?>