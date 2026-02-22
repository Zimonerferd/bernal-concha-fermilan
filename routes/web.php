<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PollController;

Route::get('/', function () {
    return view('home');
})->middleware('auth');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('home');

Route::resource('employees', EmployeeController::class);
Route::resource('polls', PollController::class)->except(['show']);
Route::get('polls/{poll}', [PollController::class, 'show'])->name('polls.show');
Route::post('polls/{poll}/vote', [PollController::class, 'vote'])->name('polls.vote');