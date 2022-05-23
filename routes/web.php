<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
})->middleware('guest')
->name('/');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('service', ServiceController::class);

Route::get('userServices', [ServiceController::class, 'userIndex'])->name('userServices.index');
Route::get('userServices/{service}', [ServiceController::class, 'userShow'])->name('userServices.show');
Route::delete('userServices/{service}', [ServiceController::class, 'userDestroy'])->name('userServices.destroy');

Route::post('order', [OrderController::class, 'create'])->name('order.create');

Route::get('Category/{id}', [CategoryController::class, 'index'])->name('category.index');

Route::get('City/{id}', [CityController::class, 'index'])->name('city.index');

Route::get('user', [UserController::class, 'index'])->name('user.index');
Route::get('user/password', [UserController::class, 'resetPasswordForm'])->name('user.resetPassword');
Route::post('user/reset-password', [UserController::class, 'resetPassword'])->name('resetPassword');
Route::post('user/updateImage', [UserController::class, 'updateImage'])->name('user.updateImage');
Route::patch('user/deleteImage/{user}', [UserController::class, 'deleteImage'])->name('user.deleteImage');
Route::delete('user/{user}', [UserController::class, 'destroy'])->name('user.destroy');
