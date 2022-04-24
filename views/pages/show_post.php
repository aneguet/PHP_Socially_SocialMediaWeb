<?php


$u = new UserController();
$userData = $u->getUserInfo($_SESSION['userId']);

// Load POST INFO
// this data came from the Page Controller
$post_id = $data;
$p = new PostController();
// $post = $p->loadPostById($postID);
$post = $p->loadPostById($post_id);

// Load right menu CATEGORY info
$c = new CategoryController();
$category_info = $c->loadCategoryById($post[0]['category_name']);
$followers = $c->getCategoryFollowers($post[0]['category_name']);

// Check if user follows the category
if ($userData) {
    $c = new CategoryController();
    $category = $c->isUserFollower($category_info[0]['category_name']);
}

// Load COMMENTS
$c = new CommentController();
$comments = $c->loadCommentsbyPostId($post_id);
?>

<!-- Main content -->
<div class="row">
    <div class="col col-lg-10 col-xs-12">
        <div class="row">
            <div class="col col-lg-12 justify-content-center">
                <div class="show_post min-vh-100">
                    <div class="post_title">
                        <img src="views/web/img/avatars/<?php echo $post[0]['avatar'] ?>" alt="user" />
                        <div class="post_title_content">
                            <p class="mb-0">
                                <a onclick="loadSpecificCategory('<?php echo $post[0]['category_name'] ?>')" class="text-decoration-none"><?php echo $post[0]['category_name'] ?>
                                    <i class="<?php echo $post[0]['icon'] ?> mx-1"></i>
                                </a>
                            </p>
                            <span>Posted by <b><?php echo $post[0]['username'] ?></b></span>
                        </div>
                    </div>
                    <div class="post_description">
                        <p style="font-size:17px; font-weight:400;" class="post_subtitle">
                            <?php echo $post[0]['title'] ?>
                        </p>
                        <?php if ($post[0]['media_url']) { ?><img class="img-fluid" src="views/web/img/media/<?php echo $post[0]['media_url'] ?>" alt="post-media" /> <?php } ?>
                        <div class="post_description_title">
                            <p>
                                <?php if ($post[0]['description']) echo $post[0]['description'] ?>
                            </p>
                        </div>
                    </div>
                    <div class="post-date-area">
                        <span><?php echo date_format(new DateTime($post[0]['datetime']), 'j D M Y') ?></span>
                    </div>
                    <div class="votes_comments_area">
                        <div class="icons" id="<?php echo $post[0]['post_id'] ?>">
                            <?php
                            echo '<script type="text/javascript">sendUsrPostId(' . $post[0]['post_id'] . ');</script>';
                            ?>
                            <img class="upvote_button vote_icon_size upvote_default" src="https://i.imgur.com/cJ150o7.png" alt="upvote button" onclick="ratePost(<?php echo $post[0]['post_id'] ?>,1)" />
                            <span class="votes_number purple_color total_upvotes"><?php echo $post[0]['up_votes'] ?></span>

                            <img class="downvote_button vote_icon_size downvote_default" src="https://i.imgur.com/f50DFkG.png" alt="downvote button" onclick="ratePost(<?php echo $post[0]['post_id'] ?>,0)" />
                            <span class="votes_number red_color total_downvotes"><?php echo $post[0]['down_votes'] ?></span>
                        </div>
                        <div class="comment_counts">
                            <i class="far fa-comment-alt"></i>
                            <?php if ($post[0]['total_comments'] == 0) { ?>
                                <span>No comments yet</span>
                            <?php } else if (($post[0]['total_comments'] == 1)) { ?>
                                <span><?php echo $post[0]['total_comments']; ?> comment</span>
                            <?php } else { ?>
                                <span><?php echo $post[0]['total_comments']; ?> comments</span>
                            <?php } ?>
                        </div>
                    </div>
                    <!-- Post comment -->
                    <section id="comment-form-section">
                        <div class="row">
                            <div class="col justify-content-center m-3">
                                <form id="comment-form">
                                    <div class="my-2">
                                        <label for="exampleFormControlTextarea1" class="mb-1">Write a comment</label>
                                        <textarea class="form-control" id="comment-description" rows="3"></textarea>
                                    </div>
                                    <!-- <div class="my-2">
                                        <label for="exampleFormControlFile1">Upload image</label>
                                        <input type="file" class="form-control-file" id="imageupload">
                                    </div> -->
                                    <div class="my-2 d-flex justify-content-end">
                                        <button type="button" id="comment-submit" class="btn btn-success" onclick="submitNewComment(<?php echo $post_id ?>)">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </section>


                    <!-- Comment section -->
                    <?php foreach ($comments as $comment) { ?>
                        <div>
                            <div class="comment-row d-flex justify-content-left ml-3 mt-3">
                                <div class="px-3">
                                    <img src="views/web/img/avatars/<?php echo $comment['avatar']; ?>" alt="user-avatar" class="rounded-circle comment-avatar">
                                </div>
                                <div class="comment-post">
                                    <span class="comment-username"><?php echo $comment['username']; ?></span>
                                    <span class="comment-datetime"><?php echo date_format(new DateTime($comment['datetime']), 'j D M Y'); ?></span>
                                    <p class="mb-0"><?php echo $comment['description']; ?></p>
                                </div>
                            </div>
                        </div>
                    <?php }; ?>

                </div>
            </div>
        </div>
    </div>
    <!-- Post Content End -->
    <!-- Right menu : CATEGORY Info -->
    <div class="col col-lg-2 col-xs-12 content_right d-flex justify-content-center min-vh-100">

        <div id="show-post_category-section" class="m-3 text-center">
            <i class="<?php echo $category_info[0]['icon'] ?> mt-3"></i>
            <p id="category-name"><?php echo $category_info[0]['category_name'] ?></p>
            <p id="category-members"><strong><?php echo $followers[0]['total'] ?></strong> <span>Members</span></p>
            </hr>
            <p id="category-description"><?php echo $category_info[0]['description'] ?></p>

            <!-- Follow category button. Depending on whether the user is a follower of the category or not-->
            <?php if ((int)$category[0]['total'] > 0) { ?>
                <button type="button" class="btn btn-leave" onclick="leaveCategoryOnShowPostPage('<?php echo $category_info[0]['category_name'] ?>','<?php echo $post_id ?>')">Leave Category</button>
            <?php } else { ?>
                <button type="button" class="btn btn-join" onclick="joinCategoryOnShowPostPage('<?php echo $category_info[0]['category_name'] ?>','<?php echo $post_id ?>')">Join Category</button>
            <?php } ?>


        </div>

    </div>

</div>