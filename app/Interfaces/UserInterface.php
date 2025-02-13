<?php

namespace App\Interfaces;

interface UserInterface extends CrudInterface
{
    public function all_items(int $per_page);
}
