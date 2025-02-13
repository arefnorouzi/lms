<?php

namespace App\Interfaces;

interface ProductPropertyInterface
{

    public function product_items(int $product_id);

    public function store_item(array $data);

    public function delete_item(int $id);

}
