<?php

use App\Http\Controllers\DisplayController;
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

Route::get('/', function () {
    return view('home');
});

Route::view('/console', 'console');
Route::get('display', [DisplayController::class, 'DisplayPage']);
Route::get('pingDisplays', [DisplayController::class, 'Ping'])->name('pingDisplays');
Route::get('pongDisplays/{guid}', [DisplayController::class, 'Pong'])->name('pongDisplays');
Route::get('displayContent/{url}/{type}/{guid}', [DisplayController::class, 'DisplayContent'])->name('displayContent');

// Route::get('SendEvent', [DisplayController::class, 'SendEvent']);
