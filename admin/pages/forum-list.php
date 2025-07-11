
<?php include "header.php"; ?>


<div class="container-xxl flex-grow-1 container-p-y">

              <!-- Hoverable Table rows -->
              <div class="card">
                <h5 class="card-header">Manage Reports</h5>
                 <div class="table-responsive text-nowrap ">
                  <table class="table table-hover">
                  <thead>
                  <tr>
                  <th>S/N</th>
                <th>Title</th>
                 <th>Date Uploaded</th>
                    <th>Uploaded By</th>
                    <th>Categories</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody class="table-border-bottom-0">
                 <?php
// Fetch forum posts
$sql = "SELECT fp.*, u.display_name 
        FROM {$siteprefix}forum_posts fp 
        LEFT JOIN {$siteprefix}users u ON fp.user_id = u.s 
        ORDER BY fp.created_at DESC";
$result = mysqli_query($con, $sql);
$sn = 1;

while ($row = mysqli_fetch_assoc($result)) {
    $s = $row['s'];
    $title = htmlspecialchars($row['title']);
    $date = date('d M Y', strtotime($row['created_at']));
    $uploader = htmlspecialchars($row['display_name']);

    // Fetch category names
    $catNames = [];
    if (!empty($row['categories'])) {
        $catIds = explode(',', $row['categories']);
        $catIds = array_map('intval', $catIds);
        $catIdList = implode(',', $catIds);
        $catSql = "SELECT category_name FROM {$siteprefix}categories WHERE id IN ($catIdList)";
        $catRes = mysqli_query($con, $catSql);
        while ($catRow = mysqli_fetch_assoc($catRes)) {
            // Truncate to 5 letters + ...
            $catNames[] = strlen($catRow['category_name']) > 5
                ? substr($catRow['category_name'], 0, 5) . '...'
                : $catRow['category_name'];
        }
    }
    $categories = implode(', ', $catNames);
?>
<tr>
        <td><?php echo $sn; ?></td>
        <td><?php echo $title; ?></td>
        <td><?php echo $date; ?></td>
        <td><?php echo $uploader; ?></td>
        <td><?php echo $categories; ?></td>
<td>
     <a href='editforum.php?id=<?php echo $s; ?>' class='btn btn-sm text-small btn-primary'>
               <i class="bx bx-edit"></i>
            </a>
     <a class="btn btn-sm text-small btn-secondary delete" href="delete.php?action=deleteforum&table=forum_posts&item=<?php echo $s; ?>&page=<?php echo $current_page; ?>"><i class="bx bx-trash me-1"></i> </a>
           
        

    <a href="viewforum.php?forum=<?php echo $s; ?>" class="btn btn-sm text-small btn-info">
        <i class="bx bx-show"></i>
    </a>
</td>
    </tr>
<?php
    $sn++;
}
?>
 </tbody>
                  </table>
                </div>
                </div>
              </div>
              <!--/ Hoverable Table rows -->

            

            </div>




<?php include "footer.php"; ?>
