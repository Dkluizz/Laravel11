<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Category;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Home;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/',  [Home::class,'index'])->name('home');

Route::resource('users', UserController::class)->middleware('auth');

Route::resource('categories', CategoryController::class);

Route::resource('categories', CategoryController::class,['only'=>'create'])->middleware('auth');

Route::resource('products', ProductController::class,['only'=>['create','edit', 'destroy','store','update']])->Middleware('auth');

Route::resource('products', ProductController::class, ['only'=>'show']);

Route::resource('/cart', CartController::class,['except'=> ['edit', 'show']])->middleware('auth');

Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
