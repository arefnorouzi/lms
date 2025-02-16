<?php

namespace App\Interfaces;

interface CommentInterface extends CrudInterface
{
    public function product_comments(int $product_id);
    public function post_comments(int $post_id);

    public function user_open_comments_count(int $user_id);
}
