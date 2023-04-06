<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\BillingController;

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

Route::get('/', [ProductoController::class, 'index'])->name('home');

Route::get('/articles',[ArticleController::class, 'index'])->name('articles');


Route::get('/billing',[BillingController::class, 'index'])->middleware('auth') ->name('billing');
