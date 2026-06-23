<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\UserManagement\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


require __DIR__ . '/auth.php';

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('usermanage', UserController::class);
    Route::get('user-datatable', [UserController::class, 'userDataTable'])->name('user-datatable');
});

Route::get('admin/logout', [AdminController::class, 'adminLogout'])->name('admin-logout');
