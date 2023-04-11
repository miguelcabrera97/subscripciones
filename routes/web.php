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


Route::get('/producto', function(){
    $stripe = new \Stripe\StripeClient(
        'sk_test_51LZk7pIouA9z8SYyfOAHSEm9opwyaipP01qRyhkiTnsw7Ue4a3GtNopuzDKyMzzrelXDmDEKcliXaSW0lI8f9euv00XJ8VrToP'
    );
    $producto=$stripe->products->create([
        'name' => 'Tienda Basica',
        'description' => 'Sitio de Conectaply',
    ]);

    return $producto;
});

Route::get('/precio', function(){
    $stripe = new \Stripe\StripeClient(
        'sk_test_51LZk7pIouA9z8SYyfOAHSEm9opwyaipP01qRyhkiTnsw7Ue4a3GtNopuzDKyMzzrelXDmDEKcliXaSW0lI8f9euv00XJ8VrToP'
    );
    $precioAnual = $stripe->prices->create([
        'unit_amount' => 2500000,
        'currency' => 'mxn',
        'recurring' => ['interval' => 'year'],
        'product' => 'prod_NgvqFmvWAv6iDK',
      ]);
    $precioMensual = $stripe->prices->create([
        'unit_amount' => 300000,
        'currency' => 'mxn',
        'recurring' => ['interval' => 'month'],
        'product' => 'prod_NgvqFmvWAv6iDK',
      ]);
      return $precioMensual;
});
