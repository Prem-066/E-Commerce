<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FronendPagesController;
use App\Http\Controllers\PaymentController;
use App\Livewire\Admin\Categories;
use App\Livewire\Admin\Coupons\Index as CouponsIndex;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Admin\Manager\Form as ManagerForm;
use App\Livewire\Admin\Manager\Index as ManagerIndex;
use App\Livewire\Admin\Orders\Index as OrdersIndex;
use App\Livewire\Admin\Products\Index as ProductsIndex;
use App\Livewire\Admin\Reports as AdminReports;
use App\Livewire\Admin\Settings as AdminSettings;
use App\Livewire\Admin\User\Form as UserForm;
use App\Livewire\Admin\User\Index as UserIndex;
use App\Livewire\Employee\Dashboard as EmployeeDashboard;
use App\Livewire\Employee\Index as EmployeeIndex;
use App\Livewire\Employee\PosSale;
use App\Livewire\StoreManager\Dashboard as StoreManagerDashboard;
use App\Livewire\StoreManager\Form as StoreManagerForm;
use App\Livewire\StoreManager\Index as StoreManagerIndex;
use App\Livewire\SuperAdmin\Dashboard;
use App\Livewire\SuperAdmin\LoyalitySettings;
use App\Livewire\SuperAdmin\Reports;
use App\Livewire\SuperAdmin\Reports as SuperAdminReports;
use App\Livewire\SuperAdmin\Settings as SuperAdminSettings;
use App\Livewire\SuperAdmin\Store\Form as StoreForm;
use App\Livewire\SuperAdmin\Store\Index as StoreIndex;
use Illuminate\Support\Facades\Route;
use App\Livewire\SuperAdmin\User\Index;
use App\Livewire\SuperAdmin\User\Form;
use Illuminate\Http\Request;

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


Route::get('/', function () {
    return redirect()->route('trend-era-home');
});
Route::get('/trend-era-home', [FronendPagesController::class, 'index'])->name('trend-era-home');


Route::post('/save-location', function (Request $request) {
    if ($request->city) {
        session(['user_city' => $request->city]);
        return response()->json(['status' => 'success', 'city' => $request->city]);
    }
    return response()->json(['status' => 'error'], 400);
});

