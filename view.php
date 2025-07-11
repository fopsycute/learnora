
<?php include "header.php"; ?>
    <section id="best-sellers" class="best-sellers section">
<?php
$id = $_GET['id'];

// Get training info
$sql = "SELECT t.*, u.name AS instructor_name, u.photo AS instructor_photo
        FROM {$siteprefix}training t
        LEFT JOIN {$siteprefix}instructors u ON t.instructors = u.s
        WHERE t.training_id = '$id' AND t.status = 'approved'
        LIMIT 1";

$result = mysqli_query($con, $sql);
if (!$result || mysqli_num_rows($result) == 0) {
    echo "Training not found";
    exit;
}
$row = mysqli_fetch_assoc($result);

// Format details
$format = ucfirst($row['delivery_format']);
$details = '';

if ($format === 'Physical') {
    $fields = [
        'physical_address' => 'Address',
        'physical_state' => 'State',
        'physical_lga' => 'LGA',
        'physical_country' => 'Country',
        'foreign_address' => 'Foreign Address'
    ];
} elseif ($format === 'Hybrid') {
    $fields = [
        'hybrid_physical_address' => 'Physical Address',
        'hybrid_web_address' => 'Web Address',
        'hybrid_state' => 'State',
        'hybrid_lga' => 'LGA',
        'hybrid_country' => 'Country',
        'hybrid_foreign_address' => 'Foreign Address'
    ];
} elseif ($format === 'Online') {
    $fields = ['web_address' => 'Link to Join'];
}

foreach ($fields as $col => $label) {
    if (!empty($row[$col])) {
        $value = htmlspecialchars($row[$col]);
        $details .= "<li><strong>$label:</strong> ";
        $details .= filter_var($value, FILTER_VALIDATE_URL) ? "<a href='$value' target='_blank'>$value</a>" : $value;
        $details .= "</li>";
    }
}
?>

<div class="container mt-4">
    <h2><?= htmlspecialchars($row['title']); ?></h2>

    <ul class="nav nav-tabs" id="courseTabs" role="tablist">
        <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#overview">Overview</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#videos">Videos</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#text">Text Modules</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#format">Format Details</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#quizTab">Quiz</button></li>
    </ul>

    <div class="tab-content p-3 border border-top-0">
        <!-- Overview Tab -->
        <div class="tab-pane fade show active" id="overview">
            <p><?= nl2br(htmlspecialchars($row['course_description'])); ?></p>
            <p><strong>Instructor:</strong> <?= htmlspecialchars($row['instructor_name']?? ''); ?></p>
            <?php if (!empty($row['instructor_photo'])): ?>
                <img src="uploads/<?= $row['instructor_photo']; ?>" width="100" />
            <?php endif; ?>
            <p><strong>Language:</strong> <?= htmlspecialchars($row['Language']?? ''); ?></p>
            <p><strong>Level:</strong> <?= htmlspecialchars($row['level']?? ''); ?></p>
        </div>

        <!-- Videos Tab -->
        <div class="tab-pane fade" id="videos">
            <h5>Promo & Trailer Videos</h5>
            <?php
            $videos = mysqli_query($con, "SELECT video_type, video_path FROM {$siteprefix}training_videos WHERE training_id = '$id'");
            while ($v = mysqli_fetch_assoc($videos)) {
                $label = ucfirst($v['video_type']);
                echo "<p><strong>$label:</strong></p>";
                echo "<video controls width='100%' src='uploads/{$v['video_path']}'></video><hr>";
            }

            echo "<h5>Video Lessons</h5>";
            $lessons = mysqli_query($con, "SELECT file_path, video_url FROM {$siteprefix}training_Video_Lessons WHERE training_id = '$id'");
            while ($l = mysqli_fetch_assoc($lessons)) {
                if (!empty($l['video_url'])) {
                    echo "<p><iframe width='100%' height='315' src='{$l['video_url']}' frameborder='0' allowfullscreen></iframe></p>";
                } elseif (!empty($l['file_path'])) {
                    echo "<p><video controls width='100%' src='documents/{$l['file_path']}'></video></p>";
                }
            }
            ?>
        </div>

        <!-- Text Modules Tab -->
        <div class="tab-pane fade" id="text">
            <h5>Downloadable PDFs / Docs</h5>
            <?php
            $texts = mysqli_query($con, "SELECT file_path FROM {$siteprefix}training_text_modules WHERE training_id = '$id'");
            while ($t = mysqli_fetch_assoc($texts)) {
                $name = basename($t['file_path']);
                echo "<p><a href='documents/{$t['file_path']}' target='_blank'>📄 $name</a></p>";
            }
            ?>
        </div>

        <!-- Format Tab -->
        <div class="tab-pane fade" id="format">
            <ul>
                <?= $details ?: "<li>No delivery information provided.</li>"; ?>
            </ul>
        </div>
   
<div class="tab-pane fade" id="quizTab">
    <?php
  $quiz_check_sql = "SELECT qa.score 
                   FROM {$siteprefix}quiz_answers qa 
                   INNER JOIN {$siteprefix}training_quizzes tq 
                       ON qa.quiz_id = tq.s 
                   WHERE qa.user_id = '$user_id' AND tq.training_id = '$id' 
                   LIMIT 1";
$quiz_check_result = mysqli_query($con, $quiz_check_sql);

if (mysqli_num_rows($quiz_check_result) > 0) {
    $quiz_score_row = mysqli_fetch_assoc($quiz_check_result);
    $score = $quiz_score_row['score'];

    echo "<div class='alert alert-info'>";
    echo "<h5>✅ You’ve already submitted this quiz.</h5>";

    if ($score === null || $score === '') {
        echo "<p><strong>Status:</strong> You’ve not been given a score yet.</p>";
    } else {
        echo "<p><strong>Your Score:</strong> $score</p>";
    }

    echo "</div>";
} else {
    include "quiz-tab.php"; // Show quiz form if not yet submitted
}
 ?>

        </div>
    </div>
</div>



        </section>








<?php include "footer.php"; ?>