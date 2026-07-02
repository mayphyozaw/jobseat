<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\CandidateManage\CandidateController;
use App\Http\Controllers\Backend\CountryManage\CountryController;
use App\Http\Controllers\Backend\JobManage\JobPostController;
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

    Route::resource('countrymanage', CountryController::class);
    Route::get('country-datatable', [CountryController::class, 'countryDataTable'])->name('country-datatable');


    Route::resource('jobmanage', JobPostController::class);
    Route::get('job-datatable', [JobPostController::class, 'jobDataTable'])->name('job-datatable');

    Route::post('job-orders/{jobOrder}/toggle-link', [JobPostController::class, 'toggleLink'])->name('job-orders.toggle-link');
    Route::post('job-orders/{jobOrder}/regenerate-link', [JobPostController::class, 'regenerateLink'])->name('job-orders.regenerate-link');


    Route::resource('candidatemanage', CandidateController::class);
    Route::get('candidatemanage/{candidate}', [CandidateController::class, 'show'])
        ->name('candidatemanage.show');
    Route::get('candidate-datatable', [CandidateController::class, 'candidateDataTable'])->name('candidate-datatable');
    Route::get('candidates/export/csv', [CandidateController::class, 'exportCsv'])->name('candidates.export');
});

Route::get('admin/logout', [AdminController::class, 'adminLogout'])->name('admin-logout');
