<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\controllers\EmployeeController;

Route::get('/', function () {
    return view('dashboard');  // or 'home' — whichever you want as landing
})->middleware('auth');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('home');

Route::prefix('employees')->controller(EmployeeController::class)->group(function(){
    Route::get('/', 'index')->name('employees.index');
    Route::get('/{employee}','show')->name('employees.show');
});