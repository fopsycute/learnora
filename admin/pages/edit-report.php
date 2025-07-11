<?php include "header.php"; 

$report_id = $_GET['report'] ?? null;
if (!$report_id) {
  header("Location: reports.php");
  exit();
}
 
$query = "SELECT r.*, u.display_name, l.category_name AS categoryname, sc.category_name AS subcategoryname 
  FROM ".$siteprefix."reports r 
  LEFT JOIN ".$siteprefix."categories l ON r.category = l.id 
  LEFT JOIN ".$siteprefix."users u ON r.user = u.s 
  LEFT JOIN ".$siteprefix."categories sc ON r.subcategory = sc.id 
  WHERE r.id = '$report_id'";
$result = mysqli_query($con, $query);
if (!$result) {
    die('Query Failed: ' . mysqli_error($con));
}
$row = mysqli_fetch_assoc($result);
if ($row) {
    $report_id = $row['id'];
    $title = $row['title'];
    $alt_title = $row['alt_title'];
    $description = $row['description'];
    $category = $row['categoryname'];
    $subcategory = $row['subcategoryname'];
    $category_id = $row['category'];
    $subcategory_id = $row['subcategory'];
    $pricing = $row['pricing'];
    $price = $row['price'];
    $tags = $row['tags'];
    $loyalty = $row['loyalty'];
    $user = $row['display_name'];
    $user_id= $row['user'];
    $created_date = $row['created_date'];
    $updated_date = $row['updated_date'];
    $status = $row['status'];
    $methodology = $row['methodology'];
    $slug =$alt_title;
$selected_resource_type = explode(',', $row['use_case'] ?? ''); // assuming stored as comma-separated
} else {
    debug('Report not found.');
}


?>


