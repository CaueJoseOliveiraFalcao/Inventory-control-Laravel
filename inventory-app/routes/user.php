<?php

use App\Http\Controllers\UserLogin;
use Illuminate\Support\Facades\Route;



Route::get('/' , [UserLogin::class, 'ShowLoginForm'])->name('login');
Route::get('/register' , [UserLogin::class , 'ShowRegisterForm'])->name('register');
Route::post('/register' , [UserLogin::class , 'sort'])->name('createUser');
Route::get('/login' , [UserLogin::class , 'ShowLoginForm'])->name('login.submit');
Route::post('/login' , [UserLogin::class , 'login'])->name('login.submit');

Route::middleware('auth')->group(function () {    
    Route::post('logout' , [UserLogin::class , 'logout'])->name("logout");
});

Route::get('/reset' , [UserLogin::class, 'ShowReset'])->name('ShowReset');
Route::post('/sendResetCode' ,  [UserLogin::class, 'SendReset'])->name('SendReset');
Route::get('/confirmcode' , [UserLogin::class , 'ShowConfirmCode'])->name('confirmcode');
Route::post('/checkcode' , [UserLogin::class , 'CheckCode'])->name('CheckCode');
Route::get('/newpassword' , [UserLogin::class , 'ShowNewPassword'])->name('shonewpassword');
Route::post('/insertnewpassword' , [UserLogin::class , 'InsetNewPassword'])->name('insertnewpassword');
?>