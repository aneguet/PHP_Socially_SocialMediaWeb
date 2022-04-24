<?php
// spl_autoload_register(function ($class) {
//     include "../models/" . $class . ".php";
// });

class CommentController
{
    public function loadCommentsbyPostId($postId)
    {
        $c = new CommentModel();
        $res = $c->loadCommentsbyPostId($postId);
        return $res;
    }
    // $userId, $postId, $description, $mediaUrl
    public function newComment($userId, $postId, $description)
    {
        $c = new CommentModel();
        $res = $c->newComment($userId, $postId, $description);
        return $res;
    }
}
