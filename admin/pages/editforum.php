<?php
include "header.php";
if (isset($_GET['id'])) {
    $forum_id = intval($_GET['id']);
    // Fetch forum post
    $sql = "SELECT * FROM {$siteprefix}forum_posts WHERE s = $forum_id LIMIT 1";
    $result = mysqli_query($con, $sql);
    $forum = mysqli_fetch_assoc($result);

    // Prepare current values
    $current_title = htmlspecialchars($forum['title'] ?? '');
    $current_article = htmlspecialchars($forum['article'] ?? '');
    $current_categories = isset($forum['categories']) ? explode(',', $forum['categories']) : [];
    $current_image = $forum['featured_image'] ?? '';
}
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-body">
            <form method="POST" id="addForum" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group mb-3">
                            <label class="form-label" for="first_name">Attach Featured Image</label>
                            <?php if (!empty($current_image)): ?>
                                <div class="mb-2">
                                    <img src="../../uploads/<?php echo htmlspecialchars($current_image); ?>" alt="Featured Image" style="max-width: 120px; max-height: 120px; border-radius: 8px;">
                                </div>
                            <?php endif; ?>
                            <input class="form-control" type="file" id="imageInput" name="featured_image">
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group mb-3">
                            <label class="form-label" for="first_name">Enter Forum Title</label>
                            <input placeholder="Enter Forum Title" id="first_name" type="text" class="form-control" name="title" value="<?php echo $current_title; ?>" required>
                        </div>
                    </div>

                    <div class="col-md-12 form-group">
                        <div class="mb-3">
                            <label>Area of Specialization:</label>
                            <select class="form-select mb-4 select-multiple" name="category[]" multiple aria-label="Default select example" required>
                                <option>- Select Category -</option>
                                <?php
                                $sql = "SELECT * FROM " . $siteprefix . "categories WHERE parent_id IS NULL ";
                                $sql2 = mysqli_query($con, $sql);
                                while ($row = mysqli_fetch_array($sql2)) {
                                    $selected = in_array($row['id'], $current_categories) ? 'selected' : '';
                                    echo '<option value="' . $row['id'] . '" ' . $selected . '>' . htmlspecialchars($row['category_name']) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="form-label" for="editor">Enter Forum Details</label>
                            <textarea class="form-control" id="editor" name="article"><?php echo $current_article; ?></textarea>
                        </div>
                    </div>

                    <input type="hidden" name="user" value="<?php echo $user_id; ?>">
                    <input type="hidden" name="forum_id" value="<?php echo $forum_id; ?>">

                    <div class="col-lg-12 text-center mt-1" id="messages"></div>
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <button type="submit" id="submitBtn" class="btn btn-primary w-100" name="editforum">Update Forum Topic</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>