<?php

namespace App\Repositories;

use App\Interfaces\OrderInterface;
use App\Models\Order;

class OrderRepository extends CrudRepository implements OrderInterface
{
    protected Order $model;
    public function __construct(Order $model){
        $this->model = $model;
    }

    public function all_items(int $per_page = 10)
    {
        return $this->model->withTrashed()->orderby('id', 'desc')
            ->with(['user:id,name,mobile'])->paginate($per_page,[
                'id', 'amount', 'status', 'total', 'user_id', 'updated_at',
            ]);
    }

    public function search_items(string $search_text, int $per_page = 10)
    {
        return $this->model->withTrashed()
            ->where('customer_name', 'like', '%' . $search_text . '%')
            ->orWhere('customer_phone', 'like', '%' . $search_text . '%')
            ->orderby('id', 'desc')
            ->with(['user:id,name,mobile'])->paginate($per_page,[
                'id', 'amount', 'status', 'total', 'user_id', 'updated_at',
            ]);
    }

    public function user_orders(int $user_id, int $per_page = 10)
    {
        return $this->model->where('user_id', $user_id)->orderby('id', 'desc')->paginate($per_page, [
            'id', 'uuid', 'amount', 'total', 'status', 'updated_at'
        ]);
    }

    public function user_order(int $user_id, string $uuid)
    {
        return $this->model->where([['user_id', '=', $user_id], ['uuid', '=', $uuid]])->firstOrFail();
    }
}
