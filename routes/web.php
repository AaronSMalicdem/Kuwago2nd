<?php

use App\Models\Dish;
use App\Models\User;
use App\Models\Order;
use App\Models\Category;
use App\Http\Livewire\Test;
use App\Models\OrderDetails;
use App\Events\PrintKitchenEvent;
use App\Http\Livewire\KitchenPrint;
use App\Http\Livewire\Order\Details;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DishController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\WaiterController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Livewire\Auth\Report\Create;
use App\Http\Livewire\Auth\Report\Show;
use App\Http\Controllers\ExpenseController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/test', function () {
    return Category::with(['dishes.orderDetails.order' => function ($order) {
        $order->whereDate('orders.created_at', date('Y-m-d'));
    }])->get();
});


Route::get('/kitchen', KitchenPrint::class);

Route::get('/print/{order}/{reprint?}', [OrderController::class, 'printReceipt']);
Route::get('/print-kitchen/{order}', [OrderController::class, 'printKitchen']);

Route::get('/print-bill/{order}', [OrderController::class, 'printBill']);
Route::get('/print-waiter-report/{waiter}/{startDate}/{endDate?}', [WaiterController::class, 'printWaiterReport']);
Route::get('/print-po/{order}', [OrderController::class, 'printPurchasOrder']);


Route::middleware('guest')->post('/login-passcode', [WaiterController::class, 'loginViaPasscode']);


Route::middleware(['auth'])->group(function () {

    Route::get('/test-vue-livewire', Test::class);

    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::put('/users/edit-profile', [UserController::class, 'editProfile'])->name('edit-profile');
    Route::get('/waiter-order', [WaiterController::class, 'waiterOrder']);
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');
    Route::get('/waiter-dashboard', [WaiterController::class, 'dashboard'])->name('waiter.dashboard');

    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::get('/orders/show/{order}', [OrderController::class, 'show'])->name('orders.show');

    Route::prefix('admin')->name('admin.')->group(function () {

        Route::get('/users/restore/{user}', [UserController::class, 'activate'])->name('users.restore');
        Route::post('/user/assign/{user}', [UserController::class, 'assignTable'])->name('users.assign.table');
        Route::resource('users', UserController::class);

        Route::resource('tables', TableController::class);

        Route::resource('menus', CategoryController::class);
        Route::put('menus/{menu}/restore', [CategoryController::class, 'restore'])->name('menu.restore');

        Route::get('/reports', [ReportController::class, 'index']);
        Route::get('/reports/create', Create::class);
        Route::get('/reports/show/{report}', Show::class);
        Route::get('/config', [ConfigurationController::class, 'index']);
        Route::put('/order-number-update', [ConfigurationController::class, 'editOrderNo']);
        Route::put('/receipt-number-update', [ConfigurationController::class, 'editReceiptNo']);
        Route::put('/tin-number-update', [ConfigurationController::class, 'editTinNo']);
        Route::put('/tip-update', [ConfigurationController::class, 'editTip']);
        Route::put('/take-out-charge-update', [ConfigurationController::class, 'editTakeOutCharge']);
        Route::put('/network-printer-update', [ConfigurationController::class, 'editNetworkPrinter']);

        Route::delete('/dishes/deactivate/{dish}', [DishController::class, 'deactivate'])->name('dishes.deactivate');
        Route::get('/dishes/restore/{dish}', [DishController::class, 'restore'])->name('dishes.restore');
        Route::resource('dishes', DishController::class);

        Route::resource('expenses', ExpenseController::class);
        Route::patch('/admin/expenses/{expense}/archive', [ExpenseController::class, 'archive'])->name('expenses.archive');
        Route::get('/admin/expenses/archived', [ExpenseController::class, 'archived'])->name('expenses.archived');
        Route::patch('/admin/expenses/{expense}/unarchive', [ExpenseController::class, 'unarchive'])->name('expenses.unarchive');



    });
});

Route::get('/dashboard', [\App\Http\Controllers\CommentController::class, 'index'])->name('dashboard');



require __DIR__ . '/auth.php';
