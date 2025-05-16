<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\paymentController;
use App\Http\Controllers\userController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\driverController;
use App\Http\Controllers\productController;
use App\Http\Controllers\orderController;
use App\Http\Controllers\pricingModelController;
use App\Http\Controllers\adminController;




Route::resource('admin',\App\Http\Controllers\adminController::class);
Route::patch('admin/{id}/update2', [\App\Http\Controllers\adminController::class, 'update2'])->name('admin.update2');
Route::get('admin2/listOrders', [\App\Http\Controllers\adminController::class, 'listOrders']);

Route::get('admin2/listLoyalties',[\App\Http\Controllers\loyaltyController::class, 'listLoyalties']);


Route::get('/reports', [\App\Http\Controllers\reportsController::class, 'index'])->name('reports.index');
Route::get('/reports/totalEarnings', [\App\Http\Controllers\reportsController::class, 'totalEarnings'])->name('total-earnings');
Route::get('/reports/driverPerformance', [\App\Http\Controllers\reportsController::class, 'driverPerformance'])->name('driver-performance');
Route::get('/reports/clientSpending', [\App\Http\Controllers\reportsController::class, 'clientSpending'])->name('client-spending');
Route::get('/reports/demandTrends', [\App\Http\Controllers\reportsController::class, 'demandTrends'])->name('demand-trends');





Route::post('/register',[userController::class,'register']);

Route::post('/login',[userController::class,'login']);

Route::get('/calendar', [driverController::class, 'calendar'])->name('calendar');

Route::get('/DriverDetails', [driverController::class, 'DriverDetails'])->name('DriverDetails');



Route::get('/verify', [UserController::class, 'showVerifyForm'])->name('verify.form');
Route::post('/verify', [UserController::class, 'verifyOtp'])->name('verify.otp');

Route::get('/order-form', [PageController::class, 'orderFormPage'])->name('order.form');
Route::get('/orders/canceled', [DriverController::class, 'canceledOrders'])->name('driver.orders.canceled');
Route::post('/orders/{order}/reaccept', [DriverController::class, 'reacceptCanceledOrder'])->name('driver.orders.reaccept');
Route::get('/login', [PageController::class, 'loginPage'])->name('login');
Route::get('/drivers', [PageController::class, 'driverListPage'])->name('drivers.page');
Route::get('/drivers/{id}', [PageController::class, 'driverDetailPage'])->name('driver.detail.page');
Route::get('/dashboard', [PageController::class, 'dashboardPage'])->name('dashboard');
Route::get('/OrderStatus', [orderController::class, 'OrderStatus'])->name('OrderStatus');

use App\Http\Controllers\GoogleAuthController;

Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');

Route::middleware(['auth', 'driver','verified'])->prefix('driver')->group(function () {
    Route::get('/calendar', [driverController::class, 'calendar'])->name('driver.calendar');
    Route::get('/dashboard', [driverController::class, 'dashboardHome'])->name('driver.home');

    Route::get('/profile', [driverController::class, 'showProfileForm'])->name('driver.profile.form');
    Route::post('/profile', [driverController::class, 'storeProfile'])->name('driver.profile.save');

    Route::get('/pricing', [driverController::class, 'showPricingForm'])->name('driver.pricing.form');
    Route::post('/pricing', [driverController::class, 'storePricing'])->name('driver.pricing.save');

     Route::post('/driver/toggle-status', [DriverController::class, 'toggle'])->name('driver.toggleStatus');

    Route::get('/tasks', [DriverController::class, 'taskDashboard'])->name('driver.tasks');
    Route::post('/tasks/{order}/status', [DriverController::class, 'updateTaskStatus'])->name('driver.tasks.status');
    Route::post('/tasks/{order}/schedule', [DriverController::class, 'scheduleDelivery'])->name('driver.tasks.schedule');
});

Route::get('/inbox', [DriverController::class, 'inboxPage'])->name('driver.inbox');

Route::post('/inbox/{id}/accept', [DriverController::class, 'acceptOrder'])->name('driver.inbox.accept');
Route::delete('/inbox/{id}/reject', [DriverController::class, 'rejectOrder'])->name('driver.inbox.reject');

Route::get('/orders/history', [DriverController::class, 'orderHistory'])->name('driver.orders.history');

Route::get('/calculate-price', [pricingModelController::class, 'showForm'])->name('pricing.form');
Route::post('/calculate-price', [pricingModelController::class, 'calculate'])->name('pricing.calculate');

Route::post('/logout', function () {
    Auth::logout(); // Destroy session
    return redirect('/login'); // Redirect to login page
})->name('logout');

Route::get('/', function () {
    $user = Auth::user();

    if (!$user) {
        return redirect('/login');
    }

    // Redirect based on role
    if ($user->role === 'client') {
        return redirect('/dashboard');
    }

    if ($user->role === 'driver') {
        return redirect('/driver/dashboard');
    }

    // Default fallback
    return redirect('/login');
});



Route::get('/payment-success', [paymentController::class, 'paymentSuccess'])->name('success');
Route::get('/payment-cancel', [paymentController::class, 'paymentCancel'])->name('cancel');
Route::get('/pay', [paymentController::class, 'showPaymentPage'])->name('pay');

Route::get('/crypto-payment', function () {
    return view('cryptoPay');
})->name('crypto.payment');
