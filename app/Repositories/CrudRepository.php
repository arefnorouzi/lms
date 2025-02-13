<?php

namespace App\Repositories;

use App\Interfaces\CrudInterface;

class CrudRepository implements CrudInterface
{
    public function get_items(int $per_page = 10)
    {
        return $this->model->withTrashed()->orderby('id', 'desc')->paginate($per_page);
    }

    public function find_item(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function store_item(array $data)
    {
        return $this->model->create($data);
    }

    public function update_item(int $id, array $data)
    {
        return $this->find_item($id)->update($data);
    }

    public function delete_item(int $id)
    {
        return $this->find_item($id)->delete();
    }

    public function restore_item(int $id)
    {
        return $this->model->withTrashed()->findOrFail($id)->restore();

    }
}
