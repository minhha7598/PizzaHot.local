<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResetPwdController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\TurnoverController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\ImportedProductController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SocialiteController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//Google - Facebook
Route::prefix('auth')->controller(SocialiteController::class)->group(function () {
    Route::get('/google', 'googleLogin');
    Route::get('/google/callback', 'googleCallback');
    Route::post('/google/logout', 'googleLogout');
    Route::get('/facebook', 'facebookLogin');
    Route::get('/facebook/callback', 'facebookCallback');
    Route::post('/facebook/logout', 'facebookLogout');
});

//Push Notification
Route::post('/store-token', [NotificationController::class, 'updateDeviceToken']);
Route::post('/send-notification', [NotificationController::class, 'sendNotification']);

Route::group(['domain' => env('APP_URL')], function() {
    Route::controller(ResetPwdController::class)->group(function () {
        Route::post('sendPasswordResetLink', 'sendEmail');
        Route::post('resetPassword', 'updatePassword');
    });

    //AUTHENTICATION
    Route::controller(AuthController::class)->group(function () {
        Route::post('login', 'login');
        Route::post('register', 'register');
    });

    //Admin
    Route::prefix('admin')->group(function () {
        //AUTHENTICATION
        Route::controller(AuthController::class)->group(function () {
            Route::delete('logout', 'logout');
        });
        //CATEGORY
        Route::get('getAllCategory', [CategoryController::class, 'getAll']);
        Route::post('showCategory', [CategoryController::class, 'show']);
        Route::post('insertCategory', [CategoryController::class, 'insert']);
        Route::put('updateCategory', [CategoryController::class, 'update']);
        Route::delete('deleteCategory', [CategoryController::class, 'destroy']);

        //PRODUCT
        Route::get('getAllProduct', [ProductController::class, 'getAll']);
        Route::post('showProduct', [ProductController::class, 'show']);
        Route::post('insertProduct', [ProductController::class, 'insert']);
        Route::put('updateProduct', [ProductController::class, 'update']);
        Route::delete('deleteProduct', [ProductController::class, 'destroy']);

        //IMPORTED PRODUCTS
        Route::get('getAllImportedProduct', [ImportedProductController::class, 'getAll']);
        Route::post('insertImportedProduct', [ImportedProductController::class, 'insert']);
        Route::put('updateImportedProduct', [ImportedProductController::class, 'update']);
        Route::delete('deleteImportedProduct', [ImportedProductController::class, 'destroy']);

        //DISCOUNT CODE
        Route::get('getAllDiscount', [DiscountController::class, 'getAll']);
        Route::post('insertDiscount', [DiscountController::class, 'insert']);
        Route::put('updateDiscount', [DiscountController::class, 'update']);
        Route::delete('deleteDiscount', [DiscountController::class, 'destroy']);

        //EMPLOYEE
        Route::get('getAllEmployee', [EmployeeController::class, 'getAll']);
        Route::post('showEmployee', [EmployeeController::class, 'show']);
        Route::post('insertEmployee', [EmployeeController::class, 'insert']);
        Route::put('updateEmployee', [EmployeeController::class, 'update']);
        Route::delete('deleteEmployee', [EmployeeController::class, 'destroy']);

        //SHIFT
        Route::get('getAllShift', [ShiftController::class, 'getAll']);
        Route::post('insertShift', [ShiftController::class, 'insert']);
        Route::put('updateShift', [ShiftController::class, 'update']);
        Route::delete('deleteShift', [ShiftController::class, 'destroy']);

        //SALARY
        Route::get('getAllSalary', [SalaryController::class, 'getAll']);
        Route::post('insertSalary', [SalaryController::class, 'insert']);
        Route::put('updateSalary', [SalaryController::class, 'update']);
        Route::delete('deleteSalary', [SalaryController::class, 'destroy']);

        //BILL
        Route::post('orderLive', [BillController::class, 'orderLive']);
        Route::post('ship', [BillController::class, 'ship']);
        Route::post('takeAway', [BillController::class, 'takeAway']);
        Route::put('updateBill', [BillController::class, 'update']);
        Route::delete('deleteBill', [BillController::class, 'destroy']);
        Route::post('detailBill', [BillController::class, 'show']);
        Route::post('getBillsByDate', [BillController::class, 'getBillsByDate']);

        //PAYMENT
        Route::post('payment', [PaymentController::class, 'payment']);
        Route::post('clearTable', [PaymentController::class, 'clearTable']);

        //TURNOVER
        Route::post('turnoverDateImport', [TurnoverController::class, 'turnoverDateImport']);
        Route::post('turnoverDate', [TurnoverController::class, 'turnoverDate']);
        Route::post('turnoverMonth', [TurnoverController::class, 'turnoverMonth']);
        Route::get('turnoverTotal', [TurnoverController::class, 'turnoverTotal']);

        //PUSH NOTIFICATION - SEND EMAIL
        Route::post('sendEmail', [MailController::class, 'sendEmail']);

        //EXCEL
        Route::post('import', [ExcelController::class, 'importExcel']);
        Route::get('export', [ExcelController::class, 'exportExcel']);
    });

    //ROUTE CUSTOMER
    Route::post('product', [IndexController::class, 'product']);
    Route::post('product/{$id}', [IndexController::class, 'detail-product']);
});

