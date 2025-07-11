<?php include "header.php"; 

$user_id = $_GET['user'] ?? null;
if (!$user_id) {
  header("Location: users.php");
  exit();
}

$sql = "SELECT * FROM " . $siteprefix . "users WHERE s = '" .$user_id. "'";
$sql2 = mysqli_query($con, $sql);
if ($sql2 && mysqli_num_rows($sql2) > 0) {
    while ($row = mysqli_fetch_array($sql2)) {
          $userid = $row['s'];
    $title                = $row['title'];
    $display_name         = $row['display_name'];
    $first_name           = $row['first_name'];
    $middle_name          = $row['middle_name'];
    $last_name            = $row['last_name'];
    $company_name         = $row['company_name'];
    $company_profile      = $row['company_profile'];
    $company_logo         = $row['company_logo'];
    $biography            = $row['biography'];
    $loyalty_id           = $row['loyalty'];
    $profile_photo        = $row['profile_photo'];
    $age                  = $row['age'];
    $gender               = $row['gender'];
    $email_address        = $row['email_address'];
    $phone_number         = $row['phone_number'];
    $skills_hobbies       = $row['skills_hobbies'];
    $language             = $row['language'];
    $proficiency          = $row['proficiency'];
    $n_office_address     = $row['n_office_address'];
    $f_office_address     = $row['f_office_address'];
    $category             = $row['category'];
    $subcategory          = $row['subcategory'];
    $facebook             = $row['facebook'];
    $last_login           = $row['last_login'];
    $created_date         = $row['created_date'];
    $instagram            = $row['instagram'];
    $twitter              = $row['twitter'];
    $linkedin             = $row['linkedin'];
    $state                = $row['state'];
    $lga                  = $row['lga'];
    $country              = $row['country'];
    $status              = $row['status'];
    $type            = $row['type'];
    $trainer              = $row['trainer'];
    $reset_token          = $row['reset_token'];
    $reset_token_expiry   = $row['reset_token_expiry'];
    }
} else {
    // Redirect to users page if no matching record is found
    header("Location: users.php");
    exit;
}


?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <p class="text-bold text-dark">Edit User Account</p>
               
                       <div class="row">
    <div class="col-md-3 form-group">
      <label for="title">Title</label>
      <input type="text" name="title" class="form-control" id="title" placeholder="Mr, Mrs, Miss, Ms, etc." value="<?php echo $title; ?>">
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
    <textarea class="form-control" name="profile" id="profile" placeholder="Your Profile"><?php echo $biography; ?></textarea>
  </div>

  <div class="row mt-3">
    <div class="col-md-4 form-group">
      <label for="photo">Photo</label>
      <input type="file" name="photo" class="form-control" id="photo">
    </div>
    <div class="col-md-4 form-group">
      <label for="age">Age</label>
      <input type="number" name="age" class="form-control" id="age" placeholder="Must be 18 years and above"  value="<?php echo $age; ?>">
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

  <div class="form-group mt-3">
    <label for="skills">Skills and Hobbies</label>
    <textarea class="form-control" name="skills" id="skills" placeholder="List your skills and hobbies"><?php echo $skills_hobbies; ?></textarea>
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
    <input type="text" name="company-name" class="form-control" id="company-name" placeholder="Company Name" value="<?php echo $company_name; ?>" >
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


      <div class="row mt-3">
    <div class="col-md-6 form-group">
    <label for="specialization">Areas of Specialization & Expertise</label>
                         <select class="form-control" name="category" aria-label="Default select example">
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

 <select class="form-control" name="subcategory" id="subcategory-select">
                            <option selected>- Select Subcategory -</option>
                          
                        </select>

     </div>   
  </div>     

		 <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
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
 
        <div class="row mt-3">
   
                            <div class="form-group col-md-6 mb-3">
                        <label for="type">User Type</label>
                        <select class="form-select p-3" name="type" id="type" required <?= getReadonlyAttribute() ?>>
                            <option value="user" <?php if ($type === 'user') echo 'selected'; ?>>User</option>
                            <option value="affiliate" <?php if ($type === 'affiliate') echo 'selected'; ?>>Affliate</option>
                            <option value="sub-admin" <?php if ($type === 'sub-admin') echo 'selected'; ?>>Sub Admin</option>
                        </select>
                    </div>
                <div class="form-group col-md-6 mb-3">
                    <label for="status">Status</label>
                    <select class="form-select p-3" name="status" id="status" <?php if ($status !== 'suspended') echo 'required'; ?>>
                        <option value="active" <?php if ($status === 'active') echo 'selected'; ?>>Active</option>
                        <option value="inactive" <?php if ($status === 'inactive') echo 'selected'; ?>>Inactive</option>
                       <option value="" <?php if ($status === 'suspended') echo 'selected'; ?> disabled>User is currently suspended</option>
                       <?php ; ?>
                    </select>
                </div> 
                  </div>
               
              
                <p><button class="w-100 btn btn-primary" name="update_profile_admin" value="update-user">Update Account</button></p>
                <input type="hidden" name="userid" value="<?php echo htmlspecialchars($userid, ENT_QUOTES, 'UTF-8'); ?>">
            </form>
        </div>
    </div>
</div>

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
