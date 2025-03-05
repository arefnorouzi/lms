<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductPropertyController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\ShippingMethodController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CourseController;

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'is_admin']], function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin-dashboard');
    Route::resources([
        'category' => CategoryController::class,
        'brand' => BrandController::class,
        'product' => ProductController::class,
        'order' => OrderController::class,
        'user' => UserController::class,
        'shipping' => ShippingMethodController::class,
        'post' => PostController::class,
        'course' => CourseController::class,
    ]);
    Route::post('/upload-image', [ImageUploadController::class, 'upload'])
        ->name('upload_image');

    Route::post('/product-sales/{product}', [ProductController::class, 'add_sales'])
        ->name('product_add_sales');

    Route::post('/product-rates/{product}', [ProductController::class, 'add_rate'])
        ->name('product_add_rate');

    /* Start Seach Routes */
    Route::get('/search-user', [UserController::class, 'search'])->name('search_users');
    Route::get('/search-product', [ProductController::class, 'search'])->name('search_products');
    Route::get('/search-order', [OrderController::class, 'search'])->name('search_orders');
    Route::get('/search-post', [PostController::class, 'search'])->name('search_posts');

    /* End of Seach Routes */

    Route::get('/orders', [OrderController::class, 'archive'])->name('orders_archive');
    Route::post('/print-orders', [OrderController::class, 'print_orders'])
        ->name('orders_print');

    Route::post('/property', [ProductPropertyController::class, 'store'])
        ->name('product-property.store');
    Route::delete('/property/{id}', [ProductPropertyController::class, 'destroy'])
        ->name('product-property.destory');

    Route::delete('/restore-category/{category}', [CategoryController::class, 'restore'])->withTrashed()
        ->name('restore-category');

    Route::delete('/restore-product/{product}', [ProductController::class, 'restore'])->withTrashed()
        ->name('restore-product');

    Route::delete('/restore-post/{post}', [PostController::class, 'restore'])->withTrashed()
        ->name('restore-post');

    Route::delete('/restore-user/{user}', [UserController::class, 'restore'])->withTrashed()
        ->name('restore-user');
    Route::delete('/restore-brand/{brand}', [BrandController::class, 'restore'])->withTrashed()
        ->name('restore-brand');

});

