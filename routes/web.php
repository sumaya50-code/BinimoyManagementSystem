<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\SavingsController;
use App\Http\Controllers\LoanController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {
    Route::resource('roles', RoleController::class);



    Route::resource('products', ProductController::class);
    Route::get('members/data', [MemberController::class, 'getData'])->name('members.data');

    Route::resource('members', MemberController::class);
    Route::get('members/{member}/toggle-status', [MemberController::class, 'toggleStatus'])
        ->name('members.toggleStatus');
    Route::resource('savings', SavingsController::class);
    Route::get('/users-data', [UserController::class, 'getUsers'])->name('users.data');
    Route::resource('users', UserController::class);
    Route::get('savings-data', [SavingsController::class, 'getSavingsData'])->name('savings.data');
    Route::get('savings/approve/{id}', [SavingsController::class, 'approve'])
        ->name('savings.approve');

    Route::get('savings/interest/{member_id}', [SavingsController::class, 'calculateInterest'])
        ->name('savings.interest');

    Route::resource('loans', LoanController::class);
    Route::get('/loans-data', [LoanController::class, 'getData'])->name('loans.data');
});
