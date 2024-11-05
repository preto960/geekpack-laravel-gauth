<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Composer\InstalledVersions;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'template' => 'Theme1',
        'canAuth' => Auth::user(),
        'canSystemName' => 'geekosdev',
        'canPackage' => InstalledVersions::getInstalledPackages()
    ]);
})->name('home');