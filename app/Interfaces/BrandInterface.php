<?php

namespace App\Interfaces;

interface BrandInterface extends CrudInterface
{
    public function all_items(int $per_page);
}
