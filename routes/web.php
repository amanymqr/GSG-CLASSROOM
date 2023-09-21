<?php

use App\Models\Classroom;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TopicsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClassworkController;
use App\Http\Controllers\ClassroomsController;
use App\Http\Controllers\JoinClassroomController;
use App\Http\Controllers\ClassroomPeopleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\PlansController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Middleware\ApplyUserPreferences;
use App\Models\Submission;
use DragonCode\Contracts\Cashier\Config\Payment;

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


Route::get('plans', [PlansController::class, 'index'])
    ->name('plans');


Route::middleware(['auth'])->group(function () {

    Route::get('subscriptions/{subscription}/pay', [PaymentsController::class, 'create'])
        ->name('checkout');

    Route::post('Subscriptions', [SubscriptionController::class, 'store'])
        ->name('subscriptions.store');

    Route::post('payments', [PaymentsController::class, 'store'])
        ->name('payments.store');

    Route::get('payments/success', [PaymentsController::class, 'seccess'])
        ->name('paymnets.seccess');

    Route::get('payments/cancel', [PaymentsController::class, 'cancel'])
        ->name('paymnets.cancel');


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
    Route::resource('classroom.classwork', ClassworkController::class);
    Route::get('/classroom/{classroom}/people', [ClassroomPeopleController::class, 'index'])
        ->name('classroom.people');
    Route::delete('/classroom/{classroom}/people', [ClassroomPeopleController::class, 'destroy'])
        ->name('classroom.people.destroy');
    Route::post('comments', [CommentController::class, 'store'])->name('comments.store');


    Route::post('classwork/{classwork}/submissions', [SubmissionController::class, 'store'])
        ->name('submissions.store');
    // ->middleware('can:create , APP\Model\classwork');


    Route::get('submissions/{submission}/file', [SubmissionController::class, 'file'])
        ->name('submissions.file');
});
