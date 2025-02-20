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
            'id', 'name', 'slug', 'sku', 'status', 'user_id', 'image', 'views',
                'published_at', 'updated_at', 'deleted_at'
        ]);
    }

    public function search_items(string $search_text, int $per_page = 10)
    {
        return $this->model->withTrashed()
            ->where('name', 'like', '%' . $search_text . '%')
            ->orWhere('sku', 'like', '%' . $search_text . '%')
            ->with(['user:id,name'])
            ->orderby('id', 'desc')->paginate($per_page, [
                'id', 'name', 'slug', 'sku', 'status', 'user_id', 'image', 'views',
                'published_at', 'updated_at', 'deleted_at'
            ]);
    }

    public function recent_posts(int $per_page = 12)
    {
        return $this->model->active()->orderby('id','desc')
            ->with(['category:id,name,slug', 'user:id,name,nick_name'])->paginate($per_page, [
                'id', 'name', 'sku', 'viws', 'thumbnail', 'image', 'subtitle', 'category_id', 'user_id'
            ]);
    }

    public function find_by_sku(string $sku)
    {
        return $this->model->active()->where('sku', '=', $sku)->firstOrFail();
    }

    public function categories_posts(int $per_page = 12, array $categories = [])
    {
        return $this->model->active()->whereIn('category_id', $categories)
            ->with(['category:id,name,slug', 'user:id,name,nick_name'])
            ->orderBy('id','desc')->paginate($per_page, [
                'id', 'name', 'sku', 'viws', 'thumbnail', 'image', 'subtitle', 'category_id', 'user_id'
            ]);
    }

    public function related_posts(int $category_id, int $post_id)
    {
        return $this->model->active()->where([['category_id', '=', $category_id], ['id', '!=', $post_id]])
            ->with(['category:id,name,slug', 'user:id,name,nick_name'])
            ->orderBy('id','desc')->take(4)->get([
                'id', 'name', 'sku', 'viws', 'thumbnail', 'image', 'subtitle', 'category_id', 'user_id'
            ]);
    }
}
