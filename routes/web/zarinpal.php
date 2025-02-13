<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Payment\ZarinpalController;
/* start Payment */
Route::get('/payment/zarinpal/pay/{order}',[ZarinpalController::class,'pay'])
    ->name('zarinpal_pay')->middleware('auth');
Route::get('/payment/zarinpal/callback',[ZarinpalController::class,'callback'])
    ->name('zarinpal_callabck');
/* end Payment */
