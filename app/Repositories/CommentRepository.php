<?php

namespace App\Repositories;

use App\Interfaces\CommentInterface;
use App\Models\Comment;

class CommentRepository extends CrudRepository implements CommentInterface
{
    protected Comment $model;
    public function __construct(Comment $model){
        $this->model = $model;
    }
    public function product_comments(int $product_id)
    {
        // TODO: Implement product_comments() method.
    }

    public function post_comments(int $post_id)
    {
        // TODO: Implement post_comments() method.
    }

    public function user_open_comments_count(int $user_id): int
    {
        return $this->model->where('user_id', $user_id)->andWhere('status', false)->count();
    }
}
