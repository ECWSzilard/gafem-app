<?php

use Illuminate\Support\Facades\Route;

$controller = \App\Http\Controllers\CommunicationController::class;

Route::get('/order-data', [
    $controller,
    'orderData'
])->name('order-data');

Route::get('/products', [
    $controller,
    'products'
])->name('products');

Route::get('/ice-creams', [
    $controller,
    'iceCreams'
])->name('ice-creams');

Route::get('/servings', [
    $controller,
    'servings'
])->name('servings');

Route::get('/extra-options', [
    $controller,
    'extraOptions'
])->name('extra-options');


Route::get('/today', [
    $controller,
    'todayOrders'
])->name('today-orders');
