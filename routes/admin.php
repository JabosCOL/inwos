<?php

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('admin', [HomeController::class, 'index'])->name('admin.home');
Route::resource('admin/services', ServiceController::class)->names('admin.services');
Route::resource('admin/users', UserController::class)->except([
  'show', 'create'
])->names('admin.users');
