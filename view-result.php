
<?php include "header.php"; 
//submit quiz
$quiz_id =$_GET['quiz_id'];



if (!$quiz_id) {
    echo "<p class='text-danger'>Invalid session or quiz ID.</p>";
  
    exit;
}

// Get user's score (optional: could skip this if recalculating below)
$score_result = mysqli_query($con, "SELECT score FROM {$siteprefix}quiz_answers WHERE quiz_id = '$quiz_id' AND user_id = '$user_id'");
$score_row = mysqli_fetch_assoc($score_result);
$score = $score_row['score'] ?? 0;

// Fetch quiz questions and answers
$questions_sql = "SELECT * FROM {$siteprefix}training_quiz_questions WHERE quiz_id = $quiz_id";
$questions_result = mysqli_query($con, $questions_sql);
$total = mysqli_num_rows($questions_result);
$feedback = [];

$user_answers = []; // Re-fetch user's answers from form submission if needed
foreach ($_POST['answer'] ?? [] as $qid => $val) {
    $user_answers[intval($qid)] = strtolower($val);
}

while ($q = mysqli_fetch_assoc($questions_result)) {
    $qid = $q['id'];
    $correct = strtolower($q['correct_answer']);

    // In production, you should store answers per user. For now, use $user_answers[]
    $user_answer = $_SESSION['last_quiz_answers'][$qid] ?? ''; // Fallback if not storing in DB
    $is_correct = ($user_answer === $correct);

    $feedback[] = [
        'question' => $q['question'],
        'user_answer' => strtoupper($user_answer),
        'correct_answer' => strtoupper($correct),
        'is_correct' => $is_correct,
        'options' => [
            'A' => $q['option_a'],
            'B' => $q['option_b'],
            'C' => $q['option_c'],
            'D' => $q['option_d'],
        ]
    ];
}

echo "<div class='container my-5'>";
echo "<h4>Your Score: $score / $total</h4><hr>";

foreach ($feedback as $f) {
    echo "<div class='mb-4'>";
    echo "<p><strong>Q:</strong> " . htmlspecialchars($f['question']) . "</p>";
    foreach ($f['options'] as $label => $text) {
        $style = '';
        if ($f['user_answer'] === $label && !$f['is_correct']) {
            $style = 'color:red;';
        } elseif ($f['correct_answer'] === $label) {
            $style = 'color:green;font-weight:bold;';
        }
        echo "<p style='$style'>$label. " . htmlspecialchars($text) . "</p>";
    }
    echo "</div><hr>";
}
echo "</div>";

?>




<?php include "footer.php"; ?>