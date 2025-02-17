<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductPropertyController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ShippingMethodController;

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'is_admin']], function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin-dashboard');
    Route::resources([
        'category' => CategoryController::class,
        'brand' => BrandController::class,
        'product' => ProductController::class,
        'order' => OrderController::class,
        'user' => UserController::class,
        'shipping' => ShippingMethodController::class,
    ]);

    Route::get('/orders', [OrderController::class, 'archive'])->name('orders_archive');
    Route::post('/print-orders', [OrderController::class, 'print_orders'])
        ->name('orders_print');

    Route::post('/property', [ProductPropertyController::class, 'store'])
        ->name('product-property.store');
    Route::delete('/property/{id}', [ProductPropertyController::class, 'destroy'])
        ->name('product-property.destory');

    Route::post('/gallery', [GalleryController::class, 'store'])
        ->name('gallery.store');
    Route::delete('/gallery/{gallery}', [GalleryController::class, 'destroy'])
        ->name('gallery.destroy');

    Route::delete('/restore-category/{category}', [CategoryController::class, 'restore'])->withTrashed()
        ->name('restore-category');

    Route::delete('/restore-product/{product}', [ProductController::class, 'restore'])->withTrashed()
        ->name('restore-product');

    Route::delete('/restore-user/{user}', [UserController::class, 'restore'])->withTrashed()
        ->name('restore-user');
    Route::delete('/restore-brand/{brand}', [BrandController::class, 'restore'])->withTrashed()
        ->name('restore-brand');

});