<div class="container-xxl flex-grow-1 container-p-y">
<!-- Basic Layout -->
<div class="row">
    <div class="col-xl">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Edit Report</h4>
            </div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <h6>Basic Information</h6>
                    <p><a href="<?php echo $siteurl;?>product.php/<?php echo $slug;?>" class="btn btn-primary" target="_blank">View Report</a></p>
                    <div class="mb-3">
                        <p>Current Images</p>
                        <div id="preview1" class="preview-container">
                         <?php
                         $sql3 = "SELECT * FROM ".$siteprefix."reports_images WHERE report_id = '$report_id'";   
                         $sql4 = mysqli_query($con, $sql3);
                         if (!$sql4) {die("Query failed: " . mysqli_error($con)); }
                         while ($image_row = mysqli_fetch_array($sql4)) {
                               echo '<div class="image-preview">';
                               echo '<img class="preview-image" src="'.$siteurl.'uploads/' .$image_row['picture'] . '" alt="Report Image">';
                               echo '<button type="button" class="delete-btn delete-image" data-image-id="' .$image_row['id'] . '">X</button>';
                               echo '</div>';
                           }
                       
                        ?>
                        </div>
                        <label class="form-label" for="imageInput">Upload New Images</label>
                        <input type="file" class="form-control" id="imageInput" name="images[]" multiple accept="image/*">
                        <div id="preview" class="preview-container"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="course-id">Report ID</label>
                        <input type="text" id="course-id" name="id" class="form-control" value="<?php echo $report_id; ?>" readonly required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="basic-default-fullname">Title</label>
                        <input type="text" class="form-control" name="title" id="basic-default-fullname" value="<?php echo $title; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="basic-default-message">Description</label>
                        <textarea id="basic-default-message" name="description" class="form-control"><?php echo $description; ?></textarea>
                    </div>
                    
                           <input type="hidden" name="user" value="<?php echo $user_id; ?>">
                    

                    <h6>Area of Specification</h6>
                    <div class="mb-3">
                        <select class="form-select" name="category" aria-label="Default select example" required>
                            <option selected value="<?php echo $category_id; ?>"><?php echo $category; ?></option>
                            <?php
                            $sql = "SELECT * FROM " . $siteprefix . "categories WHERE parent_id IS NULL";
                            $sql2 = mysqli_query($con, $sql);
                            while ($row = mysqli_fetch_array($sql2)) {
                                echo '<option value="' . $row['id'] . '">' . $row['category_name'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3" id="subcategory-container" style="display:block;">
                        <select class="form-select" name="subcategory" id="subcategory-select" required>
                            <option selected value="<?php echo $subcategory_id; ?>"><?php echo $subcategory; ?></option>
                        </select>
                    </div>




<!-- Use Case -->
<div class="mb-3">
<label class="form-label" for="resourceType">Use case</label>
<select name="resource_type[]" id="resourceType" multiple class="form-select mb-4 select-multiple" required>
<option value="">-- Select Use  Case--</option>
<?php
$sql = "SELECT * FROM " . $siteprefix . "use_cases ORDER BY parent_id ASC, name ASC";
$result = $con->query($sql);
$resources = [];
while ($row = $result->fetch_assoc()) {
    $resources[$row['parent_id']][] = $row;
}
foreach ($resources[NULL] as $parent) {
    echo '<option disabled>' . $parent['name'] . '</option>';
    if (!empty($resources[$parent['id']])) {
        foreach ($resources[$parent['id']] as $child) {
            $selected = in_array($child['id'], $selected_resource_type ?? []) ? 'selected' : '';
            echo '<option value="' . $child['id'] . '" ' . $selected . '> &nbsp;&nbsp;&nbsp; ' . $child['name'] . '</option>';
        }
    }
}
?>
</select>
</div>
         <h6>Pricing and File Upload</h6>
                    <div class="mb-3">
                        <label class="form-label" for="pricing-type">Pricing Type</label>
                        <select id="pricing-type" name="pricing" class="form-control" onchange="togglePrice()" required>
                            <option value="free" <?php echo ($pricing == 'free') ? 'selected' : ''; ?>>Free</option>
                            <option value="paid" <?php echo ($pricing == 'paid') ? 'selected' : ''; ?>>Paid</option>
                           
                        </select>
                    </div>
                    <div class="mb-3" id="price-field" style="display:<?php echo ($pricing == 'paid') ? 'block' : 'none'; ?>;">
                        <label class="form-label" for="course-price">Price</label>
                        <p class="text-muted">Note: Each document type attracts a portion of the total price. For example, if your product includes both a Word document and an Excel spreadsheet,
                        and you intend to sell the bundle for ₦ 2,000, enter ₦ 1,000 as the price for each document type here.</p>
                        <input type="number"  name="price" class="form-control" step="0.01" value="<?php echo $price; ?>" <?= getReadonlyAttribute() ?>>
                    </div>
    
<div class="mb-3">
<label>Click to delete uploaded documents</label>
<?php 
$sql = "SELECT * FROM ".$siteprefix."reports_files WHERE report_id = '$report_id'";
$sql2 = mysqli_query($con, $sql);
if (!$sql2) {die("Query failed: " . mysqli_error($con)); }
while ($row = mysqli_fetch_array($sql2)) {
    $file_id = $row['id'];
    $file_title = $row['title'];
    $file_pages = $row['pages'];
    $file_updated_at = $row['updated_at'];
    $file_extension = getFileExtension($file_title);
?>
<span class="file-preview">
<input type="radio" class="btn-check" value="<?php echo $file_id; ?>" name="btnradio" id="btnradio<?php echo $file_id; ?>" autocomplete="off">
<label class="btn btn-outline-primary deletefile" data-file-id="<?php echo $file_id; ?>" for="btnradio<?php echo $file_id; ?>"><?php echo $file_extension;?> (p.<?php echo $file_pages;?>)</label>
<a href="<?php echo $siteurl;?>documents/<?php echo $file_title;?>" target="_blank" class="btn btn-outline-secondary">View</a>
</span>
<?php } ?></div>




                                <div class="mb-3">
                                <label for="documentSelect" class="form-label">Upload New Document Types:</label>
   <select class="form-select select-multiple" id="documentSelect" multiple  onchange="handleDocumentSelect(this)">
                                        <option value="word">Word Document (.doc, .docx)</option>
                                        <option value="excel">Excel Spreadsheet (.xls, .xlsx)</option>
                                        <option value="powerpoint">PowerPoint Presentation (.ppt, .pptx)</option>
                                        <option value="pdf">PDF Document (.pdf)</option>
                                        <option value="text">Text File (.txt)</option>
                                        <option value="zip">Zip File (.zip)</option>
</select>
                            </div>
                            <div id="pageInputs"></div>

                                            <?php
                // Fetch all resource types
                $sql = "SELECT * FROM {$siteprefix}type_business_docs ORDER BY name ASC";
                $result = mysqli_query($con, $sql);
                $resourceOptions = [];
                while ($row = mysqli_fetch_assoc($result)) {
                    $resourceOptions[] = $row;
                }

                // Fetch all doc_file entries for this report
                $sqlDocFiles = "SELECT * FROM {$siteprefix}doc_file WHERE report_id = '$report_id'";
                $resultDocFiles = mysqli_query($con, $sqlDocFiles);
                $docFilesByType = [];
                while ($rowDocFile = mysqli_fetch_assoc($resultDocFiles)) {
                    $docFilesByType[$rowDocFile['doc_typeid']] = $rowDocFile;
                }

                // Pre-select the doc_typeid if one exists
                $selectedDocTypeId = '';
                if (!empty($docFilesByType)) {
                    $selectedDocTypeId = array_key_first($docFilesByType);
                }
                ?>

                            <h6>Other Resources</h6>
            <div class="mb-3">
            <label class="form-label" for="supportDocSelect">Upload Files:</label>
            <select class="form-select mb-4 select-multiple" id="supportDocSelect" name="supportDocSelect[]" multiple onchange="handleSupportDocSelect(this)">
    <?php foreach ($resourceOptions as $row): 
        $selected = (!empty($docFilesByType[$row['id']])) ? 'selected' : '';
    ?>
    <option value="<?php echo $row['id']; ?>" <?php echo $selected; ?>>
        <?php echo htmlspecialchars($row['name']); ?>
    </option>
    <?php endforeach; ?>
</select>
            </div>
                            
<?php foreach ($resourceOptions as $row): 
  $docTypeId = $row['id'];
  $show = !empty($docFilesByType[$docTypeId]) ? 'block' : 'none';
  $existingFile = $docFilesByType[$docTypeId]['filename'] ?? '';
  $existingPrice = $docFilesByType[$docTypeId]['price'] ?? '';
?>
  <div class="mb-3 supportDocFileInput" id="fileInput_<?php echo $docTypeId; ?>" style="display:<?php echo $show; ?>;">
    <label class="form-label" for="file_<?php echo $docTypeId; ?>"><?php echo htmlspecialchars($row['name']); ?> File</label>
    <input type="file" class="form-control mb-2" id="file_<?php echo $docTypeId; ?>" name="support_files[<?php echo $docTypeId; ?>]">
    <?php if ($existingFile): ?>
      <a href="<?php echo $siteurl; ?>uploads/<?php echo htmlspecialchars($existingFile); ?>" target="_blank" class="btn btn-outline-secondary mb-2">View Existing</a>
    <?php endif; ?>
    <label class="form-label" for="price_<?php echo $docTypeId; ?>">Price for <?php echo htmlspecialchars($row['name']); ?></label>
    <input type="number" class="form-control" id="price_<?php echo $docTypeId; ?>" name="support_prices[<?php echo $docTypeId; ?>]" step="0.01" min="0" value="<?php echo htmlspecialchars($existingPrice); ?>">
  </div>
<?php endforeach; ?>


                    <?php
                    // Check if methodology is not empty
$guidanceType = '';
if (!empty($methodology)) {
    $guidanceType = 'methodology';
} else {
    // Check if there is a guidance video for this report
    $sqlGuidance = "SELECT * FROM {$siteprefix}guidance WHERE report_id = '$report_id' LIMIT 1";
    $resultGuidance = mysqli_query($con, $sqlGuidance);
    if ($rowGuidance = mysqli_fetch_assoc($resultGuidance)) {
        $guidanceType = 'video';
        $guidanceVideoFile = $rowGuidance['video_filename'];
        $guidanceVideoId = $rowGuidance['s'];
    }
}

?>

<div class="mb-3">
  <label class="form-label" for="guidanceSelect">Guidance:</label>
  <select class="form-select" id="guidanceSelect" name="guidance_type" onchange="handleGuidanceSelect(this)">
    <option value="">-- Select Guidance Type --</option>
    <option value="methodology" <?php if($guidanceType=='methodology') echo 'selected'; ?>>Step-By-Step Methodology</option>
    <option value="video" <?php if($guidanceType=='video') echo 'selected'; ?>>Explanatory Video</option>
  </select>
</div>

<!-- Methodology Textarea -->
<div class="mb-3" id="methodologyBox" style="display: <?php echo ($guidanceType=='methodology') ? 'block' : 'none'; ?>;">
  <label class="form-label" for="basic-default-message">Methodology</label>
  <textarea id="basic-default-message" name="methodology" class="form-control" placeholder="Write required information or details here...."><?php echo htmlspecialchars($methodology); ?></textarea>
</div>

<!-- Video File Input -->
<!-- Video File Input -->
<div class="mb-3" id="videoBox" style="display: <?php echo ($guidanceType=='video') ? 'block' : 'none'; ?>;">
  <label class="form-label" for="guidanceVideo">Upload Video</label>
  <input type="file" class="form-control" id="guidanceVideo" name="guidance_video" accept="video/*">
  <?php if (!empty($guidanceVideoFile)): ?>
    <span class="file-preview">
      <input type="radio" class="btn-check" value="<?php echo $guidanceVideoId; ?>" name="guidance_radio" id="guidanceRadio<?php echo $guidanceVideoId; ?>" autocomplete="off">
      <label class="btn btn-outline-primary delete-guidance-video" data-image-id="<?php echo $guidanceVideoId; ?>" for="guidanceRadio<?php echo $guidanceVideoId; ?>">
       Delete Video
      </label>
      <a href="<?php echo $siteurl; ?>uploads/<?php echo htmlspecialchars($guidanceVideoFile); ?>" target="_blank" class="btn btn-outline-secondary">View</a>
    </span>
  <?php endif; ?>
</div>
                    <h6>Additional Information</h6>
                    <div class="mb-3">
                        <label class="form-label" for="course-tags">Tags & Keywords</label>
                        <input type="text" id="course-tags" name="tags" class="form-control" value="<?php echo $tags; ?>" required>
                    </div>
                    <?php if ($user_type === 'admin'): ?>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="loyalty" name="loyalty" <?php echo ($loyalty) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="loyalty">List under our Loyalty Program</label>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="mb-3">
                          <label class="form-label" for="status-type">Approval Status</label>
                          <select id="status-type" name="status" class="form-control" required <?= getReadonlyAttribute() ?>>
                            <option value="pending" <?php echo ($status == 'pending') ? 'selected' : ''; ?>>Pending</option>
                            <option value="approved" <?php echo ($status == 'approved') ? 'selected' : ''; ?>>Approved</option>
                          </select>
                        </div>
                    <button type="submit" name="update-report" value="course" class="btn btn-primary">Update Report</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
const selectedSubcategoryId = <?= json_encode($subcategory_id ?? null) ?>;
function fetchSubcategories(parentId) {
    let subSelect = document.getElementById('subcategory-container');
    let subcategorySelect = document.getElementById('subcategory-select');

    if (!parentId) {
        subSelect.style.display = 'none';
        return;
    }

    fetch(`get_subcategories.php?parent_id=${parentId}`)
    .then(response => response.json())
    .then(data => {
        if (data.length > 0) {
            subcategorySelect.innerHTML = '<option disabled>- Select Subcategory -</option>';
            data.forEach(cat => {
                const selected = (parseInt(cat.id) === parseInt(selectedSubcategoryId)) ? 'selected' : '';
                subcategorySelect.innerHTML += `<option value="${cat.s}" ${selected}>${cat.title}</option>`;
            });
            subSelect.style.display = 'block';
        } else {
            subSelect.style.display = 'none';
        }
    })
    .catch(error => {
        console.error('Error fetching subcategories:', error);
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const categorySelect = document.querySelector('select[name="category"]');

    // Trigger fetch if there's already a selected value (e.g. during editing)
    if (categorySelect.value) {
        fetchSubcategories(categorySelect.value);
    }

    // Attach change event
    categorySelect.addEventListener('change', function() {
        fetchSubcategories(this.value);
    });
});

document.addEventListener('DOMContentLoaded', function() {
    if (typeof togglePast === 'function') {
        togglePast();
    }
});
</script>
<?php include "footer.php"; ?>
       