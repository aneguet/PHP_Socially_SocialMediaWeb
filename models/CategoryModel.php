<?php

require_once('UserModel.php');
class CategoryModel extends DbConn
{
    public $message = array(
        "id" => "",
        "text" => "",
    );

    public function getUserCategories($userId)
    {
        try {
            $result = false;
            $sql = 'SELECT c.category_name,c.icon FROM category c INNER JOIN `user_category` uc WHERE c.category_name = uc.category_name AND user_id = ?';
            $result = $this->selectQueryBind($sql, $userId);
            return $result;
        } catch (\PDOException $ex) {
            print($ex->getMessage());
        }
    }
    public function joinCategory($userId, $categoryName)
    {
        try {
            $result = false;
            $arr = [$userId, $categoryName];
            $sql = 'INSERT INTO user_category (`user_id`,category_name) VALUES (?,?)';
            $result = $this->executeQueryBindArr($sql, $arr);
            return $result;
        } catch (\PDOException $ex) {
            print($ex->getMessage());
        }
    }
    public function leaveCategory($userId, $categoryName)
    {
        try {
            $result = false;
            $arr = [$userId, $categoryName];
            $sql = 'DELETE FROM user_category WHERE `user_id`=? AND category_name=?';
            $result = $this->executeQueryBindArr($sql, $arr);
            return $result;
        } catch (\PDOException $ex) {
            print($ex->getMessage());
        }
    }
    public function getCategoryTotalPosts($categoryName)
    {
        try {
            $sql = 'SELECT COUNT(*) AS total FROM `post` WHERE category_name = ?';
            $result = $this->selectQueryBind($sql, $categoryName);
            return $result;
        } catch (\PDOException $ex) {
            print($ex->getMessage());
        }
    }
    public function loadCategories()
    {
        try {
            $sql = 'SELECT * FROM category ORDER BY category_name';
            $result = $this->selectquery($sql);
            return $result;
        } catch (\PDOException $ex) {
            print($ex->getMessage());
        }
    }
    public function loadCategoryById($categoryName)
    {
        try {
            $result = false;
            $sql = 'SELECT * FROM `category` WHERE category_name = ?';
            $result = $this->selectQueryBind($sql, $categoryName);
            return $result;
        } catch (\PDOException $ex) {
            print($ex->getMessage());
        }
    }
    public function getCategoryFollowers($categoryName)
    {
        try {
            $sql = 'SELECT COUNT(*) AS total FROM `user_category` WHERE category_name = ?';
            $result = $this->selectQueryBind($sql, $categoryName);
            return $result;
        } catch (\PDOException $ex) {
            print($ex->getMessage());
        }
    }
    public function isUserFollower($categoryName, $userId)
    {
        try {
            $sql = 'SELECT COUNT(*) as total FROM `user_category` WHERE category_name = ? AND `user_id`=?';
            $arr = [$categoryName, $userId];
            $result = $this->selectQueryBindArr($sql, $arr);
            return $result;
        } catch (\PDOException $ex) {
            print($ex->getMessage());
        }
    }
    public function registerUserCategories($userId, $categories)
    {
        try {
            $result = false;
            $this->dbConn->beginTransaction();
            for ($i = 0; $i < count($categories); $i++) {
                $arr = [$userId, $categories[$i]];
                $sql = 'INSERT INTO user_category (user_id,category_name) VALUES (?,?)';
                $result = $this->executeQueryBindArr($sql, $arr);
            }
            $this->dbConn->commit();
            return $result;
        } catch (\PDOException $ex) {
            print($ex->getMessage());
            $this->dbConn->rollBack();
        }
    }
}
