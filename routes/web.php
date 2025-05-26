<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PlatformController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\EnsureUserIsAdmin;



Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class,'showLoginForm'])->name('login');
    Route::get('/register', [AuthController::class,'showRegisterForm'])->name('register');
    Route::post('/login', [AuthController::class,'login']);
    Route::post('/register', [AuthController::class,'register']);

});

Route::middleware('auth')->group(function(){

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/', action: [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', action: [DashboardController::class, 'index']);
    
    Route::get('/profile', [UserController::class, 'edit'])->name('profile');
    Route::put('/profile', [UserController::class, 'update'])->name('profile.update');

    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');


});
Route::middleware(['auth'])->group(function () {
    Route::post('/platforms/toggle', [PlatformController::class, 'toggle'])->name('platforms.toggle');
    Route::get('/platforms', [PlatformController::class, 'index'])->name('platforms.index');

});
