<?php

use App\Http\Controllers\DynamicFormController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;


Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/dynamicForm/{id}', [HomeController::class, 'show'])->name('show');
Route::put('/submitDynamicForm/{id}', [HomeController::class, 'save'])->name('saveDynamicForm');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::prefix('admin')->name('admin.')->group(function () {
    Route::namespace('Auth')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login']);
    });

    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [AdminAuthController::class, 'dashboard'])->name('dashboard');
        Route::resource('dynamicForms', DynamicFormController::class);
    });



    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

});

// require __DIR__.'/auth.php';
