<?php

namespace App\Repositories;

use App\Interfaces\UserInterface;
use App\Models\User;

class UserRepository extends CrudRepository implements UserInterface
{
    protected User $model;
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function all_items(int $per_page = 10)
    {
        return $this->model->withTrashed()
            ->orderby('id', 'desc')
            ->paginate($per_page, [
                'id', 'mobile', 'name', 'created_at', 'deleted_at'
            ]);
    }

    public function search_items(string $search_text, int $per_page = 10)
    {
        return $this->model->withTrashed()
            ->where('name', 'like', '%' . $search_text . '%')
            ->orWhere('mobile', 'like', '%' . $search_text . '%')
            ->orderby('id', 'desc')->paginate($per_page, [
                'id', 'mobile', 'name', 'created_at', 'deleted_at'
            ]);
    }
}
