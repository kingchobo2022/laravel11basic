<?php

use App\Http\Controllers\LoginUserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterUserController;
use App\Models\Lists;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::middleware('auth')->group(function(){
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create'); // 글작성 폼    
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store'); // 글등록처리
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit'); // 글수정 폼
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update'); // 글수정처리
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy'); // 삭제처리
    Route::post('/logout', [LoginUserController::class, 'logout'])->name('logout');
});

Route::get('/posts', [PostController::class, 'index'])->name('posts.index'); // 글목록
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show'); // 글보기

Route::middleware('guest')->group(function(){
    Route::get('/register', [RegisterUserController::class, 'register'])->name('register');
    Route::post('/register', [RegisterUserController::class, 'store'])->name('register.store');
    Route::get('/login', [LoginUserController::class, 'login'])->name('login');
    Route::post('/login', [LoginUserController::class, 'store'])->name('login.store');
});





