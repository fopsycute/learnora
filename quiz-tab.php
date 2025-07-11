<?php 
$quiz = mysqli_query($con, "SELECT * FROM {$siteprefix}training_quizzes WHERE training_id = '$id' LIMIT 1");

if ($quiz && mysqli_num_rows($quiz) > 0) {
    $qrow = mysqli_fetch_assoc($quiz);
    $quiz_type = $qrow['type'];
    $quiz_id = $qrow['s']; // Assuming 's' is the primary key

    // Case 1: Text-based quiz
    if ($quiz_type === 'text') {
        echo "<div class='quiz-block'>";
        echo "<h5>📄 Written Quiz / Assignment</h5>";
       echo "<p>Question: " . $qrow['text_path'] . "</p>";


        // Submit answer
        echo "<form method='post'>";
        echo "<textarea name='answer_text' class='form-control' rows='5' required></textarea>";
        echo "<input type='hidden' name='quiz_id' value='" . htmlspecialchars($quiz_id) . "'>";
        echo "<input type='hidden' name='user_id' value='" . htmlspecialchars($user_id) . "'>";
        echo "<button type='submit' name='submit-text-answer' class='btn btn-primary mt-2'>Submit Answer</button>";
        echo "</form>";
        echo "</div><hr>";
    }

    // Case 2: Upload-based quiz
    elseif ($quiz_type === 'upload') {
        echo "<div class='quiz-block'>";
        echo "<h5>📤 Upload Assignment</h5>";
        echo "<p>Please upload the required file(s) for this quiz.</p>";
        $file = htmlspecialchars($qrow['file_path']);
        $filename = basename($file); // Optional: get only the filename

echo "<p>Download the file: <a href='$documentPath$file' download='$filename' class='btn btn-outline-primary'>📥 Download Assignment</a></p>";
        echo "<form method='post' enctype='multipart/form-data'>";
        echo "<input type='file' name='answer_file' required class='form-control'>";
        echo "<input type='hidden' name='quiz_id' value='" . htmlspecialchars($quiz_id) . "'>";
        echo "<input type='hidden' name='user_id' value='" . htmlspecialchars($user_id) . "'>";
        echo "<button type='submit' name='submit-upload-answer' class='btn btn-success mt-2'>Submit File</button>";
        echo "</form>";
        echo "</div><hr>";
    }

    // Case 3: Form-based multiple-choice quiz
    elseif ($quiz_type === 'form') {
        $questions_sql = "SELECT * FROM {$siteprefix}training_quiz_questions WHERE quiz_id = $quiz_id";
        $questions_result = mysqli_query($con, $questions_sql);

        if (mysqli_num_rows($questions_result) == 0) {
            echo "<p>No questions found for this quiz.</p>";
        } else {
            echo '<h3>📝 Quiz</h3>';
            echo '<form method="post">';
            echo '<input type="hidden" name="quiz_id" value="' . htmlspecialchars($quiz_id) . '">';
            echo "<input type='hidden' name='user_id' value='" . htmlspecialchars($user_id) . "'>";
            $qno = 1;
            while ($q = mysqli_fetch_assoc($questions_result)) {
                echo '<div class="mb-4">';
                echo '<p><strong>' . $qno . '. ' . htmlspecialchars($q['question']) . '</strong></p>';
                foreach (['a', 'b', 'c', 'd'] as $opt) {
                    $optionText = htmlspecialchars($q['option_' . $opt]);
                    echo '<div>';
                    echo '<label>';
                    echo '<input type="radio" name="answer[' . $q['id'] . ']" value="' . $opt . '" required> ';
                    echo strtoupper($opt) . '. ' . $optionText;
                    echo '</label>';
                    echo '</div>';
                }
                echo '</div>';
                $qno++;
            }

            echo '<button type="submit" name="submit-quiz" class="btn btn-success">Submit Quiz</button>';
            echo '</form>';
        }
    }
} else {
    echo "<p>No quiz available for this training.</p>";
}


?>