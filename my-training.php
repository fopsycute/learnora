

<?php
$current_page = basename($_SERVER['PHP_SELF']);

function generateLink($page, $icon, $text, $current_page) {
    $active_class = ($current_page == $page) ? 'accent-links' : 'text-white';
    if ($page == 'logout.php') {
        $active_class = 'text-danger';
    }
    echo "<a href=\"$page\" class=\"align-items-center  m-2  $active_class\"><i class=\"$icon mr-2\"></i> $text</a>";
}
?>

<?php
generateLink('dashboard.php', 'bi-anchor', 'Dashboard', $current_page);
generateLink('all-training.php', 'bi-video', 'My Training', $current_page);
generateLink('loyalty-status.php', 'bi-video', 'Video Lessons', $current_page);
generateLink('notifications.php', 'bi-book', 'Quiz / Assignments', $current_page);

generateLink('logout.php', 'bi-box-arrow-right', 'Logout', $current_page);
?>
