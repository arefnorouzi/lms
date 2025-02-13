<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Shop\CartController;

/* start shopping cart */
Route::get('/cart',[CartController::class,'index'])
    ->name('cart')->middleware('auth');
Route::post('/cart/add',[CartController::class,'add'])
    ->name('add_to_cart')->middleware('auth');
Route::delete('/cart/remove',[CartController::class,'remove'])
    ->name('remove_from_cart')->middleware('auth');
/* end shopping cart */
