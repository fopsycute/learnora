
 <?php include "header.php";  ?>




<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-body">
   <form  method="POST" id="addForum" enctype="multipart/form-data">
   
   <div class="row">
       
    <div class="col-sm-12">  
    <div class="form-group mb-3">
    <label class="form-label" for="first_name">Attach Featured Image</label>
    <input class="form-control" type="file"  name="featured_image" required >
    </div></div>
    
    
   <div class="col-sm-12">
   <div class="form-group mb-3">
   <label class="form-label" for="first_name">Enter Forum Title</label>
   <input placeholder="Enter First Name" id="first_name" type="text" class="form-control" name="title" required>
   </div></div>
          
            <div class="col-md-12 form-group">
                    <div class="mb-3">
				  <label>Area of Specialization:</label>
				   <select  class="form-select mb-4 select-multiple" name="category[]" multiple aria-label="Default select example" required>
                          <option>- Select Category -</option>
                          <?php
                     $sql = "SELECT * FROM " . $siteprefix . "categories WHERE parent_id IS NULL ";
                     $sql2 = mysqli_query($con, $sql);
                     while ($row = mysqli_fetch_array($sql2)) {
                     echo '<option value="' . $row['id'] . '">' . $row['category_name'] . '</option>'; }?>
                        </select>
                        </div>
                         </div>

   <div class="col-sm-12">
   <div class="form-group">
    <label class="form-label" for="editor">Enter Forum Details</label><textarea class="form-control" id="editor" name="article"></textarea>
   </div></div>

  <input type="hidden" name="user" value="<?php echo $user_id; ?>">

    
  <div class="col-lg-12 text-center mt-1" id="messages"></div> 
  <div class="col-lg-12 col-md-12 col-sm-12">
  <button type="submit" id="submitBtn"  class="btn btn-primary w-100" name="addforum">Create Forum Topic</button>
  </div></div>
                                
                                
                             </form></div></div></div>
            
















 <?php include "footer.php"; ?>