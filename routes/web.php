<?php

use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImpersonateController;
use App\Http\Controllers\NavigationController;
use App\Livewire\Admin\AdminDashboard;
use App\Livewire\Admin\BrandManager;
use App\Livewire\Admin\CategorySettings;
use App\Livewire\Admin\GeneralSettings;
use App\Livewire\Admin\PermissionManager;
use App\Livewire\Admin\RevenueManager;
use App\Livewire\Admin\RoleManager;
use App\Livewire\Admin\UserManager;
use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\ResetPassword;
use App\Livewire\Auth\Signup;
use App\Livewire\Auth\VerifyEmail;
use App\Livewire\Brand\AddBrand;
use App\Livewire\Brand\ApprovedDropshippers;
use App\Livewire\Brand\BrandDashboard;
use App\Livewire\Brand\ManageSales;
use App\Livewire\Brand\Orders\DropshipperOrders;
use App\Livewire\Brand\Orders\Index as BrandOrdersList;
use App\Livewire\Brand\PendingApplications;
use App\Livewire\Brand\Product\AddProduct;
use App\Livewire\Brand\Product\Coupons;
use App\Livewire\Brand\Product\EditProduct;
use App\Livewire\Brand\Product\ManageDeliveryLocations;
use App\Livewire\Brand\Product\ManageSection;
use App\Livewire\Brand\Product\ProductList;
use App\Livewire\Brand\RevenueDashboard;
use App\Livewire\Brand\RunSales;
use App\Livewire\Brand\Settings\AdditionalDetails;
use App\Livewire\Brand\Settings\BrandSettings;
use App\Livewire\Brand\Settings\StoreSettings;
use App\Livewire\Brand\SubscriptionStatus;
use App\Livewire\Brand\SwitchAccounts;
use App\Livewire\Cart\DropshipperCart;
use App\Livewire\Cart\Index as CartIndex;
use App\Livewire\Checkout\DropshipperCheckout;
use App\Livewire\Checkout\Index as CheckoutIndex;
use App\Livewire\Checkout\Success as CheckoutSuccess;
use App\Livewire\Client\ClientDashboard;
use App\Livewire\Dropshipper\Applications;
use App\Livewire\Dropshipper\BatchedOrder;
use App\Livewire\Dropshipper\BrowseBrands;
use App\Livewire\Dropshipper\CloneProgress;
use App\Livewire\Dropshipper\CreateStore;
use App\Livewire\Dropshipper\DropshipperDashboard;
use App\Livewire\Dropshipper\ManageStore;
use App\Livewire\Dropshipper\Orders as DropshipperOrdersList;
use App\Livewire\Dropshipper\PartneredBrands;
use App\Livewire\Dropshipper\RevenueGenerated;
use App\Livewire\Dropshipper\Settings\DropshipperDetails;
use App\Livewire\Dropshipper\Store;
use App\Livewire\Dropshipper\TotalRevenueGenerated;
use App\Livewire\ManageWishlist;
use App\Livewire\SelectRole;
use App\Livewire\Settings\ProfileSettings;
use App\Livewire\Shop\About;
use App\Livewire\Shop\Orders;
use App\Livewire\Shop\Products;
use App\Livewire\Shop\Ratings;
use Illuminate\Support\Facades\Route;

// General Routes
Route::get('/', [NavigationController::class, 'home'])->name('home');
Route::get('/brands', [NavigationController::class, 'brands'])->name('brands');
Route::get('/sales', [NavigationController::class, 'sales'])->name('sales');
Route::get('/features', [NavigationController::class, 'features'])->name('features');

// Brand Shops
Route::get('/brands/{brand:slug}', Products::class)->name('shop');
Route::get('/brands/about/{brand:slug}', About::class)->name('shop.about');
Route::get('/brands/orders/{brand:slug}', Orders::class)->name('shop.orders');
Route::get('/brands/ratings/{brand:slug}', Ratings::class)->name('shop.ratings');
Route::get('/cart/{brand:slug}', CartIndex::class)->name('cart');
Route::get('/checkout/{brand:slug}', CheckoutIndex::class)->name('checkout');

// Dropshipper Stores
Route::get('dropshippers/{store:slug}', Store::class)->name('dropshipper-store');
Route::get('/dropshippers-cart/{store:slug}', DropshipperCart::class)->name('dropshipper-cart');
Route::get('/dropshippers-checkout/{store:slug}', DropshipperCheckout::class)->name('dropshipper-checkout');

// Checkout success page
Route::get('/checkout/success/{order}', CheckoutSuccess::class)->name('checkout.success');

// Stop impersonation
Route::get('/stop-impersonator', [ImpersonateController::class, 'stopImpersonate'])->name('stop-impersonator');

// Add Brand
Route::get('/add-brand', AddBrand::class)->name('add-brand');

