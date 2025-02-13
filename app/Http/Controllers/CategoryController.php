<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Interfaces\CategoryInterface;
use App\Models\Category;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    protected CategoryInterface $categoryRepository;
    public function __construct(CategoryInterface $categoryRepository){
        $this->categoryRepository = $categoryRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $model = $this->categoryRepository->all_items(per_page: 20);
        }
        catch (\Exception $e){
            Log::error($e->getMessage());
            $model = null;
        }
        return view('admin.category.index', compact('model'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $categories = $this->categoryRepository->select_items();
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            $categories = [];
        }
        return view('admin.category.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request): object
    {
        $request = $request->validated();
        $image = null;
        if (isset($request['image'])) {
            $image = $request['image'];
            $request['image'] = null;
        }
        try {
            $model = $this->categoryRepository->store_item($request);
            if($image)
            {
                $name = $request['slug'] . '-' . time(). '.' . strtolower($image->getClientOriginalExtension());
                // Upload image
                $file_path = $image->storeAs('categories', $name, 'product');
                $model->image = '/uploads/' . $file_path;
                $model->update();
            }
            session()->flash('message', 'رکورد با موفقیت ثبت شد');
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            session()->flash('error', $e->getMessage());
            return redirect()->back();
        }
        return redirect()->route('admin.category.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $category->load('children');
        return view('category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        try {
            $categories = $this->categoryRepository->select_items();
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            $categories = [];
        }
        return view('admin.category.edit', compact('category','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category): object
    {
        $request = $request->validated();
        Log::error($request);
        $image = null;
        if (isset($request['image'])) {
            $image = $request['image'];
            $request['image'] = $category->image;
        }
        try {
            $this->categoryRepository->update_item($category->id, $request);
            $category = $category->fresh();
            if($image)
            {
                $name = $category->id . '-' . time(). '.' . strtolower($image->getClientOriginalExtension());
                // Upload image
                $file_path = $image->storeAs('categories', $name, 'product');
                $category->image = '/uploads/' . $file_path;
                $category->update();
            }
            session()->flash('message', 'رکورد با موفقیت بروزرسانی شد');
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            session()->flash('error', $e->getMessage());
            return redirect()->back();
        }
        return redirect()->route('admin.category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): object
    {
        try {
            $category->delete();
            return response()->json(status: 204);
        }
        catch (\Exception $e)
        {
            return response()->json(['error' => $e->getMessage()], status: 400);
        }
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(Category $category): object
    {
        Log::info($category);
        try {
            $category->restore();
            return response()->json(status: 204);
        }
        catch (\Exception $e)
        {
            return response()->json(['error' => $e->getMessage()], status: 400);
        }
    }
}
