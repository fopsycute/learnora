
<div class="col-lg-4">
    <a href="<?php echo $siteurl; ?>view-blog/<?php echo $alt_title; ?>">
  <article class="post-item side-post">
    <div class="post-img">
  <img src="<?php echo $siteurl.$image_path; ?>" alt="" class="img-fluid">
    <div class="category-container">
<?php foreach ($catNames as $cat): ?>
        <span class="category"><?php echo htmlspecialchars($cat); ?></span>
      <?php endforeach; ?>
</div></div>
    <h2 class="title">
      <a href="<?php echo $siteurl; ?>view-blog/<?php echo $alt_title; ?>"><?php echo $title; ?></a>
    </h2>
    <div class="d-flex align-items-center">
      <img src="<?php echo $siteurl;?>/img/<?php echo $siteimg; ?>" alt="site image" class="img-fluid post-author-img flex-shrink-0">
      <div class="post-meta">
        <p class="post-author"><?php echo $sitename; ?></p>
        <p class="post-date">
          <time datetime="<?php echo $row['created_at']; ?>"><?php echo $date; ?></time>
        </p>
      </div>
    </div>
  </article>
  </a>
</div>
