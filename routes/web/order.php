<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Shop\UserOrderController;

/* start order */
Route::get('/order',[UserOrderController::class,'index'])
    ->name('order')->middleware('auth');
Route::get('/order/{uuid}',[UserOrderController::class,'show'])
    ->name('show_order')->middleware('auth');
Route::post('/order',[UserOrderController::class,'store'])
    ->name('generate_invoice')->middleware('auth');
Route::patch('/order/{order}',[UserOrderController::class,'update'])
    ->name('update_invoice')->middleware('auth');
Route::delete('/order/{order}',[UserOrderController::class,'destroy'])
    ->name('delete_order')->middleware('auth');
/* end order */
