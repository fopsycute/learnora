
<?php include "header.php"; ?>
<?php
if (!isset($_GET['training_id'])) {
    echo "Training ID not provided.";
    exit;
}

$training_id = $_GET['training_id'];

// Get training title and address
$training_sql = "
    SELECT *
    FROM ln_training
    WHERE training_id = ?
";
$stmt = $con->prepare($training_sql);
$stmt->bind_param("i", $training_id);
$stmt->execute();
$training_result = $stmt->get_result();
$training = $training_result->fetch_assoc();
$stmt->close();

$title = htmlspecialchars($training['title']);
$address = '';
if (!empty($training['physical_address'])) $address = $training['physical_address'];
elseif (!empty($training['hybrid_physical_address'])) $address = $training['hybrid_physical_address'];
elseif (!empty($training['foreign_address'])) $address = $training['foreign_address'];

// Get next event date
$date_sql = "SELECT event_date FROM ln_training_event_dates WHERE training_id = ? ORDER BY event_date ASC LIMIT 1";
$stmt = $con->prepare($date_sql);
$stmt->bind_param("i", $training_id);
$stmt->execute();
$date_result = $stmt->get_result();
$event_date = '';
if ($date_row = $date_result->fetch_assoc()) {
    $event_date = date('D, M j, Y', strtotime($date_row['event_date']));
}
$stmt->close();

// Get attendees (paid)
$attendee_sql = "
    SELECT u.first_name, u.last_name
    FROM ln_order_items oi
    JOIN ln_orders o ON oi.order_id = o.order_id
    JOIN ln_users u ON o.user = u.s
    WHERE oi.training_id = ? AND o.status = 'paid'
    ORDER BY o.date DESC
    LIMIT 3
";

$stmt = $con->prepare($attendee_sql);
$stmt->bind_param("i", $training_id);
$stmt->execute();
$result = $stmt->get_result();
echo "<div class='container'>";
echo "<div class='row'>";
echo "<div class='col-lg-8 mx-auto'>";
echo "<h4>Training Attendees</h4>";
echo "<div class='card mb-4'><div class='card-body'>";
echo "<ul class='list-group mb-4'>";
while ($row = $result->fetch_assoc()) {
    $name = htmlspecialchars($row['first_name']). " " . htmlspecialchars($row['last_name']);
    echo "<li class='list-group-item'>
        <strong>$name</strong> would be attending <strong>$title</strong> at <strong>$address</strong> on <strong>$event_date</strong>. 
   
    </li>";
}
echo "</ul>";
echo "</div></div>";
echo "</div>";
echo "</div></div>";

?>










<?php include "footer.php"; ?>