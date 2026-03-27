<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MemberSpendingController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store']);
});

Route::post('/logout', [AuthController::class, 'destroy'])->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/members/list-spending', [MemberSpendingController::class, 'index'])->can('view-spending');;
    Route::get('/transaction', [TransactionController::class, 'create'])->can('create-transaction');;
    Route::post('/transaction/create', [TransactionController::class, 'store'])->can('create-transaction');;
});