<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('tasks.index')
        : redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('dashboard', function () {
        return redirect()->route('tasks.index');
    })->name('dashboard');

    Route::resource('tasks', TaskController::class)->except(['show']);
});

require __DIR__.'/auth.php';
