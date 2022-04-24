<?php

// Requires 

require_once('../bootstrapping.php');


// Declarations 

// File size 
define('KB', 1024);
define('MB', 1048576);
define('GB', 1073741824);
define('TB', 1099511627776);

$mediaPath = "../views/web/img/media/";
$avatarPath = "../views/web/img/avatars/";


//This handles the incoming data from AJAX - Post requests 
if (isset($_POST["option"])) {

    $option = $_POST["option"];

    switch ($option) {

        case "set_feed":
            $_SESSION['feed_page'] = $_POST["feedPage"];
            break;
        case "login":
            $username = $_POST["username"];
            $password = $_POST["password"];
            $c = new LoginController();
            // Data validation 
            if ($c->validateUsername($username) && $c->validatePassword($password)) {
                $result = $c->loginUser($username, $password);
                if ($result) echo json_encode($result); // We send the validation error message
            } else {
                echo json_encode($c->msg); // We send the validation error message
            }
            break;
        case "signup":
            global $newUserId;
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $password2 = $_POST['password2'];
            $avatar = generate_rnd_avatar();
            $c = new UserController();
            // Data validation 
            if ($c->validateSignUpFields($username, $email, $password, $password2)) {   // Validation OK
                // Password hashing
                $iterations = ['cost' => 12];
                $hashed_password = password_hash($password, PASSWORD_BCRYPT, $iterations);
                $result = $c->registerUser($username, $email, $hashed_password, $avatar);
                if (is_string($result)) {
                    $newUserId = $result;
                    $_SESSION['userId'] = $newUserId;
                }
                echo json_encode($result);
            } else {
                echo json_encode($c->msg);
            }
            break;
        case "new_post_form":
            $result = false;
            $userid = $_SESSION['userId'];
            $title = $_POST["title"];
            $category = $_POST["category"];
            $description = $_POST["description"];
            $imageFile = "";
            if (isset($_FILES['imgfile'])) $imageFile = $_FILES['imgfile'];
            $imgFileName = "";
            $p = new PostController();
            if ($p->validateNewPostFields($title, $category, $description, $imageFile)) {
                if (isset($_FILES['imgfile'])) { // Post with image
                    // We save the image
                    $isImageUploaded = $p->scaleImageToPostWidthAndSave($imageFile, $imgFileName);
                    if (!$isImageUploaded) {
                        $p->msg["id"] = 'general';
                        $p->msg["text"] = 'The image you chose could not be uploaded. Try again or choose another image.';
                        $result = $p->msg;
                    } else { // Image successfully uploaded
                        $result = $p->newPost($userid, $title, $category, $imgFileName, $description);
                    }
                } else { // Post with no image
                    $result = $p->newPost($userid, $title, $category, $imgFileName, $description);
                }
            } else { // validation errors
                $result = $p->msg;
            }

            echo json_encode($result); // We send query result
            break;

        case "profile_form":

            $email = $_POST['email'];
            $password = $_POST['password'];
            $password1 = $_POST['password1'];
            $password2 = $_POST['password2'];
            $u = new UserController();
            if ($u->validateUserProfile($email, $password, $password1, $password2)) {
                if ($email && !$password1) { // Update email
                    $u->setUser()->setUserEmail($email);
                    $result = true;
                } else if (!$email && $password1) { // Update password
                    // Password hashing
                    $iterations = ['cost' => 12];
                    $hashed_password = password_hash($password1, PASSWORD_BCRYPT, $iterations);
                    $u->setUser()->setUserPassword($hashed_password);
                    $result = true;
                } else if ($email && $password1) { // Update email and password
                    // Password hashing
                    $iterations = ['cost' => 12];
                    $hashed_password = password_hash($password1, PASSWORD_BCRYPT, $iterations);
                    $u->setUser()->setUserEmail($email);
                    $u->setUser()->setUserPassword($hashed_password);
                    $result = true;
                }
            } else { // validation errors
                $result = $u->msg;
            }
            echo json_encode($result);
            break;

        case "new_avatar_form":

            $imageFile = "";
            if (isset($_FILES['new-avatar-upload'])) $imageFile = $_FILES['new-avatar-upload'];
            $imgFileName = "";
            $u = new UserController();
            if ($u->validateNewAvatar($imageFile)) { // If image is ok we set it 
                // We save the image
                $isImageUploaded = $u->cropScaleAndSaveAvatar($imageFile, $imgFileName); // we scale it to 120px width
                if (!$isImageUploaded) {
                    $u->msg["id"] = 'general';
                    $u->msg["text"] = 'The image you chose could not be uploaded. Try again or choose another image.';
                    $result = $u->msg;
                } else { // Image successfully uploaded
                    $u->setUser()->setUserAvatar($imgFileName);
                    $result = true;
                }
            } else { // validation errors
                $result = $u->msg;
            }

            echo json_encode($result);

            break;



        case "feed":
            $userId = $_SESSION['userId'];
            $filter = $_POST["feedFilter"];
            $_SESSION['feed_dropdown'] = $filter;
            $p = new PostController();
            if ($_SESSION['feed_page'] == "userfeed") {
                $posts = $p->loadUserFeedPostsFiltered($userId, $filter);
            } else if ($_SESSION['feed_page'] == "popularfeed") {
                $posts = $p->loadPopularFeedPostsFiltered($filter);
            }

            if (isset($posts) && $posts) {
                // We retrieve user's votes on posts
                $v = new VoteController();
                $votes = $v->getUserRatedPosts($userId);
                $votes = formatVotesArray($votes);
                $posts_and_votes = array($posts, $votes);
                echo json_encode($posts_and_votes);
            } else {
                echo json_encode($posts);
            }
            break;
        case "specific_category":
            $_SESSION['category_name'] = $_POST['categoryName'];
            break;
        case "category_posts":
            $userId = $_SESSION['userId'];
            $filter = $_POST["categoryPostsFilter"];
            $_SESSION['categoryPosts_dropdown'] = $filter;
            $p = new PostController();
            $posts = $p->loadCategoryPostsFiltered($_SESSION['category_name'], $filter);
            if (isset($posts) && $posts) {
                // We retrieve user's votes on posts
                $v = new VoteController();
                $votes = $v->getUserRatedPosts($userId);
                $votes = formatVotesArray($votes);
                $posts_and_votes = array($posts, $votes);
                echo json_encode($posts_and_votes);
            } else {
                echo json_encode($posts);
            }
            break;
        case "rate_post":
            $userId = $_SESSION['userId'];
            $postId = $_POST["postId"];
            $isPositive = $_POST["isPositive"];
            $v = new VoteController();
            $v = $v->ratePost($userId, $postId, $isPositive);
            echo $v;
            break;
        case "user_votes":
            $userId = $_SESSION['userId'];
            $v = new VoteController();
            $v = $v->getUserRatedPosts($userId);
            echo json_encode($v);
            break;
        case "singlepost_user_votes":
            $userId = $_SESSION['userId'];
            $postId = $_POST["postId"];
            $v = new VoteController();
            $v = $v->getUserRatedPostByPostId($userId, $postId);
            echo json_encode($v);
            break;
        case "post_votes":
            $postId = $_POST["postId"];
            $v = new VoteController();
            $v = $v->getPostVotes($postId);
            echo json_encode($v);
            break;
        case "submit_post_comment":
            $formData = $_POST["formData"];
            if ($formData["formtype"]) {
                $form = $_POST["formtype"];
                $errors = [];
                $data = [];
                $postId = $_POST["postId"];
                $userId = $_SESSION['userId'];
                //&& empty($formData['image'])
                if (empty($formData['description'])) {
                    // 'or upload an image'
                    $errors['message'] = 'Type something to send a comment';
                } else {
                    // Message and image validation
                    $c = new CommentController();
                    //$userId, $postId, $formData['description'],$formData['image']
                    $result = $c->newComment($userId, $postId, $formData['description']);
                }

                if (!empty($errors)) {
                    $data['sucess'] = false;
                    $data['errors'] = $errors;
                } else {
                    $data['sucess'] = true;
                    $data['errors'] = 'Success';
                }
                echo json_encode($result);
            }
            break;
        case "category_selection":

            $userId = $_SESSION['userId'];
            $c = new CategoryController();
            if ($c->validateCategorySelection($_POST["categories"])) {
                $result = $c->registerUserCategories($userId, $_POST["categories"]);
                echo $result;
            } else {
                echo json_encode($c->msg); // We send the validation error message
            }

            break;
        case "join_category":

            $userId = $_SESSION['userId'];
            $categoryName = $_POST["categoryName"];
            $c = new CategoryController();
            $result = $c->joinCategory($userId, $categoryName);
            echo $result;

            break;
        case "leave_category":

            $userId = $_SESSION['userId'];
            $categoryName = $_POST["categoryName"];
            $c = new CategoryController();
            $result = $c->leaveCategory($userId, $categoryName);
            echo $result;

            break;
    }
}

// Validation functions

function generate_rnd_avatar()
{
    $rnd_number = rand(1, 8);
    $avatar = 'avatar_' . $rnd_number . '.png';
    return $avatar;
}

// We create an associative array (key=>value) for the user votes in each post
// $votes[post_id] = is_positive
// $votes["13"] = "0"/"1"
function formatVotesArray($data)
{
    $votes = array();
    foreach ($data as $vote) {
        $votes[$vote['post_id']] = $vote['is_positive'];
    }
    return  $votes;
}
