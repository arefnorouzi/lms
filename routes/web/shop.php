<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Shop\ShopController;
use App\Http\Controllers\Shop\ProductCommentController;


Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::post('/shop/comment', [ProductCommentController::class, 'store_product_comment'])->name('product_comment');
Route::get('/shop/product/{sku}', [ShopController::class, 'show'])->name('show_product');
Route::get('/shop/category/{slug}', [ShopController::class, 'shop_category'])->name('shop_category');
