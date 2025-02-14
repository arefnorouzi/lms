<?php

namespace App\Repositories;

use App\Interfaces\ShippingInterface;
use App\Models\ShippingMethod;

class ShippingRepository extends CrudRepository implements ShippingInterface
{
    protected ShippingMethod $model;
    public function __construct(ShippingMethod $model)
    {
        $this->model = $model;
    }

    public function select_items()
    {
        return $this->model->where('status', 1)->get(['id', 'title', 'price']);
    }

    public function find_active_item(int $id)
    {
        return $this->model->where('status', 1)->findOrFail($id);
    }
}
