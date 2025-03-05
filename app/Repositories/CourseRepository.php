<?php

namespace App\Repositories;

use App\Interfaces\CourseInterface;
use App\Models\Course;

class CourseRepository extends CrudRepository implements CourseInterface
{
    protected Course $model;
    public function __construct(Course $model){
        $this->model = $model;
    }

    public function product_courses(int $pid)
    {
        return $this->model->where('product_id', '=', $pid)->get();
    }
}
