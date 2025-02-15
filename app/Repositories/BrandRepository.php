<?php

namespace App\Repositories;

use App\Interfaces\BrandInterface;
use App\Models\Brand;

class BrandRepository extends CrudRepository implements BrandInterface
{
    protected Brand $model;
    public function __construct(Brand $model){
        $this->model = $model;
    }

    public function all_items(int $per_page = 20)
    {
        return $this->model->withTrashed()->orderby('id', 'desc')
            ->paginate($per_page, ['id', 'name', 'slug', 'image', 'deleted_at']);
    }

    public function select_items()
    {
        return $this->model->get(['id', 'name']);
    }
}
