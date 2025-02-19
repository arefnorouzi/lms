<?php

namespace App\Interfaces;

interface PostInterface extends CrudInterface
{
    public function all_items(int $per_page);

    public function search_items(string $search_text, int $per_page);
}
