
<?php 

include "header.php"; 

if (isset($_GET['training_id'])) {
    $raw_slug = $_GET['training_id'];

    $training = $raw_slug; // convert to lowercase for matching


    // Prepare SQL: match using LOWER to handle case insensitivity
    $sql = "SELECT * FROM " . $siteprefix . "training WHERE training_id = '$training'";
    $sql2 = mysqli_query($con, $sql);

    if (!$sql2) {
        die("Query failed: " . mysqli_error($con));
    }

    $count = 0;
    while ($row = mysqli_fetch_array($sql2)) {
        $id = $row['training_id'];
        $training_name = $row['title'];
        // You can use other fields here too if needed
    }
} else {
    header("Location: " . $siteurl . "index.php");
    exit();
}


?>
<div class="container my-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Request an In-House Training Proposal</h4>
        </div>
        <div class="card-body">
            <p>
                <strong><?php echo $sitename ?? 'Name of Training Company'; ?></strong> is able to provide customized courses to meet the precise requirements of individual clients.
            </p>
            <form method="post" class="row g-3">
                <div class="col-md-6">
                    <label for="seminar_title" class="form-label">Seminar Title</label>
                    <input type="text" class="form-control" id="seminar_title" name="seminar_title" value="<?php echo  $training_name; ?>" required>
                </div>
                <div class="col-md-3">
                    <label for="days" class="form-label">Select Name of Days</label>
                   <select class="form-select" id="days" name="days" required>
                    <option value="">Choose...</option>
                    <option value="Monday">Monday</option>
                    <option value="Tuesday">Tuesday</option>
                    <option value="Wednesday">Wednesday</option>
                    <option value="Thursday">Thursday</option>
                    <option value="Friday">Friday</option>
                </select>
                </div>
                <input type="hidden" name="training" value="<?php echo $id; ?>">
                <div class="col-md-3">
                    <label for="participants" class="form-label">Number of Participants</label>
                    <input type="number" class="form-control" id="participants" name="participants" min="1" required>
                </div>
                <div class="col-md-6">
                    <label for="name" class="form-label">Your Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="col-md-6">
                    <label for="position" class="form-label">Position</label>
                    <input type="text" class="form-control" id="position" name="position">
                </div>
                <div class="col-md-6">
                    <label for="company" class="form-label">Company</label>
                    <input type="text" class="form-control" id="company" name="company" required>
                </div>
                <div class="col-md-6">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" class="form-control" id="address" name="address">
                </div>
                <div class="col-md-4">
                    <label for="city" class="form-label">City</label>
                    <input type="text" class="form-control" id="city" name="city">
                </div>
                <div class="col-md-4">
                    <label for="country" class="form-label">Country</label>
                    <input type="text" class="form-control" id="country" name="country">
                </div>
                <div class="col-md-4">
                    <label for="email" class="form-label">E-Mail</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="col-md-6">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" class="form-control" id="phone" name="phone">
                </div>
                <div class="col-md-6">
                    <label for="mobile" class="form-label">Mobile</label>
                    <input type="text" class="form-control" id="mobile" name="mobile">
                </div>
                <div class="col-12">
                    <label for="comment" class="form-label">Comment</label>
                    <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                </div>
                <div class="col-12">
                    <button type="submit" name="submit_request" class="btn btn-primary">Submit Request</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>