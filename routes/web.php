<?php

use App\Http\Controllers\AdminPostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\NewsletterController;
use App\Services\Newsletter;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/',[PostController::class,'index'])->name('home');
Route::get('/posts/{post:slug}',[PostController::class,'show'])->name('posts.show');
//Newsletter service
Route::post('/newsletter',NewsletterController::class);
//Register Routes
Route::get('/register',[RegisterController::class,'create'])->middleware('guest');
Route::post('/register',[RegisterController::class,'store'])->middleware('guest');
//User Login && logout Routes
Route::get('/login',[SessionController::class,'create'])->middleware('guest');
Route::post('/login',[SessionController::class,'store'])->middleware('guest');
Route::post('/logout',[SessionController::class,'destroy'])->middleware('auth');
//Comment store
Route::post('posts/{post:slug}/comments',[CommentController::class,'store'])->middleware('auth');
//Admin section
Route::middleware('can:admin')->group(function () {
    Route::get('admin/posts/create',[AdminPostController::class ,'create'])->middleware('admin');
    Route::post('admin/posts',[AdminPostController::class ,'store'])->middleware('admin');
    Route::get('admin/posts',[AdminPostController::class,'index'])->middleware('admin');
    Route::get('admin/posts/{post}',[AdminPostController::class ,'edit'])->middleware('admin');
    Route::patch('admin/posts/{post}',[AdminPostController::class,'update'])->middleware('admin');
    Route::delete('admin/posts/{post}',[AdminPostController::class ,'destroy'])->middleware('admin');
});
