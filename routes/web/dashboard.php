<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;


Route::group(['prefix' => 'dashboard', 'middleware' => ['auth']], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
});
