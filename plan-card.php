

<div class="col-md-4 mb-4">
    <div class="plan-card shadow-lg border-0 text-center rounded-4 h-100 bg-white position-relative overflow-hidden">
        <div class="plan-card-body p-4 d-flex flex-column align-items-center h-100">
            <div class="w-100 d-flex justify-content-center mb-3">
                <img src="<?= $siteurl . (!empty($image_path) ? $image_path : 'assets/img/plan-default.png') ?>"
                     alt="<?= htmlspecialchars($name) ?>"
                     class="plan-card-img  img-fluid border border-3 border-primary">
            </div>
            <h5 class="plan-card-title fw-bold mb-2"><?= htmlspecialchars($name) ?></h5>
            <p class="plan-card-text px-2 mb-3 text-muted small"><?= htmlspecialchars($description) ?></p>
            <h4 class="plan-card-price fw-bold mb-2">₦<?= formatNumber($price) ?></h4>
            <small class="text-muted d-block mb-3">
                Duration:
                <?php
                if ($duration === 'Monthly') {
                    echo $no_of_duration . ' ' . ($no_of_duration > 1 ? 'Months' : 'Month');
                } elseif ($duration === 'Yearly') {
                    echo $no_of_duration . ' ' . ($no_of_duration > 1 ? 'Years' : 'Year');
                }
                ?>
            </small>
            <ul class="list-group list-group-flush mb-3 w-100">
                <li class="list-group-item bg-transparent border-0 px-0 py-1">
                    <span class="badge bg-success me-2"><strong><?= $discount ?>% Off</strong></span>
                    <span class="text-muted">Discount</span>
                </li>
                <li class="list-group-item bg-transparent border-0 px-0 py-1">
                    <span class="badge bg-success text-dark me-2"><strong><?= $downloads ?></strong></span>
                    <span class="text-muted">Purchases</span>
                </li>
                <li class="list-group-item bg-transparent border-0 px-0 py-1">
                    <strong>Benefits:</strong>
                    <ul class="list-unstyled mb-0 mt-1">
                        <?php foreach ($benefits as $benefit): ?>
                            <li class="text-success small">✅ <?= htmlspecialchars(trim($benefit)) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            </ul>
            <div class="mt-auto w-100">
                <?php if ($active_log == 1): ?>
                    <?php if ($loyalty_id > 0): ?>
                        <a href="loyalty-status.php" class="btn btn-outline-primary w-100 mb-2">Manage Subscription</a>
                        <button class="btn btn-primary w-100" disabled>Subscribe</button>
                    <?php else: ?>
                        <button class="btn btn-primary w-100 payButton"
                            data-plan-id="<?= $plan_id ?>"
                            data-amount="<?= $price ?>"
                            data-plan-name="<?= htmlspecialchars($name, ENT_QUOTES) ?>"
                            data-user-id="<?= $user_id ?>"
                            data-email="<?= $email_address ?>">
                            Subscribe
                        </button>
                    <?php endif; ?>
                <?php else: ?>

<button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#loginModal">Subscribe</button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
