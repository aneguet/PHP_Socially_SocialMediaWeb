<?php

class PostModel extends DbConn
{

  public function loadUserFeedPostsFiltered($userId, $filter)
  {
    // Filter: latest, popular, oldest, unpopular

    $sql = "";
    switch ($filter) {
        // Most recent posts
      case "latest":
        $sql = 'SELECT u.user_id,u.username,u.avatar, p.*, c.icon FROM user u, post p, category c WHERE u.user_id = p.user_id AND p.category_name = c.category_name AND p.category_name IN (SELECT category_name FROM user_category WHERE `user_id` = ?) ORDER BY `datetime` DESC';
        break;
        // Oldest posts
      case "oldest":
        $sql = 'SELECT u.user_id,u.username,u.avatar, p.*, c.icon FROM user u, post p, category c WHERE u.user_id = p.user_id AND p.category_name = c.category_name AND p.category_name IN (SELECT category_name FROM user_category WHERE `user_id` = ?) ORDER BY `datetime`';
        break;
        // Most voted posts
      case "popular":
        $sql = 'SELECT u.user_id,u.username,u.avatar, p.*, c.icon FROM user u, post p, category c WHERE u.user_id = p.user_id AND p.category_name = c.category_name AND p.category_name IN (SELECT category_name FROM user_category WHERE `user_id` = ?) ORDER BY p.up_votes DESC';
        break;
        // Most unvoted posts
      case "unpopular":
        $sql = 'SELECT u.user_id,u.username,u.avatar, p.*, c.icon FROM user u, post p, category c WHERE u.user_id = p.user_id AND p.category_name = c.category_name AND p.category_name IN (SELECT category_name FROM user_category WHERE `user_id` = ?) ORDER BY p.down_votes DESC';
        break;
    }
    $result = $this->selectQueryBind($sql, $userId);
    return $result;
  }
  public function loadPopularFeedPostsFiltered($filter)
  {
    // Filter: latest, popular, oldest, unpopular

    $sql = "";
    switch ($filter) {
        // Most recent posts
      case "latest":
        $sql = 'SELECT u.user_id,u.username,u.avatar, p.*, c.icon FROM user u, post p, category c WHERE u.user_id = p.user_id AND p.category_name = c.category_name ORDER BY `datetime` DESC';
        break;
        // Oldest posts
      case "oldest":
        $sql = 'SELECT u.user_id,u.username,u.avatar, p.*, c.icon FROM user u, post p, category c WHERE u.user_id = p.user_id AND p.category_name = c.category_name ORDER BY `datetime`';
        break;
        // Most voted posts
      case "popular":
        $sql = 'SELECT u.user_id,u.username,u.avatar, p.*, c.icon FROM user u, post p, category c WHERE u.user_id = p.user_id AND p.category_name = c.category_name ORDER BY p.up_votes DESC';
        break;
        // Most unvoted posts
      case "unpopular":
        $sql = 'SELECT u.user_id,u.username,u.avatar, p.*, c.icon FROM user u, post p, category c WHERE u.user_id = p.user_id AND p.category_name = c.category_name ORDER BY p.down_votes DESC';
        break;
    }
    $result = $this->selectQuery($sql);
    return $result;
  }

  public function loadPostById($postId)
  {
    $sql = 'SELECT u.user_id,u.username,u.avatar,u.rank, p.*, c.icon FROM user u,post p,category c WHERE u.user_id = p.user_id AND p.category_name = c.category_name AND p.post_id = ?';
    $result = $this->selectQueryBind($sql, $postId);
    return $result;
  }
  public function loadCategoryPosts($categoryName)
  {
    $sql = 'SELECT u.user_id,u.username,u.avatar, p.*, c.icon FROM user u, post p, category c WHERE u.user_id = p.user_id AND p.category_name = c.category_name AND c.category_name = ? ORDER BY `datetime` DESC';
    $result = $this->selectQueryBind($sql, $categoryName);
    return $result;
  }
  public function loadCategoryPostsFiltered($categoryName, $filter)
  {
    // Filter: latest, popular, oldest, unpopular
    $sql = "";
    switch ($filter) {
        // Most recent posts
      case "latest":
        $sql = 'SELECT u.user_id,u.username,u.avatar, p.*, c.icon FROM user u, post p, category c WHERE u.user_id = p.user_id AND p.category_name = c.category_name AND c.category_name = ? ORDER BY `datetime` DESC';
        break;
        // Oldest posts
      case "oldest":
        $sql = 'SELECT u.user_id,u.username,u.avatar, p.*, c.icon FROM user u, post p, category c WHERE u.user_id = p.user_id AND p.category_name = c.category_name AND c.category_name = ? ORDER BY `datetime`';
        break;
        // Most voted posts
      case "popular":
        $sql = 'SELECT u.user_id,u.username,u.avatar, p.*, c.icon FROM user u, post p, category c WHERE u.user_id = p.user_id AND p.category_name = c.category_name AND c.category_name = ? ORDER BY p.up_votes DESC';
        break;
        // Most unvoted posts
      case "unpopular":
        $sql = 'SELECT u.user_id,u.username,u.avatar, p.*, c.icon FROM user u, post p, category c WHERE u.user_id = p.user_id AND p.category_name = c.category_name AND c.category_name = ? ORDER BY p.down_votes DESC';
        break;
    }
    $result = $this->selectQueryBind($sql, $categoryName);
    return $result;
  }

  public function newPost($userId, $title, $categoryName, $mediaUrl, $description)
  {
    date_default_timezone_set("Europe/Copenhagen");
    $date = date('Y-m-d H:i:s');
    if (!$description && $mediaUrl) {
      $sql = 'INSERT INTO post (`user_id`, title, category_name, media_url, `description`, `datetime`)
      VALUES ( ?, ?, ?, ?, null, ?)';
      $arr = [$userId, $title, $categoryName, $mediaUrl, $date];
    } else if ($description && !$mediaUrl) {
      $sql = 'INSERT INTO post (`user_id`, title, category_name, media_url, `description`, `datetime`)
      VALUES ( ?, ?, ?, null, ?, ?)';
      $arr = [$userId, $title, $categoryName, $description, $date];
    } else {
      $sql = 'INSERT INTO post (`user_id`, title, category_name, media_url, `description`, `datetime`)
            VALUES ( ?, ?, ?, ?, ?, ?)';
      $arr = [$userId, $title, $categoryName, $mediaUrl, $description, $date];
    }
    $result = $this->executeQueryBindArr($sql, $arr);
    return $result;
  }
}
