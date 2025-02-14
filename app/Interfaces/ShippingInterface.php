<?php

namespace App\Interfaces;

interface ShippingInterface extends CrudInterface
{
    public function select_items();

    public function find_active_item(int $id);
}
