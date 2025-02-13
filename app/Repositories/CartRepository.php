<?php

namespace App\Repositories;

use App\Interfaces\CartInterface;
use App\Models\Cart;
use Illuminate\Support\Str;

class CartRepository implements CartInterface
{
    protected Cart $model;
    public function __construct(Cart $cart){
        $this->model = $cart;
    }

    public function user_cart(int $user_id)
    {
        return $this->model->firstOrCreate(
            ['user_id' => $user_id],
            ['uuid' => Str::uuid()]
        );
    }

    public function add_to_cart(int $user_id, array $data = [])
    {
        return $this->user_cart($user_id)->cart_items()->create($data);
    }

    public function remove_from_cart(int $user_id, int $item_id)
    {
        return $this->user_cart($user_id)->cart_items()->where('id', $item_id)->delete();
    }

    public function increament_qty(int $user_id, int $item_id, $qty = 1)
    {
        return $this->user_cart($user_id)->cart_items()->where('id', $item_id)
            ->where('qty', '<', 1000)->increment('qty', $qty);
    }

    public function decreament_qty(int $user_id, int $item_id, $qty = 1)
    {
        return $this->user_cart($user_id)->cart_items()->where('id', $item_id)
            ->where('qty', '>', $qty)->decreament('qty', $qty);
    }
}
