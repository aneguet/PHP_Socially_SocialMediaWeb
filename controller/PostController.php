<?php
class PostController extends MediaController
{
    public $msg = array(
        "id" => "",
        "text" => "",
    );

    public function loadUserFeedPostsFiltered($userId, $filter)
    {
        $p = new PostModel();
        $res = $p->loadUserFeedPostsFiltered($userId, $filter);
        return $res;
    }
    public function loadPopularFeedPostsFiltered($filter)
    {
        $p = new PostModel();
        $res = $p->loadPopularFeedPostsFiltered($filter);
        return $res;
    }
    public function loadPostById($postId)
    {
        $p = new PostModel();
        $res = $p->loadPostById($postId);
        return $res;
    }

    public function loadCategoryPosts($categoryName)
    {
        $p = new PostModel();
        $res = $p->loadCategoryPosts($categoryName);
        return $res;
    }
    public function loadCategoryPostsFiltered($categoryName, $filter)
    {
        $p = new PostModel();
        $res = $p->loadCategoryPostsFiltered($categoryName, $filter);
        return $res;
    }

    public function newPost($userId, $title, $categoryName, $mediaUrl, $description)
    {
        $p = new PostModel();
        $res = $p->newPost($userId, $title, $categoryName, $mediaUrl, $description);
        return $res;
    }

    // Validation
    public function validateNewPostFields(&$title, $category, &$description, &$imageFile)
    {
        $dataIsValid = true;
        $title = htmlspecialchars(trim($_POST["title"]));
        $description = (trim($_POST["description"]));
        // Title
        if (empty($title)) {
            $this->msg["id"] = 'title';
            $this->msg["text"] = 'Title cannot be empty';
            $dataIsValid = false;
        } else if (strlen($title) < 4) {
            $this->msg["id"] = 'title';
            $this->msg["text"] = 'Title must have at least 4 characters';
            $dataIsValid = false;
        }
        // Category
        else if ($category == 'Category') {
            $this->msg["id"] = 'category';
            $this->msg["category"] = 'Category cannot be empty';
            $dataIsValid = false;
        }
        // Image
        else if (empty($imageFile) && empty($description)) {
            $this->msg["id"] = 'general';
            $this->msg["text"] = 'A post must have a description or an image.';
            $dataIsValid = false;
        }
        // Description
        else if (!empty($description)) {
            if (strlen($description) < 4) {
                $this->msg["id"] = 'description';
                $this->msg["text"] = 'Description must have at least 4 characters';
                $dataIsValid = false;
            } else if (mb_strlen($description, '8bit') > 15000) {
                $this->msg["id"] = 'description';
                $this->msg["text"] = 'Description is too long';
                $dataIsValid = false;
            }
        }

        // Image
        if (!empty($imageFile)) {
            if ($this->isImageTheSupportedType($imageFile['type'])) {
                //Image size bigger than 2MB
                if ($this->isImageBiggerThan2MB($imageFile['size'])) {
                    $this->msg["id"] = 'image';
                    $this->msg["text"] = 'Maximum image size is 2MB';
                    $dataIsValid = false;
                } else if ($this->getImageWidth($imageFile['tmp_name']) < 554) { // The image is too small
                    $this->msg["id"] = 'image';
                    $this->msg["text"] = 'Image is too small. Choose an image of a minimum width of 554px.';
                    $dataIsValid = false;
                } else if ($this->getImageWidth($imageFile['tmp_name']) > 1920 || $this->getImageHeight($imageFile['tmp_name']) > 1920) { // The image is too big in px
                    $this->msg["id"] = 'image';
                    $this->msg["text"] = "Image width or height can't be bigger than 1920px";
                    $dataIsValid = false;
                } else if ($this->getImageRatio($imageFile['tmp_name']) < 0.5) { // Image's height size is too big
                    $this->msg["id"] = 'image';
                    $this->msg["text"] = 'Image height is too big in relation to its width. (Accepted ratios: 0.5-3)';
                    $dataIsValid = false;
                } else if ($this->getImageRatio($imageFile['tmp_name']) > 3) { // Image's width size is too big
                    $this->msg["id"] = 'image';
                    $this->msg["text"] = 'Image width is too big in relation to its height. (Accepted ratios: 0.5-3)';
                    $dataIsValid = false;
                }
            } else {
                $this->msg["id"] = 'image';
                $this->msg["text"] = 'Only jpeg, jpg, png and gif images are allowed';
                $dataIsValid = false;
            }
        }
        return $dataIsValid;
    }
}
