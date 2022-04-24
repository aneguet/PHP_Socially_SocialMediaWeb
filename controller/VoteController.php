<?php
spl_autoload_register(function ($class) {
    $file = __DIR__ . '/../models/' . $class . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

class VoteController
{

    public function ratePost($userId, $postId, $newVote)
    {
        $v = new VoteModel();
        $res = $v->ratePost($userId, $postId, $newVote);
        return $res;
    }
    public function isPostPreviouslyRated($userId, $postId)
    {
        $v = new VoteModel();
        $res = $v->isPostPreviouslyRated($userId, $postId);
        return $res;
    }
    public function isOldVotePositive($userId, $postId)
    {
        $v = new VoteModel();
        $res = $v->isOldVotePositive($userId, $postId);
        return $res;
    }
    public function getUserRatedPosts($userId)
    {
        $v = new VoteModel();
        $res = $v->getUserRatedPosts($userId);
        return $res;
    }
    public function getUserRatedPostByPostId($user_id, $post_id)
    {
        $v = new VoteModel();
        $res = $v->getUserRatedPostByPostId($user_id, $post_id);
        return $res;
    }
    public function getPostVotes($post_id)
    {
        $v = new VoteModel();
        $res = $v->getPostVotes($post_id);
        return $res;
    }
}
