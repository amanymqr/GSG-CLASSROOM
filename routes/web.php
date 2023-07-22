<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TopicsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClassroomsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});




//ClassRooms Routs
// Route::get('/classroom', [ClassroomsController::class, 'index'])->name('classroom.index');
// Route::get('/classroom/create', [ClassroomsController::class, 'create'])->name('classroom.create');
// Route::post('/classroom/store', [ClassroomsController::class, 'store'])->name('classroom.store');
// Route::get('/classroom/show/{classroom}', [ClassroomsController::class, 'show'])
//     ->name('classroom.show');
// Route::get('/classroom/{classroom}/edit', [ClassroomsController::class, 'edit'])->name('classroom.edit');
// Route::put('/classroom/{classroom}', [ClassroomsController::class, 'update'])->name('classroom.update');
// Route::delete('/classroom/{classroom}', [ClassroomsController::class, 'destroy'])->name('classroom.destroy');

// Topics Routs
Route::resource('/classroom', ClassroomsController::class);
Route::resource('/topics', TopicsController::class);


//LoginController
Route::get('/login',[LoginController::class , 'create'])->name('login');
Route::post('/login',[LoginController::class , 'store']);


Route::get('/', function () {
    return view('welcome');
})->name('home');


require __DIR__.'/auth.php';
