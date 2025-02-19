<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Interfaces\CategoryInterface;
use App\Interfaces\PostInterface;
use App\Models\Post;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    protected PostInterface $postRepository;
    protected CategoryInterface $categoryRepository;
    public function __construct(PostInterface $postRepository, CategoryInterface $categoryRepository)
    {
        $this->postRepository = $postRepository;
        $this->categoryRepository = $categoryRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $model = $this->postRepository->all_items(per_page: 12);
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            $model = null;
        }
        return view('admin.post.index', compact('model'));
    }

    public function search()
    {
        if(isset($_GET['search']))
        {
            $search_text = $_GET['search'];
            try{
                $model = $this->postRepository->search_items($search_text, 30);
            }
            catch(\Exception $e){
                Log::error($e->getMessage());
                return response()->json(status: 400);
            }
            return response()->json(data: $model);
        }
        return response()->json(status: 400);
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
        return view('admin.post.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $request = $request->validated();
        $image = null;
        if (isset($request['image'])) {
            $image = $request['image'];
            $request['image'] = null;
        }
        try {
            $model = $this->postRepository->store_item($request);
            if($image)
            {
                $name = $request['category_id'] . '-' . time(). '.' . strtolower($image->getClientOriginalExtension());
                // Upload image
                $file_path = $image->storeAs('posts', $name, 'product');
                $model->image = '/uploads/' . $file_path;
                $model->thumbnail = '/uploads/' . $file_path;
                $model->update();
            }
            session()->flash('message', 'رکورد با موفقیت ثبت شد');

            return redirect()->route('admin.post.show', $model->id);
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            session()->flash('error', $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post->load(['category', 'comments']);
        return view('admin.post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        try {
            $categories = $this->categoryRepository->select_items();
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            $categories = [];
        }
        return view('admin.post.create', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $request = $request->validated();
        $image = null;
        if (isset($request['image'])) {
            $image = $request['image'];
            $request['image'] = $post->image;
        }
        try {
            $this->postRepository->update_item($post->id, $request);
            $post = $post->fresh();
            if($image)
            {
                $name = $request['category_id'] . '-' . time(). '.' . strtolower($image->getClientOriginalExtension());
                // Upload image
                $file_path = $image->storeAs('posts', $name, 'product');
                $post->image = '/uploads/' . $file_path;
                $post->thumbnail = '/uploads/' . $file_path;
                $post->update();
            }

            session()->flash('message', 'رکورد با موفقیت بروزرسانی شد');
            return redirect()->route('admin.product.show', $post->id);
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            session()->flash('error', $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        try {
            $post->update(['status' => 0]);
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
    public function restore(Post $post): object
    {
        try {
            $post->update(['status' => 1]);
            return response()->json(status: 204);
        }
        catch (\Exception $e)
        {
            return response()->json(['error' => $e->getMessage()], status: 400);
        }
    }
}
