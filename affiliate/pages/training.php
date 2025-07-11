
<?php include "header.php"; ?>

<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Hoverable Table rows -->
    <div class="card">
        <h5 class="card-header">Manage Reports</h5>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Event Title</th>
                        <th>Category</th>
                        <th>Subcategory</th>
                        <th>Pricing</th>
                        <th>Price</th>
                        <th></th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    <?php 
                    $query = "SELECT t.*, l.category_name AS category, sc.category_name AS subcategory, tt.price
          FROM ".$siteprefix."training t
          LEFT JOIN ".$siteprefix."categories l ON t.category = l.id 
          LEFT JOIN ".$siteprefix."categories sc ON t.subcategory = sc.id
          LEFT JOIN ".$siteprefix."training_tickets tt ON t.training_id = tt.training_id";
                    $result = mysqli_query($con, $query);
                    if (!$result) {
                        die('Query Failed: ' . mysqli_error($con));
                    }
                    $i = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $training_id = $row['training_id'];
                        $title = $row['title'];
                        $category = $row['category'];
                        $subcategory = $row['subcategory'];
                        $pricing = $row['pricing'];
                        $price = $row['price'];
                        $tags = $row['tags'];
                        $slug = $row['alt_title'];

                    ?>
                    <tr>
                        <td><strong><?php echo $i; ?></strong></td>
                        <td><?php echo htmlspecialchars($title); ?></td>
                        <td><?php echo htmlspecialchars($category); ?></td>
                        <td><?php echo htmlspecialchars($subcategory); ?></td>
                        <td><?php echo htmlspecialchars($pricing); ?></td>
                        <td> <?php
                            if ($pricing === 'paid') {
                            echo $sitecurrency . $price;
                            } elseif ($pricing === 'free') {
                            echo 'Free';
                            } elseif ($pricing === 'donation') {
                            echo 'Donate Any Amount';
                            }
                        ?></td>
                        
                        <td>
                            <!-- View Product Button -->
                            <a href="<?php echo $siteurl;?>events?slug=<?php echo $slug; ?>" target="_blank" class="btn btn-info btn-sm me-2">View Product</a>
                        </td>
                        <td>
                            <?php if ($pricing != 'free'): ?>
                                <?php
                                $check_query = "SELECT * FROM ".$siteprefix."affiliate_products WHERE user_id = '$user_id' AND product_id = '$training_id'";
                                $check_result = mysqli_query($con, $check_query);

                                if (mysqli_num_rows($check_result) > 0):
                                    $affiliate_data = mysqli_fetch_assoc($check_result);
                                    $affiliate_link = $affiliate_data['affiliate_link'];
                                    $encoded_affiliate_link = $affiliate_link; // Encode the affiliate link
                                ?>
                                    <!-- Copy Affiliate Link -->
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="affiliate_link_<?php echo $training_id; ?>" value="<?php echo htmlspecialchars($encoded_affiliate_link, ENT_QUOTES, 'UTF-8'); ?>" readonly>
                                        <button class="btn btn-primary btn-sm" onclick="copyToClipboard('<?php echo $training_id; ?>')">Copy Link</button>
                                    </div>
                                <?php else: ?>
                                    <!-- Add to List Button -->
                                    <form method="post">
                                    
                                        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                                        <input type="hidden" name="affliate_id" value="<?php echo $affliate; ?>">
                                        <input type="hidden" name="product_id" value="<?php echo $training_id; ?>">
                                        <button type="submit" class="btn btn-success btn-sm" name="add_to_affiliate_list">Add to List</button>
                                    </form>
                                <?php endif; ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php $i++; } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function copyToClipboard(trainingId) {
        var copyText = document.getElementById("affiliate_link_" + trainingId);
        copyText.select();
        copyText.setSelectionRange(0, 99999); // For mobile devices
        document.execCommand("copy");
        alert("Copied: " + copyText.value);
    }
</script>

<?php include "footer.php"; ?>