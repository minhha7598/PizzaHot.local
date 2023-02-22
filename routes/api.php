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

    Route::prefix('admin')->group(function () {
        //AUTHENTICATION
        Route::controller(AuthController::class)->group(function () {
            Route::post('logout', 'logout');
        });
        //CATEGORY
        Route::get('getAllCategory', [CategoryController::class, 'getAll']);
        Route::post('showCategory', [CategoryController::class, 'show']);
        Route::post('insertCategory', [CategoryController::class, 'insert']);
        Route::post('updateCategory', [CategoryController::class, 'update']);
        Route::post('deleteCategory', [CategoryController::class, 'destroy']);

        //PRODUCT
        Route::get('getAllProduct', [ProductController::class, 'getAll']);
        Route::post('showProduct', [ProductController::class, 'show']);
        Route::post('insertProduct', [ProductController::class, 'insert']);
        Route::post('updateProduct', [ProductController::class, 'update']);
        Route::post('deleteProduct', [ProductController::class, 'destroy']);

        //IMPORTED PRODUCTS
        Route::get('getAllImportedProduct', [ImportedProductController::class, 'getAll']);
        Route::post('insertImportedProduct', [ImportedProductController::class, 'insert']);
        Route::post('updateImportedProduct', [ImportedProductController::class, 'update']);
        Route::post('deleteImportedProduct', [ImportedProductController::class, 'destroy']);

        //DISCOUNT CODE
        Route::get('getAllDiscount', [DiscountController::class, 'getAll']);
        Route::post('insertDiscount', [DiscountController::class, 'insert']);
        Route::post('updateDiscount', [DiscountController::class, 'update']);
        Route::post('deleteDiscount', [DiscountController::class, 'destroy']);

        //EMPLOYEE
        Route::get('getAllEmployee', [EmployeeController::class, 'getAll']);
        Route::post('showEmployee', [EmployeeController::class, 'show']);
        Route::post('insertEmployee', [EmployeeController::class, 'insert']);
        Route::post('updateEmployee', [EmployeeController::class, 'update']);
        Route::post('deleteEmployee', [EmployeeController::class, 'destroy']);

        //SHIFT
        Route::get('getAllShift', [ShiftController::class, 'getAll']);
        Route::post('insertShift', [ShiftController::class, 'insert']);
        Route::post('updateShift', [ShiftController::class, 'update']);
        Route::post('deleteShift', [ShiftController::class, 'destroy']);

        //SALARY
        Route::get('getAllSalary', [SalaryController::class, 'getAll']);
        Route::post('insertSalary', [SalaryController::class, 'insert']);
        Route::post('updateSalary', [SalaryController::class, 'update']);
        Route::post('deleteSalary', [SalaryController::class, 'destroy']);

        //BILL
        Route::post('orderLive', [BillController::class, 'orderLive']);
        Route::post('ship', [BillController::class, 'ship']);
        Route::post('takeAway', [BillController::class, 'takeAway']);
        Route::post('updateBill', [BillController::class, 'update']);
        Route::post('deleteBill', [BillController::class, 'destroy']);
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

        //NOTIFICATION
        Route::post('sendEmail', [MailController::class, 'sendEmail']);

        //EXCEL
        Route::post('import', [ExcelController::class, 'importExcel']);
        Route::get('export', [ExcelController::class, 'exportExcel']);
    });

    //ROUTE CUSTOMER
    Route::post('product', [IndexController::class, 'product']);
    Route::post('product/{$id}', [IndexController::class, 'detail-product']);
});


