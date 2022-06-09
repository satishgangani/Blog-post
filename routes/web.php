<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Home & Filter Routes
Route::get('/', [HomeController::class,'index'])->name('home');
Route::get('/filter', [HomeController::class,'filter'])->name('home.filter');

Auth::routes();

//Post Routes
Route::group(['controller' => PostController::class, 'prefix' => 'post', 'as' => 'post.'], function(){
    //Post Routes no Auth
    Route::get('/view/{post}', 'index')->name('index');

    //Post Routes for Auth users
    Route::group(['middleware' => 'auth'], function(){
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{post}', 'edit')->name('edit');
        Route::put('update/{post}', 'update')->name('update');
        Route::delete('/destroy/{post}', 'destroy')->name('destroy');
    });
});

Route::group(['middleware' => 'auth'], function(){
    //Comments Route
    Route::post('comment/store', [CommentController::class,'store'])->name('comment.store');

    //Profile Routes
    Route::get('profile/edit', [ProfileController::class,'edit'])->name('profile.edit');
    Route::put('profile/update', [ProfileController::class,'update'])->name('profile.update');
});