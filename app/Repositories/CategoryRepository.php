<?php

namespace App\Repositories;

use App\Interfaces\CategoryInterface;
use App\Models\Category;

class CategoryRepository extends CrudRepository implements CategoryInterface
{
    protected Category $model;
    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    public function select_items()
    {
        return $this->model->where('parent_id', '=', null)->with(['children:id,name,parent_id'])
            ->get(['id', 'name', 'parent_id']);
    }

    public function home_categories()
    {
        return $this->model->home()->active()->get(['id', 'name', 'image', 'slug']);
    }

    public function category_by_slug(string $slug)
    {
         return $this->model->active()->where('slug', '=', $slug)->firstOrFail();
    }

    public function all_items(int $per_page = 20)
    {
        return $this->model->withTrashed()->orderby('id', 'desc')
            ->with(['parent:id,name,slug'])
            ->paginate($per_page, ['id', 'name', 'slug', 'home_page', 'image', 'parent_id', 'deleted_at']);
    }
}
