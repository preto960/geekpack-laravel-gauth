<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'template' => 'Theme1',
        'canAuth' => Auth::user(),
        'canSystemName' => 'geekosdev'
    ]);
})->name('home');