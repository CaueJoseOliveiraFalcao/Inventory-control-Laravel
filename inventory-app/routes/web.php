<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

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


Route::get('/' , [Controller::class, 'ShowLoginForm'])->name('login');
Route::get('/register' , [Controller::class , 'ShowRegisterForm'])->name('register');


Route::post('/register' , [Controller::class , 'sort'])->name('createUser');
Route::post('/login' , [Controller::class , 'login'])->name('login.submit');

Route::middleware(['web','auth'])->group(function () {
    Route::get('/dashboard' , [Controller::class , 'ShowDashboard'])->name('dashboard');
    Route::post('logout' , [Controller::class , 'logout'])->name("logout");
    Route::post('/additem' , [Controller::class , 'addItemtoUser'])->name("additem");
});