<?php

use Illuminate\Support\Facades\Route;
use App\Enum\Space;
use App\Http\Controllers\User\UserController;

Route::post('register', [UserController::class, 'store'])->name('member.register');
Route::middleware(['auth'])->name('member.')->prefix('member/')->group(function () {

    Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');
});
