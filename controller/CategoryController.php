<?php


class CategoryController
{
    public $msg = array(
        "id" => "",
        "text" => "",
    );

    // Categories
    public function loadCategories()
    {
        $c = new CategoryModel();
        $res = $c->loadCategories();
        return $res;
    }
    public function getCategoryTotalPosts($categoryName)
    {
        $c = new CategoryModel();
        $res = $c->getCategoryTotalPosts($categoryName);
        return $res;
    }

    public function getUserCategories()
    {
        $userId = $_SESSION['userId'];
        $c = new CategoryModel();
        $res = $c->getUserCategories($userId);
        return $res;
    }
    public function loadCategoryById($categoryName)
    {
        $c = new CategoryModel();
        $res = $c->loadCategoryById($categoryName);
        return $res;
    }
    public function getCategoryFollowers($categoryName)
    {
        $c = new CategoryModel();
        $res = $c->getCategoryFollowers($categoryName);
        return $res;
    }
    public function isUserFollower($categoryName)
    {
        $userId = $_SESSION['userId'];
        $c = new CategoryModel();
        $res = $c->isUserFollower($categoryName, $userId);
        return $res;
    }
    public function registerUserCategories($userId, $categories)
    {
        $c = new CategoryModel();
        $res = $c->registerUserCategories($userId, $categories);
        return $res;
    }
    public function joinCategory($userId, $categoryName)
    {
        $c = new CategoryModel();
        $res = $c->joinCategory($userId, $categoryName);
        return $res;
    }
    public function leaveCategory($userId, $categoryName)
    {
        $c = new CategoryModel();
        $res = $c->leaveCategory($userId, $categoryName);
        return $res;
    }

    // Validation 
    public function validateCategorySelection($categories)
    {
        $isDataValid = true;
        // categories parameter is not null
        if ($categories != null) {
            if (sizeof($categories) < 2 || empty($categories)) {
                $this->msg["id"] = "categories";
                $this->msg["text"] = "You must select at least 2 categories in order to complete the registration.";
                $isDataValid = false;
            }
        } else { // No categories
            $this->msg["id"] = "categories";
            $this->msg["text"] = "You must select at least 2 categories in order to complete the registration.";
            $isDataValid = false;
        }
        return $isDataValid;
    }
}
