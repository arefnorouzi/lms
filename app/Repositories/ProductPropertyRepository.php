<?php

namespace App\Repositories;

use App\Interfaces\ProductPropertyInterface;
use App\Models\ProductProperty;

class ProductPropertyRepository implements ProductPropertyInterface
{
    protected ProductProperty $model;
    public function __construct(ProductProperty $model){
        $this->model = $model;
    }

    public function product_items(int $product_id)
    {
        return $this->model->where('product_id', $product_id)->get();
    }

    public function store_item(array $data)
    {
        return $this->model->create($data);
    }

    public function delete_item(int $id)
    {
        return $this->model->where('id', $id)->forceDelete();
    }
}
