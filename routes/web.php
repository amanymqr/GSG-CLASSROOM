<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClassroomsController;


//ClassRooms Routs
Route::get('/classroom', [ClassroomsController::class, 'index'])->name('classroom.index');
Route::get('/classroom/create', [ClassroomsController::class, 'create'])->name('classroom.create');
Route::post('/classroom/store', [ClassroomsController::class, 'store'])->name('classroom.store');
Route::get('/classroom/show/{classroom}', [ClassroomsController::class, 'show'])
    ->name('classroom.show');
Route::get('/classroom/{classroom}/edit', [ClassroomsController::class, 'edit'])->name('classroom.edit');
Route::put('/classroom/{classroom}', [ClassroomsController::class, 'update'])->name('classroom.update');
Route::delete('/classroom/{classroom}', [ClassroomsController::class, 'destroy'])->name('classroom.destroy');




Route::get('/', function () {
    return view('welcome');
})->name('home');


