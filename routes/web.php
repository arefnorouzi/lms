<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;
//$user = \App\Models\User::first();
//    $order = array(
//        "user_id" => $user->id,
//        "amount" => rand(10, 100) * 10000,
//        "invoice_time" => now()
//    );
//
//    \App\Jobs\SendOrderNotification::dispatch(json_encode($order), $user->email)->delay(now()->addSeconds(20));
//
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about',[HomeController::class,'about'])->name('about');
Route::get('/terms',[HomeController::class,'terms'])->name('terms');
Route::get('/contact',[HomeController::class,'contact'])->name('contact');


Route::get('logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
require __DIR__.'/web/dashboard.php';
require __DIR__.'/web/shop.php';
require __DIR__.'/web/cart.php';
require __DIR__.'/web/order.php';
require __DIR__.'/web/zarinpal.php';
require __DIR__.'/web/admin.php';
