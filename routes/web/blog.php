<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Blog\BlogController;


Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog/article/{sku}', [BlogController::class, 'show'])->name('show_article');
Route::get('/blog/category/{slug}', [BlogController::class, 'blog_category'])->name('blog_category');