Route::get('/trend-era-shop', [FronendPagesController::class, 'shop'])->name('trend-era-shop');
Route::get('/trend-era-product-detail/{slug}', [FronendPagesController::class, 'productDetail'])->name('product-detail');
Route::get('/trend-era-add-to-cart/{slug}', [FronendPagesController::class, 'addToCart'])->name('add.to.cart');
Route::get('/trend-era-cart', [FronendPagesController::class, 'showCart'])->name('cart.show');
Route::post('/remove-from-cart', [FronendPagesController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/update-cart-quantity', [FronendPagesController::class, 'updateCart'])->name('cart.update');
Route::post('/check-cart-stock', [FronendPagesController::class, 'checkCartStock'])->name('cart.checkStock');
Route::post('/apply-coupon', [FronendPagesController::class, 'applyCoupon'])->name('coupon.apply');
Route::post('/remove-coupon', [FronendPagesController::class, 'removeCoupon'])->name('coupon.remove');
Route::get('/trend-era-checkout', [FronendPagesController::class, 'checkout'])->name('checkout');
Route::get('/trend-era-buy-now/{slug}', [FronendPagesController::class, 'buyNow'])->name('buy-now');
Route::post('/trend-era-checkout', [FronendPagesController::class, 'placeOrder'])->name('checkout.post');
Route::get('/download-invoice/{id}', [FronendPagesController::class, 'downloadInvoice'])->name('invoice.download');
Route::get('/order-success', function () {
    if (!session('order_number')) {
        return redirect()->route('trend-era-shop');
    }
    return view('fronend.partials.pages.order_success');
})->name('order.success');
Route::get('/trend-era-order-history', [FronendPagesController::class, 'history'])->name('order.history');
Route::post('/order-item/update-status', [FronendPagesController::class, 'updateItemStatus']);

Route::get('/get-order-details/{id}', [FronendPagesController::class, 'showOrderDetails']);

Route::get('/wishlist')->name('wishlist.index');

Route::get('/wishlist', [FronendPagesController::class, 'wishlist'])->name('wishlist.index');
Route::get('/wishlist/add/{product_id}', [FronendPagesController::class, 'addToWishlist'])->name('wishlist.add');
Route::delete('/wishlist/remove/{id}', [FronendPagesController::class, 'removeFromWishlist'])->name('wishlist.remove');

Route::get('/trend-era-login', [AuthController::class, 'showLogin'])->name('login-front');
Route::post('/trend-era-login', [AuthController::class, 'login'])->name('trend-era-login.post');
Route::get('/trend-era-register', [AuthController::class, 'showRegister'])->name('register-front');
Route::post('/trend-era-register', [AuthController::class, 'register'])->name('trend-era-register.post');
Route::post('/trend-era-logout', [AuthController::class, 'logout'])->name('trend-era-logout');

Route::get('/trend-era-forgot-password', [AuthController::class, 'showLinkRequestForm'])->name('trend-era.password.request');
Route::post('/trend-era-forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('trend-era.password.email');
Route::get('/trend-era-reset-password/{token}', [AuthController::class, 'showResetForm'])->name('trend-era.password.reset');
Route::post('/trend-era-reset-password', [AuthController::class, 'reset'])->name('trend-era.password.update');

Route::middleware(['auth'])->group(function () {
    Route::get('/user-profile', [FronendPagesController::class, 'userProfile'])->name('user.profile');
    Route::post('/user-profile-update', [FronendPagesController::class, 'updateProfile'])->name('user.profile.update');
});

Route::get('/trend-era-contact', [FronendPagesController::class, 'contact'])->name('trend-era-contact');
Route::post('/contact-send', [FronendPagesController::class, 'sendContact'])->name('contact.send');
// Route::redirect('/', '/login');

Route::middleware(['auth', 'role:Super Admin'])
    ->group(function () {

        Route::get('/superadmin/dashboard', Dashboard::class)
            ->name('superadmin.dashboard');

        Route::get('/superadmin/users', Index::class)
            ->name('superadmin.users.index');

        Route::get('/superadmin/users/create', Form::class)
            ->name('superadmin.users.create');

        Route::get('/superadmin/users/{user}/edit', Form::class)
            ->name('superadmin.users.edit');


        Route::get('/superadmin/stores', StoreIndex::class)
            ->name('superadmin.stores.index');

        Route::get('/superadmin/stores/create', StoreForm::class)
            ->name('superadmin.stores.create');

        Route::get('/superadmin/stores/{store}/edit', StoreForm::class)
            ->name('superadmin.stores.edit');

        Route::get('/superadmin/loyalty', LoyalitySettings::class)
            ->name('superadmin.loyalty.index');

        Route::get('/superadmin/reports', Reports::class)
            ->name('superadmin.reports.index');

        Route::get('/superadmin/settings', SuperAdminSettings::class)
            ->name('superadmin.settings.index');
    });

Route::middleware(['auth', 'role:Store Manager', 'check.store'])
    ->group(function () {
        Route::get('/store-manager/dashboard', StoreManagerDashboard::class)
            ->name('store.dashboard');

        Route::get('/store-manager/catalog', Categories::class)
            ->name('store.catalog');
        Route::get('/store-manager/products', ProductsIndex::class)
            ->name('store.products');

        Route::get('store/manager/users', StoreManagerIndex::class)->name('store.manager.index');
        Route::get('store/manager/users/create', StoreManagerForm::class)->name('store.manager.create');
        Route::get('store/manager/users/{employee}/edit', StoreManagerForm::class)->name('store.manager.edit');

        Route::get('store/manager/pos', PosSale::class)
            ->name('store.manager.pos');


        Route::get('/store/manager/orders', OrdersIndex::class)
            ->name('store.manager.order.index');
    });

Route::middleware(['auth', 'check.store'])->get('pos/success', [PaymentController::class, 'handleSuccess'])->name('pos.success');

Route::middleware(['auth', 'role:Employee POS', 'check.store'])
    ->group(function () {

        Route::get('employee/dashboard', EmployeeDashboard::class)
            ->name('employee.dashboard');

        Route::get('employee/inventory', EmployeeIndex::class)
            ->name('employee.inventory')->middleware('can:view inventory');

        Route::get('employee/pos', PosSale::class)
            ->name('employee.pos');

        Route::get('employee/catalog', Categories::class)
            ->name('employee.store.catalog');

        Route::get('/employee/products', ProductsIndex::class)
            ->name('employee.store.products');

        Route::get('/employee/orders', OrdersIndex::class)
            ->name('employee.order.index');
    });

Route::middleware(['auth', 'role:Admin', 'check.store'])
    ->group(function () {

        Route::get('admin/dashboard', AdminDashboard::class)
            ->name('admin.dashboard');

        // Route::get('/admin/users', UserIndex::class)
        //     ->name('admin.users.index');
        // Route::get('/admin/users/create', UserForm::class)
        //     ->name('admin.users.create');
        // Route::get('/admin/users/{user}/edit', UserForm::class)
        //     ->name('admin.users.edit');

        Route::get('/admin/store/catalog', Categories::class)
            ->name('admin.catalog');

        Route::get('/admin/orders', OrdersIndex::class)
            ->name('admin.orders.index');

        Route::get('/admin/products', ProductsIndex::class)
            ->name('admin.products');

        Route::get('admin/manager', ManagerIndex::class)->name('admin.manager.index');

        Route::get('admin/manager/create', ManagerForm::class)->name('admin.manager.create');

        Route::get('admin/manager/{manager}/edit', ManagerForm::class)->name('admin.manager.edit');
        Route::get('/admin/settings', AdminSettings::class)->name('admin.settings');

        Route::get('/admin/reports', AdminReports::class)
            ->name('admin.reports.index');

        Route::get('/admin/coupons', CouponsIndex::class)
            ->name('admin.coupons');
    });

// Route::view('profile', 'profile')
//     ->middleware(['auth'])
//     ->name('profile');

require __DIR__ . '/auth.php';
// });
