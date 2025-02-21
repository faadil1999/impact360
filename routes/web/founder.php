<?php

use Illuminate\Support\Facades\Route;
use App\Enum\Space;
use App\Http\Controllers\Organization\Management\FounderController;
use App\Http\Controllers\Organization\Management\UserController;

Route::post('founder/register', [FounderController::class, 'store'])->name('founder.register');

Route::middleware(['auth'])->name('founder.')->prefix('founder/')->group(function () {
    Route::get('/dashboard', [FounderController::class, 'index'])->name('dashboard');

    Route::prefix('users')->name('users.')->controller(UserController::class)->group(function () {
        Route::get('/', 'index')->name('index');
    });
});
