<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Interfaces\CategoryInterface;
use App\Interfaces\ProductInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ShopController extends Controller
{
    protected ProductInterface $productRepository;
    protected CategoryInterface $categoryRepository;
    public function __construct(ProductInterface $productRepository, CategoryInterface $categoryRepository){
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        try{
            $products = $this->productRepository->recent_products(per_page: 12);
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            $products = null;
        }
        $today = today()->format('Y-m-d');
        return view('shop.index', compact('products', 'today'));
    }

    public function shop_category(string $slug)
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
            $products = $this->productRepository->categories_products(categories: $category_ids);
        }
        catch (\Exception $e)
        {
            return redirect('/shop');
        }
        $today = today()->format('Y-m-d');
        return view('shop.category', compact('products', 'category', 'today'));
    }

    public function show(string $sku)
    {
        $sku = trim($sku);

        try {
            $product = $this->productRepository->find_by_sku(sku: $sku);
        }
        catch (\Exception $e)
        {
            return redirect('/shop');
        }
        $product->load(['category:id,name,slug', 'properties']);
        $today =today()->format('Y-m-d');
        try {
            $related_products = $this->productRepository->related_products($product->category_id, $product->id);
        }
        catch (\Exception $e)
        {
            $related_products = [];
        }
        return view('shop.product', compact('product', 'today', 'related_products'));
    }
}
