<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

// - get/view only shortened
// Route::view('/', 'posts.index')->name('home');

// - get/view only common
// Route::get('/', function() {
//     return view('posts.index');
// })->name('home');
Route::redirect('/', 'posts')->name('home');
Route::resource('posts', PostController::class);
Route::get('/{user}/posts', [DashboardController::class, 'userPosts'])->name('posts.user'); 

// - only accessable if authenticated
Route::middleware('auth')->group(function() {
    // - dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
    
    // - logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// - accessible if guest
Route::middleware('guest')->group(function() {
    // - login
    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // - registration
    // Route::post('/register', 'AuthController@register'); // shortened
    Route::view('/register', 'auth.register')->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});
