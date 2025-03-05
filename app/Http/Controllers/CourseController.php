<?php

namespace App\Http\Controllers;

use App\Interfaces\CourseInterface;
use App\Interfaces\ProductInterface;
use App\Models\Course;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Log;

class CourseController extends Controller
{
    protected CourseInterface $courseRepository;
    protected ProductInterface $productRepository;

    public function __construct(CourseInterface $courseRepository, ProductInterface $productRepository)
    {
        $this->courseRepository = $courseRepository;
        $this->productRepository = $productRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $model = $this->courseRepository->get_items();
        }
        catch (\Exception $e)
        {
            $model = null;
        }
        return view('admin.course.index', compact('model'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pid = $_GET['pid'];
        if (!$pid)
        {
            return redirect()->route('admin.course.index');
        }
        try {
            $product = $this->productRepository->find_item(id: $pid);
        }
        catch (\Exception $e)
        {
            return redirect()->route('admin.course.index');
        }
        return view('admin.course.create', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request)
    {
        $request = $request->validated();
        try {
            $this->courseRepository->store_item($request);
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            return response()->json(['message' => $e->getMessage()], status: 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        try {
            $courses = $this->courseRepository->product_courses($course->product_id);
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            $courses = [];
        }
        return view('admin.course.show', compact('course', 'courses'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        $course->load('product');
        return view('admin.course.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        $request = $request->validated();
        try {
            $this->courseRepository->update_item($request, $course->id);
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            return response()->json(['message' => $e->getMessage()], status: 400);
        }
        return response()->json(['message' => 'یتم با موفقیت بروزرسانی شد'], status: 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        try {
            $course->delete();
        }
        catch (\Exception $e)
        {
            return response()->json(status: 404);
        }
        return response()->json(status: 204);

    }
}
