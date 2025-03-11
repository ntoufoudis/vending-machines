<?php

use App\Livewire\Order;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/order', Order::class)->name('order');
