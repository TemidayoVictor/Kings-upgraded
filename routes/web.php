<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NavigationController;
use App\Livewire\Auth\Signup;
use App\Livewire\Auth\Login;
use App\Livewire\Admin\AdminDashboard;
use App\Livewire\Brand\BrandDashboard;
use App\Livewire\Client\ClientDashboard;
use App\Livewire\Dropshipper\DropshipperDashboard;
use App\Livewire\Auth\VerifyEmail;

// General Routes
Route::get('/home', [NavigationController::class, 'home'])->name('home');

Route::get('/signup', Signup::class)->name('signup');
Route::get('/login', Login::class)->name('login');

//Protected Routes
Route::middleware(['auth'])->group(function () {
        Route::get('/verify-email', VerifyEmail::class)->name('verify-email');
        Route::post('/logout', Login::class)->name('logout');
    }
);

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')
    ->group(function () {
        Route::get('/dashboard', AdminDashboard::class)->name('dashboard');
    }
);

// Brand Routes
Route::middleware(['auth', 'role:brand'])->prefix('brand')->name('brand.')
    ->group(function () {
        Route::get('/dashboard', BrandDashboard::class)->name('dashboard');
    }
);

// Client Routes
Route::middleware(['auth', 'role:client'])->prefix('brand')->name('brand.')
    ->group(function () {
        Route::get('/dashboard', BrandDashboard::class)->name('dashboard');
    }
);

// Dropshipper Routes
Route::middleware(['auth', 'role:dropshipper'])->prefix('brand')->name('brand.')
    ->group(function () {
        Route::get('/dashboard', BrandDashboard::class)->name('dashboard');
    }
);
