
<div class="comment-box reply">
    <div class="comment-wrapper">
        <div class="avatar-wrapper">
            <img src="<?php echo htmlspecialchars($replyAvatar); ?>" alt="Avatar" loading="lazy">
           
        </div>
        <div class="comment-content">
            <div class="comment-header">
                <div class="user-info">
                    <h4><?php echo htmlspecialchars($replyUsername); ?></h4>
                    <span class="time-badge">
                        <i class="bi bi-clock"></i>
                        <?php echo date('M d, Y H:i', strtotime($reply['commented_time'])); ?>
                    </span>
                </div>
            </div>
            <div class="comment-body">
                <p><?php echo nl2br(htmlspecialchars($reply['comments'])); ?></p>
            </div>
            <div class="comment-actions">
                <button class="action-btn reply-btn" aria-label="Reply to reply" onclick="showReplyForm(<?php echo $reply['s']; ?>)">
                    <i class="bi bi-chat"></i>
                    <span>Reply</span>
                </button>
                <?php if ($reply['user_id'] == $user_id): ?>
                  <form method="post" action="" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this comment and all its replies?');">
                    <input type="hidden" name="delete_comment_id" value="<?php echo $reply['s']; ?>">
                    <button type="submit" name="delete_comment" class="action-btn delete-btn" aria-label="Delete comment" style="background:none;border:none;">
                      <i class="bi bi-trash"></i>
                      <span>Delete</span>
                    </button>
                  </form>
                <?php endif; ?>
                <?php if ($nestedCount > 0): ?>
                <button class="btn btn-link p-0 ms-2" type="button" onclick="toggleReplies(<?php echo $reply['s']; ?>)">
                    View replies (<?php echo $nestedCount; ?>)
                </button>
                <?php endif; ?>
            </div>
            <!-- Nested reply form -->
            <div class="reply mt-2" id="reply-form-<?php echo $reply['s']; ?>" style="display:none;">
                <form method="post" role="form">
                    <input type="hidden" name="blog_id" value="<?php echo $forum_id; ?>">
                    <input type="hidden" name="user" value="<?php echo htmlspecialchars($user_id); ?>">
                    <input type="hidden" name="parent_comment_id" value="<?php echo $reply['s']; ?>">
                    <div class="input-group">
                        <textarea name="comment" rows="2" class="form-control" placeholder="Write your reply..." required></textarea>
                        <button type="submit" name="post_reply_comment" class="btn btn-primary">Reply</button>
                    </div>
                </form>
            </div>
            <!-- Nested replies container -->
            <div class="replies-container mt-2" id="replies-<?php echo $reply['s']; ?>" style="display:none;">
                <?php
                // This will be filled by the recursive function
                if (function_exists('renderReplies')) {
                    renderReplies($reply['s'], $forum_id, $con, $siteprefix, $imagePath, $user_id);
                }
                ?>
            </div>
        </div>
    </div>
</div>