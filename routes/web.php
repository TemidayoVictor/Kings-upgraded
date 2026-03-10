<?php

use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NavigationController;
use App\Livewire\Admin\AdminDashboard;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Signup;
use App\Livewire\Auth\VerifyEmail;
use App\Livewire\Brand\BrandDashboard;
use App\Livewire\Brand\Product\AddProduct;
use App\Livewire\Brand\Product\EditProduct;
use App\Livewire\Brand\Product\ManageDeliveryLocations;
use App\Livewire\Brand\Product\ManageSection;
use App\Livewire\Brand\Product\ProductList;
use App\Livewire\Brand\Settings\AdditionalDetails;
use App\Livewire\Brand\Settings\BrandSettings;
use App\Livewire\Client\ClientDashboard;
use App\Livewire\Dropshipper\DropshipperDashboard;
use App\Livewire\Dropshipper\Settings\DropshipperDetails;
use App\Livewire\SelectRole;
use App\Livewire\Settings\ProfileSettings;
use App\Livewire\Shop\Products;
use App\Livewire\Cart\Index as CartIndex;
use App\Livewire\Checkout\Index as CheckoutIndex;
use App\Livewire\Checkout\Success as CheckoutSuccess;
use Illuminate\Support\Facades\Route;

// General Routes
Route::get('/', [NavigationController::class, 'home'])->name('home');
Route::get('/brands/{brand:slug}', Products::class)->name('shop');
Route::get('/cart/{brand:slug}', CartIndex::class)->name('cart');
Route::get('/checkout/{brand:slug}', CheckoutIndex::class)->name('checkout');
Route::get('/checkout/success/{order}', CheckoutSuccess::class)->name('checkout.success');


// Guest only routes
Route::middleware(['guest'])->group(function () {
    Route::get('/signup', Signup::class)->name('signup');
    Route::get('/login', Login::class)->name('login');
});

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::middleware(['onboarding'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/verify-email', VerifyEmail::class)->name('verify-email');
        Route::get('/select-role', SelectRole::class)->name('select-role');
    }
    );
    Route::get('/settings/profile', ProfileSettings::class)->name('settings.profile');

    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
}
);

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin-')
    ->group(function () {
        Route::get('/dashboard', AdminDashboard::class)->name('dashboard');
    }
    );

// Brand Routes
Route::middleware(['auth', 'role:brand', 'onboarding'])->prefix('brand')->name('brand-')
    ->group(function () {
        Route::get('/dashboard', BrandDashboard::class)->name('dashboard');
        Route::get('/settings/brand-details', BrandSettings::class)->name('details');
        Route::get('/settings/additional-details', AdditionalDetails::class)->name('additional-details');

        Route::get('/product/add-product', AddProduct::class)->name('add-product');
        Route::get('/section', ManageSection::class)->name('section');
        Route::get('/product-list', ProductList::class)->name('product-list');
        Route::get('/product/edit-product/{product}', EditProduct::class)->name('edit-product');
        Route::get('/product/manage-delivery-locations', ManageDeliveryLocations::class)->name('manage-delivery-locations');
    }
    );

// Client Routes
Route::middleware(['auth', 'role:client', 'onboarding'])->prefix('client')->name('client-')
    ->group(function () {
        Route::get('/dashboard', ClientDashboard::class)->name('dashboard');
    }
    );

// Dropshipper Routes
Route::middleware(['auth', 'role:dropshipper', 'onboarding'])->prefix('dropshipper')->name('dropshipper-')
    ->group(function () {
        Route::get('/dashboard', DropshipperDashboard::class)->name('dashboard');
        Route::get('/settings/dropshipper-details', DropshipperDetails::class)->name('details');
    }
    );
