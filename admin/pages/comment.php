
 <div class="forum-comment d-flex gap-3 py-3 border-bottom" id="comment-<?php echo $comment['s']; ?>" style="margin-left:<?php echo $level * 30; ?>px;">
            <div class="forum-comment-avatar">
                <img src="<?php echo htmlspecialchars($avatar); ?>" alt="Avatar" class="rounded-circle" width="48" height="48" loading="lazy">
            </div>
            <div class="forum-comment-content flex-grow-1">
                <div class="forum-comment-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-1 fw-bold"><?php echo htmlspecialchars($username); ?></h6>
                    <small class="text-muted"><i class="bi bi-clock me-1"></i><?php echo date('M d, Y H:i', strtotime($comment['commented_time'])); ?></small>
                </div>
                <div class="forum-comment-body mb-2">
                    <p class="mb-0"><?php echo nl2br(htmlspecialchars($comment['comments'])); ?></p>
                </div>
                <div class="forum-comment-actions d-flex gap-2 align-items-center">
                    <!-- Delete (Admin only) -->
                    <form method="post" action="" onsubmit="return confirm('Are you sure you want to delete this comment and all its replies?');" class="m-0">
                        <input type="hidden" name="delete_comment_id" value="<?php echo $comment['s']; ?>">
                        <button type="submit" name="delete_comment" class="btn btn-sm btn-outline-danger d-flex align-items-center gap-1">
                            <i class="bx bx-trash"></i> 
                        </button>
                    </form>
                    <?php if ($replyCount > 0): ?>
                        <button class="btn btn-sm btn-link" type="button" onclick="toggleReplies(<?php echo $comment['s']; ?>)">
                            View replies (<?php echo $replyCount; ?>)
                        </button>
                    <?php endif; ?>
                </div>

                <!-- Replies container -->
                <div class="forum-replies mt-3" id="replies-<?php echo $comment['s']; ?>" style="display:none;">
                    <?php renderForumCommentsModern($comment['s'], $forum_id, $con, $siteprefix, $imagePath, $level + 1); ?>
                </div>
            </div>
        </div>