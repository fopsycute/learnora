<?php
include "header.php";


$forum_id = isset($_GET['forum']) ? intval($_GET['forum']) : 0;
$imagePath = '../../uploads/'; // adjust as needed

// Get post data
$postRes = mysqli_query($con, "SELECT * FROM {$siteprefix}forum_posts WHERE s='$forum_id' LIMIT 1");
$post = mysqli_fetch_assoc($postRes);
if (!$post) {
    echo "<div class='alert alert-danger'>Post not found</div>";
    include "footer.php";
    exit;
}

// Handle delete

?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card mb-4">
        <div class="card-body">
            <h4 class="card-title"><?php echo htmlspecialchars($post['title']); ?></h4>
            <div class="mb-2 text-muted"><?php echo date('d M Y H:i', strtotime($post['created_at'])); ?></div>
            <?php if (!empty($post['featured_image'])): ?>
                <img src="<?php echo $imagePath . htmlspecialchars($post['featured_image']); ?>" class="img-fluid rounded mb-3" alt="Featured Image" />
            <?php endif; ?>
            <p><?php echo nl2br(htmlspecialchars($post['article'])); ?></p>
        </div>
    </div>

    <div class="card">
        <div class="card-header"><strong>Comments</strong></div>
        <div class="card-body">
            <?php renderForumCommentsModern('0', $forum_id, $con, $siteprefix, $imagePath); ?>
        </div>
    </div>
</div>

<script>
function toggleReplies(commentId) {
    var el = document.getElementById('replies-' + commentId);
    if (el) {
        el.style.display = (el.style.display === 'none' || el.style.display === '') ? 'block' : 'none';
    }
}
</script>

<?php include "footer.php"; ?>
