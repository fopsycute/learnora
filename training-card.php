
<div class="col-6 col-lg-3">
            <div class="product-card" data-aos="zoom-in">
            <div class="product-image">
            <img src="<?= $image_paths; ?>" alt="<?= $title; ?>" class="training-cover" />
        </div>
        <div class="product-details">
            <h4 class="product-title"><?= $title; ?></h4>
            <p>📅 
                <?php 
                foreach ($event_dates as $dateInfo) {
                    echo date("M j, Y", strtotime($dateInfo['event_date'])) . 
                         " | " . date("g:ia", strtotime($dateInfo['start_time'])) . 
                         " - " . date("g:ia", strtotime($dateInfo['end_time'])) . "<br>";
                }
                ?>
            </p>
            <p class="small-text"><i class="bi bi-people"></i>Instructor: <?= $instructor_name; ?></p>
            <p class="small-text"><i class="bi bi-file-earmark-text"></i>Format: <?= $format; ?> <?= $price ? ' | ₦' . number_format($price) : ''; ?></p>
            <div class="actions">
                <a href="view.php?id=<?= $training_id; ?>" class="btn btn-primary">📚 Access Course</a>
            </div>
        </div>
    </div>
  </div>

