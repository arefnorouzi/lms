<?php

namespace App\Http\Controllers;

use App\Interfaces\CategoryInterface;
use App\Interfaces\ProductInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    protected ProductInterface $productRepository;
    protected CategoryInterface $categoryRepository;

    public function __construct(ProductInterface $productRepository, CategoryInterface $categoryRepository)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        $home_categories_ids = [];
        try {
            $products = $this->productRepository->recent_products(per_page: 12);
            $categories = $this->categoryRepository->home_categories();
            foreach ($categories as $category) {
                $home_categories_ids[] = $category->id;
            }
            $grouped_products = $this->productRepository->grouped_products(categories: $home_categories_ids);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $products = [];
            $categories = [];
            $grouped_products = [];
        }
        $today = today()->format('Y-m-d');

        return view('home', compact('products', 'categories', 'today', 'grouped_products'));

    }
}
