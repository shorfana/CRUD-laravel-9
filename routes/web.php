<?php

use App\Http\Controllers\OuterController;
use App\Http\Controllers\UsersController;
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

// Route::get('/', function () {
//     return view('welcome',[
//         'title' => 'HOMEPAGE WElCOME KITA',
//         'description' => 'Ini adalah website deacourse-laravel project'
//     ]);
// });
//ini index homepage
Route::get('/', [OuterController::class, 'index']);

// ini users page & user validation
Route::controller(UsersController::class)->group(function () {
    Route::get('/login', 'login_form')->name('login_form');
    Route::post('/login','login_action')->name('login_action');

    Route::get('/dashboard', 'dashboard_index')->name('dashboard_index');
    Route::post('/logout', 'dashboard_logout')->name('dashboard_logout');
    Route::post('/article/delete','article_delete_action')->name('article_delete_action');
    Route::post('/article/add', 'article_add_action')->name('article_add_action');
    Route::get('/edit/{id}', 'edit_view')->name('edit_view');
    Route::post('/edit', 'edit_action')->name('edit_action');
    Route::get('/register','register_view')->name('register_view'); 
    Route::post('/register', 'register_action')->name('register_action');
});

Route::controller(OuterController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/article/{id}', 'article_detail')->name('article_detail');
});




