<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TopicsController;
use App\Http\Controllers\ClassroomsController;
use App\Http\Controllers\ClassroomsController1;


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
// Route::resource('/topics', TopicsController::class);


Route::get('/', function () {
    return view('welcome');
})->name('home');


