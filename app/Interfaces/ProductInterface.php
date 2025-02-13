<?php

namespace App\Interfaces;

interface ProductInterface extends CrudInterface
{
    public function all_items(int $per_page);

    public function recent_products(int $per_page);

    public function grouped_products(int $per_page, array $categories);
    public function categories_products(int $per_page, array $categories);
    public function find_by_sku(string $sku);
    public function find_for_add_to_cart(int $product_id);

    public function related_products(int $category_id, int $product_id);
}