// Guest only routes
Route::middleware(['guest'])->group(function () {
    Route::get('/signup', Signup::class)->name('signup');
    Route::get('/login', Login::class)->name('login');
    Route::get('/forgot-password', ForgotPassword::class)->name('password.request');
    Route::get('/reset-password/{token}', ResetPassword::class)->name('password.reset');
});

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::middleware(['onboarding'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/verify-email', VerifyEmail::class)->name('verify-email');
        Route::get('/select-role', SelectRole::class)->name('select-role');

        Route::get('/wishlist', ManageWishlist::class)->name('wishlist');
        Route::get('/user-orders/{user}', BrandOrdersList::class)->name('user-orders');
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
        // Role Management Routes
        Route::get('/roles', RoleManager::class)->middleware('permission:roles.view')->name('roles');
        // Permission Management Routes
        Route::get('/permissions', PermissionManager::class)->middleware('permission:roles.view')->name('permissions');

        Route::get('/manage-users', UserManager::class)->middleware('permission:roles.view')->name('manage-users');
        Route::get('/manage-brands', BrandManager::class)->middleware('permission:users.view')->name('manage-brands');

        Route::get('/orders/{admin}', BrandOrdersList::class)->name('orders');

        Route::get('/general-settings', GeneralSettings::class)->middleware('permission:roles.view')->name('general-settings');

        Route::get('/start-impersonator/{user}', [ImpersonateController::class, 'startImpersonate'])->middleware('permission:users.impersonate')->name('start-impersonator');

        Route::get('/revenue-report', RevenueManager::class)->middleware('permission:reports.view')->name('revenue-report');

        Route::get('/category-settings', CategorySettings::class)->middleware('permission:users.view')->name('category-settings');
    }
    );

// Brand Routes
Route::middleware(['auth', 'role:brand', 'onboarding'])->prefix('brand')->name('brand-')
    ->group(function () {
        Route::get('/dashboard', BrandDashboard::class)->name('dashboard');
        Route::get('/settings/brand-details', BrandSettings::class)->name('details');
        Route::get('/settings/additional-details', AdditionalDetails::class)->name('additional-details');
        Route::get('/settings/store-settings', StoreSettings::class)->name('store-settings');

        Route::get('/section', ManageSection::class)->name('section');
        Route::get('/product/add-product', AddProduct::class)->name('add-product');
        Route::get('/product-list', ProductList::class)->name('product-list');
        Route::get('/product/edit-product/{product}', EditProduct::class)->name('edit-product');
        Route::get('/product/manage-delivery-locations', ManageDeliveryLocations::class)->name('manage-delivery-locations');
        Route::get('/product/coupons', Coupons::class)->name('product-coupon');

        Route::get('/pending-applications', PendingApplications::class)->name('pending-applications');
        Route::get('/approved-dropshipper', ApprovedDropshippers::class)->name('approved-dropshippers');

        Route::get('/orders', BrandOrdersList::class)->name('orders');
        Route::get('/dropshippers-orders', DropshipperOrders::class)->name('dropshippers-orders');
        Route::get('/view-store-orders/{store}', BrandOrdersList::class)->name('view-store-orders');
        Route::get('/batched-orders/{batch}', BrandOrdersList::class)->name('batched-orders');
        Route::get('/view-sales-orders/{sale}', BrandOrdersList::class)->name('view-sales-orders');
        Route::get('/order-status/{status}', BrandOrdersList::class)->name('order-status');

        Route::get('/run-sales', RunSales::class)->name('run-sales');
        Route::get('/update-sales/{sale}', RunSales::class)->name('update-sales');
        Route::get('/manage-sales', ManageSales::class)->name('manage-sales');

        Route::get('/revenue-analytics', RevenueDashboard::class)->name('revenue-analytics');

        Route::get('/switch-account', SwitchAccounts::class)->name('switch-account');

        Route::get('/subscription-status', SubscriptionStatus::class)->name('subscription-status');
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

        Route::get('/partnered-brands', PartneredBrands::class)->name('partnered-brands');
        Route::get('/applications', Applications::class)->name('applications');
        Route::get('/browse-brands', BrowseBrands::class)->name('browse-brands');

        Route::get('/create-store/{brand}', CreateStore::class)->name('create-store');
        Route::get('/clone-progress/{store}', CloneProgress::class)->name('clone-progress');

        Route::get('/manage-store/{store}', ManageStore::class)->name('manage-store');
        Route::get('/store-orders/{store}', DropshipperOrdersList::class)->name('orders');
        Route::get('/orders-batched/{batch}', DropshipperOrdersList::class)->name('orders-batched');
        Route::get('/all-orders/{dropshipperId}', DropshipperOrdersList::class)->name('all-orders');

        Route::get('/revenue-generated/{storeId}', RevenueGenerated::class)->name('revenue-generated');
        Route::get('/total-revenue', TotalRevenueGenerated::class)->name('total-revenue');

        Route::get('/batched-orders/{store}', BatchedOrder::class)->name('batched-orders');
    });

Route::get('/preview-email', function () {
    return view('emails.password-reset', [
        'name' => 'John Doe',
        'url' => '#',
    ]);
});
