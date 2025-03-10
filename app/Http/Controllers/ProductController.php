<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Interfaces\BrandInterface;
use App\Interfaces\CategoryInterface;
use App\Interfaces\ProductInterface;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    protected CategoryInterface $categoryRepository;
    protected BrandInterface $brandRepository;
    protected ProductInterface $productRepository;
    public function __construct(
        CategoryInterface $categoryRepository,
        ProductInterface $productRepository,
        BrandInterface $brandRepository
    ){
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
        $this->brandRepository = $brandRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $model = $this->productRepository->all_items(per_page: 20);
        }
        catch (\Exception $e){
            Log::error($e->getMessage());
            $model = null;
        }
        return view('admin.product.index', compact('model'));
    }

    public function search()
    {
        if(isset($_GET['search']))
        {
            $search_text = $_GET['search'];
            try{
                $model = $this->productRepository->search_items($search_text, 30);
            }
            catch(\Exception $e){
                Log::error($e->getMessage());
                return response()->json(status: 400);
            }
            return response()->json(data: $model);
        }
        return response()->json(status: 400);
    }

    public function add_sales(Product $product): object
    {
        $product->sales += 1;
        $product->update();
        return response()->json(status: 201);
    }

    public function add_rate(Product $product): object
    {
        $product->ratings()->create([
            'rating' => rand(4, 5),
            'user_id' => User::factory()->create()->id
        ]);
        return response()->json(status: 201);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $categories = $this->categoryRepository->select_items();
            $brands = $this->brandRepository->select_items();
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            $categories = [];
            $brands = [];
        }

        return view('admin.product.create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request): object
    {
        $request = $request->validated();
        $image = null;
        if (isset($request['image'])) {
            $image = $request['image'];
            $request['image'] = null;
        }
        try {
            $model = $this->productRepository->store_item($request);
            if($image)
            {
                $name = $request['category_id'] . '-' . time(). '.' . strtolower($image->getClientOriginalExtension());
                // Upload image
                $file_path = $image->storeAs('products', $name, 'product');
                $model->image = '/uploads/' . $file_path;
                $model->thumbnail = '/uploads/' . $file_path;
                $model->update();
            }
            session()->flash('message', 'رکورد با موفقیت ثبت شد');

            return redirect()->route('admin.product.show', $model->id);
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
    public function show(Product $product)
    {
        $product->load(['category', 'properties']);
        return view('admin.product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        try {
            $categories = $this->categoryRepository->select_items();
            $brands = $this->brandRepository->select_items();
        }
        catch (\Exception $e)
        {
            Log::error($e->getMessage());
            $categories = [];
            $brands = [];
        }


        return view('admin.product.edit',
            compact('product', 'categories', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product): object
    {
        $request = $request->validated();
        $image = null;
        if (isset($request['image'])) {
            $image = $request['image'];
            $request['image'] = $product->image;
        }
        try {
            $this->productRepository->update_item($product->id, $request);
            $product = $product->fresh();
            if($image)
            {
                $name = $request['category_id'] . '-' . time(). '.' . strtolower($image->getClientOriginalExtension());
                // Upload image
                $file_path = $image->storeAs('products', $name, 'product');
                $product->image = '/uploads/' . $file_path;
                $product->thumbnail = '/uploads/' . $file_path;
                $product->update();
            }

            session()->flash('message', 'رکورد با موفقیت بروزرسانی شد');
            return redirect()->route('admin.product.show', $product->id);
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
    public function destroy(Product $product): object
    {
        try {
            $product->update(['status' => 0]);
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
    public function restore(Product $product): object
    {
        try {
            $product->update(['status' => 1]);
            return response()->json(status: 204);
        }
        catch (\Exception $e)
        {
            return response()->json(['error' => $e->getMessage()], status: 400);
        }
    }
}
