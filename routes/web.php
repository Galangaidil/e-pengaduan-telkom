<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function() {
    return Inertia::render('Home');
});

Route::middleware('auth')->group(function (){
    Route::resource('customers', \App\Http\Controllers\CustomerController::class);

    Route::resource('complaints', \App\Http\Controllers\ComplaintController::class);
    Route::put('complaints/{complaint}/updateStatus/', [\App\Http\Controllers\ComplaintController::class, 'updateStatus'])->name('complaints.updateStatus');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

});

Route::get('/laravel', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
