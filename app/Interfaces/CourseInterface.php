<?php

namespace App\Interfaces;

interface CourseInterface extends CrudInterface
{
    public function product_courses(int $pid);
}
