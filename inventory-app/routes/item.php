<?php

use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Route;

//Route::get('/dashboard' , [UserLogin::class , 'ShowDashboard'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::post('/additem' , [ItemController::class , 'addItemtoUser'])->name("additem");
    Route::get('/alterQuantity' , [ItemController::class , 'alterQuantity'])->name('alterQuantity');
    Route::get('/dashboard' , [ItemController::class , 'ShowDashboard'])->name('dashboard');
});

?>