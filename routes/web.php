<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [HomeController::class, 'home']);

Route::get('/hello', [WelcomeController::class, 'hello']);

Route::get('/world', function () {
    return 'world';
});

Route::get('/pesan', function () {
    return 'Selamat Datang di Website Saya';
});

Route::get('/about',[AboutController::class, 'about'] );

Route::get('/user/{name}', function ($name) {
    return 'Nama saya '.$name;
});

Route::get('/posts/{name}/comments/{comment}', function ($postId, $commentId) {
    return 'Pos ke-'.$postId.' komentar ke-'.$commentId;
});

Route::get('/articles/{id}',[ArticleController::class, 'article'] );

Route::get('/user/{name?}', function ($name= 'John') {
    return 'Nama saya '.$name;
});

Route::resource('photos', PhotoController::class);

Route::get('/greeting', [WelcomeController::class,'greeting']);

