<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Interfaces\CategoryInterface;
use App\Interfaces\PostInterface;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    protected PostInterface $postRepository;
    protected CategoryInterface $categoryRepository;
    public function __construct(PostInterface $postRepository, CategoryInterface $categoryRepository)
    {
        $this->postRepository = $postRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        try {
            $model = $this->postRepository->recent_posts(per_page: 12);
        }
        catch (\Exception $e)
        {
            $model = null;
        }
        return view('blog.index', compact('model'));
    }

    public function blog_category(string $slug)
    {
        $slug = trim($slug);
        $category_ids = [];
        try {
            $category = $this->categoryRepository->category_by_slug($slug);
            $category_ids[] = $category->id;
            $category->load('children');
            foreach ($category->children as $child){
                $category_ids[] = $child->id;
            }
            $model = $this->postRepository->categories_posts(categories: $category_ids);
        }
        catch (\Exception $e)
        {
            return redirect('/blog');
        }
        return view('blog.category', compact('model', 'category'));
    }

    public function show(string $sku)
    {
        $sku = trim($sku);

        try {
            $model = $this->postRepository->find_by_sku(sku: $sku);
        }
        catch (\Exception $e)
        {
            return redirect('/blog');
        }
        $model->load(['category:id,name,slug', 'user:id,name']);
        $model->load(['comments' => function ($query) {
            $query->orderby('id', 'desc')->where('status', 1)
                ->whereNull('parent_id')->with('replies')
                ->paginate(5);
        }]);
        try {
            $related_posts = $this->postRepository->related_posts($model->category_id, $model->id);
        }
        catch (\Exception $e)
        {
            $related_posts = [];
        }
        return view('blog.show', compact('model', 'related_posts'));
    }
}
