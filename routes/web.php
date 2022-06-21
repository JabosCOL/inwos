<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\MessageController;
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

Route::resource('service', ServiceController::class)->except(['index']);
Route::post('survey', [ServiceController::class, 'surveyCreate'])->name('survey.create');
Route::get('surveys', [ServiceController::class, 'surveyIndex'])->name('survey.index');

Route::get('userServices', [ServiceController::class, 'userIndex'])->name('userServices.index');
Route::get('userServices/{service}', [ServiceController::class, 'userShow'])->name('userServices.show');
Route::delete('userServices/{service}', [ServiceController::class, 'userDestroy'])->name('userServices.destroy');

Route::get('Category/{id}', [CategoryController::class, 'index'])->name('category.index');

Route::get('City/{id}', [CityController::class, 'index'])->name('city.index');

Route::get('user', [UserController::class, 'index'])->name('user.index');
Route::get('user/password', [UserController::class, 'resetPasswordForm'])->name('user.resetPassword');
Route::post('user/reset-password', [UserController::class, 'resetPassword'])->name('resetPassword');
Route::post('user/updateImage', [UserController::class, 'updateImage'])->name('user.updateImage');
Route::patch('user/deleteImage/{user}', [UserController::class, 'deleteImage'])->name('user.deleteImage');
Route::delete('user/{user}', [UserController::class, 'destroy'])->name('user.destroy');

Route::get('myOrders', [OrderController::class, 'index'])->name('order.index');
Route::post('order', [OrderController::class, 'create'])->name('order.create');
Route::post('notification/{type}', [OrderController::class, 'markAllAsRead'])->name('order.markAllAsRead');
Route::get('order/{order}/notification/{notification?}/service/{service?}', [OrderController::class, 'show'])->name('order.show');
Route::post('order/accept/{order}', [OrderController::class, 'accept'])->name('order.accept');
Route::post('order/finish/{order}', [OrderController::class, 'finish'])->name('order.finish');
Route::post('order/cancel/{order}', [OrderController::class, 'cancel'])->name('order.cancel');

Route::get('auth/user', function () {
    if (auth()->check()) {
        return response()->json([
            'authUser' => auth()->user()
        ]);

        return null;
    }
});
Route::get('chat/with/{user}', [ChatController::class, 'chatWith'])->name('chat.with');
Route::get('chat/{chat}', [ChatController::class, 'show'])->name('chat.show');
Route::get('chat/{chat}/get_users', [ChatController::class, 'getUsers'])->name('chat.getUsers');
Route::get('chat/{chat}/get_messages', [ChatController::class, 'getMessages'])->name('chat.getMessages');
Route::post('message/sent', [MessageController::class, 'sent'])->name('message.sent');
