<?php
if (isset($_SESSION['feed_dropdown'])) $feed_dropdown = $_SESSION['feed_dropdown'];
if (isset($data)) {
  $posts = $data[0];
  if (isset($data[1])) $votes = $data[1]; // There's a possibility that there are no votes in posts
  $upvote_class = "upvote_default";
  $downvote_class = "downvote_default";
}

?>
<div class="row">
  <div class="col col-lg-12 col-xs-12">
    <!-- Breadcrumb -->
    <div class="d-flex justify-content-start breadcrumb_section">
      <span class="secondary-breadcrumb">Home</span>
      <span class="breadcrumb-divider"><i class="fas fa-angle-right"></i></span>
      <?php if ($_SESSION['feed_page'] == 'userfeed') { ?>
        <span class="primary-breadcrumb">My feed</span>
      <?php } else if ($_SESSION['feed_page'] == 'popularfeed') { ?>
        <span class="primary-breadcrumb">Popular feed</span>
      <?php } ?>
    </div>
    <?php if (isset($feed_dropdown) && isset($data)) { ?>
      <div id="feed_filters_section" class="dropdown d-flex justify-content-end">
        <select name="feed_filters" id="feed_filters" onchange="loadFeed(this.value);">
          <option value="latest" <?php if ($feed_dropdown == 'latest') echo 'selected="selected"' ?>>Latest posts</option>
          <option value="popular" <?php if ($feed_dropdown == 'popular') echo 'selected="selected"' ?>>Popular posts</option>
          <option value="oldest" <?php if ($feed_dropdown == 'oldest') echo 'selected="selected"' ?>>Oldest posts</option>
          <option value="unpopular" <?php if ($feed_dropdown == 'unpopular') echo 'selected="selected"' ?>>Unpopular posts</option>
        </select>
      </div>
    <?php } ?>
    <div id="feed_filtered-posts">
      <?php
      if (isset($data)) {
        foreach ($posts as $post) { ?>
          <div class="post">
            <div class="post_title">
              <img src="views/web/img/avatars/<?php echo $post['avatar'] ?>" alt="user" />
              <div class="post_title_content">
                <p class="mb-0">
                  <a onclick="loadSpecificCategory('<?php echo $post['category_name'] ?>')" class="text-decoration-none"><?php echo $post['category_name'] ?>
                    <i class="<?php echo $post['icon'] ?> mx-1"></i>
                  </a>
                </p>
                <span>Posted by <b><?php echo $post['username'] ?></b></span>
              </div>
            </div>
            <div class="post_description <?php if (!$post['media_url']) echo "post_description_xs" ?>">
              <p class="post_subtitle">
                <a class="text-decoration-none dynamic-content custom-link-text" onclick="sendPostId(<?php echo $post['post_id'] ?>)"><?php echo $post['title'] ?></a>
              </p>
              <?php if ($post['media_url']) { ?>
                <img class="img-fluid custom-link" src="views/web/img/media/<?php echo $post['media_url'] ?>" alt="post-media" onclick="sendPostId(<?php echo $post['post_id'] ?>)" />
              <?php } ?>
              <?php if ($post['description']) { ?>
                <div class="post_description_title custom-link-text" onclick="sendPostId(<?php echo $post['post_id'] ?>)">
                  <?php if ($post['description']) echo $post['description']; ?>

                </div>
              <?php } ?>
            </div>
            <div class="post-date-area">
              <span><?php echo date_format(new DateTime($post['datetime']), 'j D M Y');  ?></span>
            </div>
            <div class="votes_comments_area">
              <div class="icons" id="<?php echo $post['post_id'] ?>">
                <?php
                if (isset($votes) && isset($votes[$post['post_id']])) {
                  if ($votes[$post['post_id']] == "0") {
                    $downvote_class = 'downvote_filled';
                  } else if (isset($votes) && $votes[$post['post_id']] == "1") {
                    $upvote_class = 'upvote_filled';
                  }
                }
                ?>
                <img class="upvote_button vote_icon_size <?php echo $upvote_class; ?>" src="https://i.imgur.com/cJ150o7.png" alt="upvote button" onclick="ratePost(<?php echo $post['post_id'] ?>,1)" />
                <span class="votes_number purple_color total_upvotes"><?php echo $post['up_votes'] ?></span>
                <img class="downvote_button vote_icon_size <?php echo $downvote_class; ?>" src="https://i.imgur.com/f50DFkG.png" alt="downvote button" onclick="ratePost(<?php echo $post['post_id'] ?>,0)" />
                <span class="votes_number red_color total_downvotes"><?php echo $post['down_votes'] ?></span>
              </div>
              <div class="comment_counts custom-link-text" onclick="sendPostId(<?php echo $post['post_id'] ?>)">
                <i class="far fa-comment-alt"></i>
                <?php if ($post['total_comments'] == 0) { ?>
                  <span>No comments yet</span>
                <?php } else if ($post['total_comments'] == 1) { ?>
                  <span><?php echo $post['total_comments']; ?> comment</span>
                <?php } else { ?>
                  <span><?php echo $post['total_comments']; ?> comments</span>
                <?php } ?>
              </div>
            </div>
          </div>
          <?php // We reset the up/downvote icon values  
          $upvote_class = "upvote_default";
          $downvote_class = "downvote_default"; ?>
        <?php }
      } else { ?>
        <div class="no-posts-message">
          <p class="m-0">You aren't following any category. Explore the Popular feed or go to All categories to find categories of your interest.</p>
        </div>
      <?php } ?>
    </div>
  </div>
</div>