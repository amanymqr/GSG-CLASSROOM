<?php

use App\Models\Classroom;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TopicsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClassroomsController;
use App\Http\Controllers\JoinClassroomController;

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


Route::get('/', function () {
    return view('welcome');
})->name('home');


require __DIR__ . '/auth.php';

Route::middleware(['auth'])->group(function () {

    //soft delete classroom
    Route::prefix('/classroom/trashed')
        ->as('classroom.')
        ->controller(ClassroomsController::class)
        ->group(function () {
            Route::get('/',  'trashed')->name('trashed');
            Route::put('/{classroom}',  'restore')->name('restore');
            Route::delete('/{classroom}',  'forceDelete')->name('force-delete');
        });

    //soft delete topic
    Route::prefix('/topics/trashed')
        ->as('topics.')
        ->controller(TopicsController::class)
        ->group(function () {
            Route::get('/',  'trashed')->name('trashed');
            Route::put('/{topics}',  'restore')->name('restore');
            Route::delete('/{topics}',  'forceDelete')->name('force-delete');
        });

    //join classroom
    Route::get('/classroom/{classroom}/join', [JoinClassroomController::class, 'create'])
        ->middleware('signed')
        ->name('classroom.join');
    Route::post('/classroom/{classroom}/join', [JoinClassroomController::class, 'store']);


    //resources

    Route::resources(['classroom' => ClassroomsController::class,]);
    Route::resources(['classroom.topics' => TopicsController::class,]);
});
