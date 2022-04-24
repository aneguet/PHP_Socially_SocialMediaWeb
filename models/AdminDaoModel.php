<?php

class AdminDaoModel extends DbConn
{


    function isUserAdmin($userId)
    {
        $sql = 'SELECT role_name from user where `user_id` = ?';
        $result = $this->selectQueryBind($sql, $userId);
        if ($result[0]['role_name'] == "Admin") {
            return true;
        } else {
            return false;
        }
    }

    function getUsersData()
    {
        $sql = 'SELECT `user_id`, username, email, `rank`, role_name, banned from user';
        $result = $this->selectQuery($sql);
        return $result;
    }

    function deleteUser($userId)
    {
        $tableParam = 'user';
        $fieldParam = 'user_id';
        if ($this->checkIdExists($tableParam, $fieldParam, $userId)) {
            $sql = 'DELETE FROM user where `user_id` = ?';
            $result = $this->executeQueryBind($sql, $userId);
        } else {
            $result = false;
        }
        return $result;
    }

    function banUser($userId, $newStatus)
    {
        $tableParam = 'user';
        $fieldParam = 'user_id';
        if ($this->checkIdExists($tableParam, $fieldParam, $userId)) {
            $sql = 'UPDATE user SET banned = ? where `user_id` = ?';
            $arr = [$newStatus, $userId];
            $result = $this->executeQueryBindArr($sql, $arr);
        } else {
            $result = false;
        }
        return $result;
    }

    function getPostsData()
    {
        $sql = 'SELECT u.username, p.post_id, p.title,p.up_votes,p.down_votes, p.category_name, p.total_comments 
                FROM user u, post p, category c 
                WHERE u.user_id = p.user_id 
                AND p.category_name = c.category_name';
        $result = $this->selectQuery($sql);
        return $result;
    }

    function deletePost($postId)
    {
        $tableParam = 'post';
        $fieldParam = 'post_id';
        if ($this->checkIdExists($tableParam, $fieldParam, $postId)) {
            $sql = 'DELETE FROM post where `post_id` = ?';
            $result = $this->executeQueryBind($sql, $postId);
        } else {
            $result = false;
        }
        return $result;
    }


    function getCommentsData()
    {
        $sql = 'SELECT c.comment_id, u.username, c.description, p.title, c.datetime 
                FROM comment c
                inner join post p on c.post_id = p.post_id
                inner join user u on u.user_id = c.user_id';
        $result = $this->selectQuery($sql);
        return $result;
    }

    function deleteComment($commentId)
    {
        $tableParam = 'comment';
        $fieldParam = 'comment_id';
        if ($this->checkIdExists($tableParam, $fieldParam, $commentId)) {
            $sql = 'DELETE FROM comment where `comment_id` = ?';
            $result = $this->executeQueryBind($sql, $commentId);
        } else {
            $result = false;
        }
        return $result;
    }
    function adminPostCategoriesChartData()
    {
        $arr = array();
        $sql = 'SELECT count(*) as total_posts, category_name FROM `post` GROUP by category_name';
        $result = $this->selectQuery($sql);
        $arr[] = $result;
        $sql = "SELECT date_format(registration_date, '%M') as Month,  count(user_id) as num_users
                from user
                group by date_format(registration_date, '%M')
                order by Month(registration_date)";
        $result = $this->selectQuery($sql);
        $arr[] = $result;
        return $arr;
    }
    function getAdminDashboardStats()
    {
        try {
            $result = false;
            $sql = 'SELECT * FROM V_AdminDashboard_stats';
            $result = $this->selectQuery($sql);
            return $result;
        } catch (\PDOException $ex) {
            print($ex->getMessage());
        }
    }
    function checkIdExists($tableParam, $fieldParam, $idParam)
    {
        $sql = "SELECT {$fieldParam} FROM {$tableParam} WHERE {$fieldParam} = ?";
        $result = $this->selectQueryBind($sql, $idParam);
        if (!$result) {
            $result = false;
        }
        return $result;
    }
}
