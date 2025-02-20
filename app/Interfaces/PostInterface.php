<?php

namespace App\Interfaces;

interface PostInterface extends CrudInterface
{
    public function all_items(int $per_page);

    public function recent_posts(int $per_page);
    public function search_items(string $search_text, int $per_page);

    public function find_by_sku(string $sku);
    public function related_posts(int $category_id, int $post_id);
    public function categories_posts(int $per_page, array $categories);
}
