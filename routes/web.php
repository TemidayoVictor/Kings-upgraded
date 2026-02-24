<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NavigationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LogoutController;
use App\Livewire\Auth\Signup;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\VerifyEmail;
use App\Livewire\SelectRole;
use App\Livewire\Admin\AdminDashboard;
use App\Livewire\Brand\BrandDashboard;
use App\Livewire\Client\ClientDashboard;
use App\Livewire\Dropshipper\DropshipperDashboard;
use App\Livewire\Settings\ProfileSettings;
use App\Livewire\Brand\Settings\BrandSettings;
use App\Livewire\Brand\Settings\AdditionalDetails;
use App\Livewire\Dropshipper\Settings\DropshipperDetails;

// General Routes
Route::get('/', [NavigationController::class, 'home'])->name('home');

// Guest only routes
Route::middleware(['guest'])->group(function () {
    Route::livewire('/signup', Signup::class)->name('signup');
    Route::livewire('/login', Login::class)->name('login');
});

//Protected Routes
Route::middleware(['auth'])->group(function () {
        Route::middleware(['onboarding'])->group(function () {
                Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
                Route::livewire('/verify-email', VerifyEmail::class)->name('verify-email');
                Route::livewire('/select-role', SelectRole::class)->name('select-role');
            }
        );
        Route::livewire('/settings/profile', ProfileSettings::class)->name('settings.profile');

        Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
    }
);

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin-')
    ->group(function () {
        Route::livewire('/dashboard', AdminDashboard::class)->name('dashboard');
    }
);

// Brand Routes
Route::middleware(['auth', 'role:brand', 'onboarding'])->prefix('brand')->name('brand-')
    ->group(function () {
        Route::livewire('/dashboard', BrandDashboard::class)->name('dashboard');
        Route::livewire('/settings/brand-details', BrandSettings::class)->name('details');
        Route::livewire('/settings/additional-details', AdditionalDetails::class)->name('additional-details');
    }
);

// Client Routes
Route::middleware(['auth', 'role:client', 'onboarding'])->prefix('client')->name('client-')
    ->group(function () {
        Route::livewire('/dashboard', ClientDashboard::class)->name('dashboard');
    }
);

// Dropshipper Routes
Route::middleware(['auth', 'role:dropshipper', 'onboarding'])->prefix('dropshipper')->name('dropshipper-')
    ->group(function () {
        Route::livewire('/dashboard', DropshipperDashboard::class)->name('dashboard');
        Route::livewire('/settings/dropshipper-details', DropshipperDetails::class)->name('details');
    }
);
