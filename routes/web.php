<?php

use Illuminate\Foundation\Application;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

Route::middleware('auth')->group(function () {

    Route::get('/movies', [MovieController::class, 'index'])->name('movies');
    Route::get('/movies/edit/{movie}',[MovieController::class,'edit']);
    Route::patch('/movies/{movie}',[MovieController::class,'update']);
    Route::get('/movies/create', [MovieController::class, 'create']);
    Route::post('/movies', [MovieController::class, 'store']);
    Route::get('/movies/{movie}', [MovieController::class, 'show']);
    Route::get('/movies/search/{searchKey}', [MovieController::class, 'search']);
    Route::post('/movies/toggle/{movie}', [MovieController::class, 'toggle']);
    Route::delete('/movies/{movie}',[MovieController::class, 'destroy']);
    Route::get('/movies/pdf/{movie}',[MovieController::class,'pdf']);
    Route::get('/movies/email/{movie}', [MovieController::class, 'email']);
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index')->middleware('role:admin');
    Route::post('/admin/email', [AdminController::class, 'sendEmailToAllMovies']);
});
