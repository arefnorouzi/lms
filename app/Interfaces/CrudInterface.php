<?php

namespace App\Interfaces;

interface CrudInterface
{
    public function get_items(int $per_page);
    public function find_item(int $id);
    public function store_item(array $data);
    public function update_item(int $id, array $data);
    public function delete_item(int $id);
}
