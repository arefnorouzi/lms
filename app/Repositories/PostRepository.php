<?php

namespace App\Repositories;

use App\Interfaces\PostInterface;
use App\Models\Post;

class PostRepository extends CrudRepository implements PostInterface
{
    protected Post $model;
    public function __construct(Post $model)
    {
        $this->model = $model;
    }

    public function all_items(int $per_page = 10)
    {
        return $this->model->withTrashed()->orderby('id', 'desc')
            ->with(['user:id,name'])
            ->paginate($per_page, [
            'id', 'name', 'slug', 'sku', 'status', 'user_id', 'image', 'published_at', 'updated_at', 'deleted_at'
        ]);
    }
}
