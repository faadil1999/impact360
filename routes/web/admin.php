<?php

use Illuminate\Support\Facades\Route;
use App\Enum\Space;


Route::middleware(['auth', Space::Admin->value])->name('admin.')->prefix('admin/')->group(function () {});
