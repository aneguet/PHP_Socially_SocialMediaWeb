<?php

class CommentModel extends DbConn
{

    public function loadCommentsbyPostId($postId)
    {
        try {

            $result = false;
            $sql = 'SELECT c.comment_id, c.description, c.user_id, u.username, u.avatar, c.media_url, c.up_votes, c.down_votes, c.`datetime`
                FROM `comment` c 
                INNER JOIN post p ON c.post_id = p.post_id
                INNER JOIN `user` u ON u.user_id = c.user_id
                WHERE p.post_id = ? ORDER BY c.`datetime` DESC';
            $result = $this->selectQueryBind($sql, $postId);
            return $result;
        } catch (\PDOException $ex) {
            print($ex->getMessage());
        }
    }

    // $userId, $postId, $description, $mediaUrl
    public function newComment($userId, $postId, $description)
    {
        try {

            // media url is not binded yet
            $result = false;
            date_default_timezone_set("Europe/Copenhagen");
            $date = date('Y-m-d H:i:s');
            // $arr = [$userId, $postId, $description, $mediaUrl, 0, 0, $date];
            $arr = [$userId, $postId, $description, 0, 0, $date];
            $sql = 'INSERT INTO `comment` (`user_id`, post_id, `description`, up_votes, down_votes, `datetime`)
                VALUES (?,?,?,?,?,?)';
            $result = $this->executeQueryBindArr($sql, $arr);
            return $result;
        } catch (\PDOException $ex) {
            print($ex->getMessage());
        }
    }
}
