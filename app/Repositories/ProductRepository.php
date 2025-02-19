<?php

namespace App\Repositories;

use App\Interfaces\ProductInterface;
use App\Models\Product;

class ProductRepository extends CrudRepository implements ProductInterface
{

    protected Product $model;
    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function search_items(string $search_text, int $per_page = 10)
    {
        return $this->model->withTrashed()
            ->where('name', 'like', '%' . $search_text . '%')
            ->orWhere('sku', 'like', '%' . $search_text . '%')
            ->orderby('id', 'desc')->paginate($per_page, [
                'id', 'name', 'sku', 'stock', 'price', 'offer_price', 'status', 'sales',
                'offer_end_date', 'thumbnail', 'deleted_at'
            ]);
    }

    public function find_active_product(int $id)
    {
        return $this->model->active()->findOrFail($id);
    }
    public function all_items(int $per_page = 10)
    {
        return $this->model->withTrashed()->orderby('id','desc')
            ->paginate($per_page, [
                'id', 'name', 'sku', 'stock', 'price', 'offer_price', 'status', 'sales',
                'offer_end_date', 'thumbnail', 'deleted_at'
            ]);
    }

    public function recent_products(int $per_page = 12)
    {
        return $this->model->active()->orderby('id','desc')
            ->with(['category:id,name,slug'])->paginate($per_page, [
                'id', 'name', 'sku', 'stock', 'price', 'thumbnail', 'image', 'subtitle', 'sales',
                'offer_price', 'offer_end_date', 'sessions', 'course_time', 'category_id'
            ]);
    }

    public function in_stock_products(int $per_page = 12)
    {
        return $this->model->active()->stock()->orderby('id','desc')
            ->with(['category:id,name,slug'])->paginate($per_page, [
                'id', 'name', 'sku', 'stock', 'price', 'thumbnail', 'category_id', 'subtitle', 'sales',
                'image', 'offer_price', 'offer_end_date', 'sessions', 'course_time'
            ]);
    }

    public function grouped_products(int $per_page = 12, array $categories = [])
    {
        return $this->model->active()->whereIn('category_id', $categories)
            ->with('category:id,name,slug')
            ->orderBy('id','desc')->get([
                'id', 'name', 'thumbnail', 'image', 'price', 'category_id','subtitle', 'sales',
                'sku', 'stock', 'offer_price', 'offer_end_date', 'sessions', 'course_time'
            ])->groupBy('category_id')
            ->map(function ($group) {
                return $group->take(8); // Get only 8 products per category
            });
    }

    public function categories_products(int $per_page = 12, array $categories = [])
    {
        return $this->model->active()->whereIn('category_id', $categories)
            ->with('category:id,name,slug')
            ->orderBy('id','desc')->paginate($per_page, [
                'id', 'name', 'thumbnail', 'image', 'price', 'category_id','subtitle', 'sales',
                'sku', 'stock', 'offer_price', 'offer_end_date', 'sessions', 'course_time'
            ]);
    }

    public function find_by_sku(string $sku)
    {
        return $this->model->active()->where('sku', '=', $sku)->firstOrFail();
    }

    public function find_for_add_to_cart(int $product_id)
    {
        return $this->model->active()->stock()->where('id', '=', $product_id)->firstOrFail();
    }

    public function related_products(int $category_id, int $product_id)
    {
        return $this->model->active()->where([['category_id', '=', $category_id], ['id', '!=', $product_id]])
            ->with('category:id,name,slug')
            ->orderby('id', 'desc')->take(4)->get([
                'id', 'name', 'thumbnail', 'image', 'price', 'category_id', 'subtitle', 'sales',
                'sku', 'stock', 'offer_price', 'offer_end_date', 'sessions', 'course_time'
            ]);
    }
}
