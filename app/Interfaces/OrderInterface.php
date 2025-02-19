<?php

namespace App\Interfaces;

interface OrderInterface extends CrudInterface
{
    public function user_orders(int $user_id, int $per_page);
    public function user_order(int $user_id, string $uuid);
    public function all_items(int $per_page);
    public function search_items(string $search_text, int $per_page);
}
