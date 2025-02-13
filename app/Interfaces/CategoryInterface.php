<?php

namespace App\Interfaces;

interface CategoryInterface extends CrudInterface
{
    public function select_items();
    public function home_categories();

    public function category_by_slug(string $slug);

    public function all_items(int $per_page);
}
