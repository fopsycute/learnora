    <?php include "backend/connect.php"; ?>

<?php
$blog_id = intval($_POST['blog_id']);
$user_ip = $_SERVER['REMOTE_ADDR'];

$check = mysqli_query($con, "SELECT * FROM {$siteprefix}blog_likes WHERE blog_id = $blog_id AND user_ip = '$user_ip'");
if (mysqli_num_rows($check) > 0) {
    echo json_encode(['success' => false, 'message' => 'You already liked this post.']);
    exit;
}

$insert = mysqli_query($con, "INSERT INTO {$siteprefix}blog_likes (blog_id, user_ip) VALUES ($blog_id, '$user_ip')");

$countRes = mysqli_query($con, "SELECT COUNT(*) as total FROM {$siteprefix}blog_likes WHERE blog_id = $blog_id");
$countRow = mysqli_fetch_assoc($countRes);

echo json_encode(['success' => true, 'likes' => $countRow['total']]);
?>


