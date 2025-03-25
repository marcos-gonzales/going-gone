<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AuctionController;

Route::resource('/', AuctionController::class)->middleware("auth");

Route::get('dashboard', function () {
    return redirect('/');
})->middleware(['auth', 'verified'])->name('dashboard');


require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
