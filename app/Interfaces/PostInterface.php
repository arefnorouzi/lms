<?php

namespace App\Interfaces;

interface PostInterface extends CrudInterface
{
    public function all_items(int $per_page);
}
