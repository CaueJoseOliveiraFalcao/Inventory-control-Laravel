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
    Route::post('/alterQuantity' , [Controller::class , 'alterQuantity'])->name('alterQuantity');
});

Route::get('/reset' , [Controller::class, 'ShowReset'])->name('ShowReset');
Route::post('/sendResetCode' ,  [Controller::class, 'SendReset'])->name('SendReset');
Route::get('/confirmcode' , [Controller::class , 'ShowConfirmCode'])->name('confirmcode');
Route::post('/checkcode' , [Controller::class , 'CheckCode'])->name('CheckCode');
Route::get('/newpassword' , [Controller::class , 'ShowNewPassword'])->name('shonewpassword');
Route::post('/insertnewpassword' , [Controller::class , 'InsetNewPassword'])->name('insertnewpassword');