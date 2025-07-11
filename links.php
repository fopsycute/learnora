
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

// Only show "Add Training" if the user is a trainer
if (isset($trainer) && $trainer == 1) {
    generateLink('add-training.php', 'ti-plus', 'Add Training', $current_page);
    generateLink('saved-training.php', 'ti-edit', 'Draft', $current_page);
    generateLink('wallet.php', 'ti-wallet', 'Wallet', $current_page);
}
generateLink('dashboard.php', 'bi-anchor', 'Dashboard', $current_page);
generateLink('loyalty-status.php', 'bi-agenda', 'Subscriptions', $current_page);
generateLink('notifications.php', 'bi-bell', 'Notifications', $current_page);
generateLink('create_ticket.php', 'bi-book', 'Create New Ticket', $current_page);
generateLink('settings.php', 'bi-gear', 'Settings', $current_page);
generateLink('logout.php', 'bi-box-arrow-right', 'Logout', $current_page);
?>
