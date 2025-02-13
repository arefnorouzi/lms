<?php

namespace App\Interfaces;

interface CartInterface
{
    public function user_cart(int $user_id);

    public function add_to_cart(int $user_id, array $data);

    public function remove_from_cart(int $user_id, int $item_id);
}
