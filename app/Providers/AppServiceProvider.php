<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Product\ProductService;
use App\Services\Product\ProductServiceInterface;
use App\Services\Category\CategoryService;
use App\Services\Category\CategoryServiceInterface;
use App\Services\Order\OrderService;
use App\Services\Order\OrderServiceInterface;
use App\Services\Ship\ShipService;
use App\Services\Ship\ShipServiceInterface;
use App\Services\Bill\BillService;
use App\Services\Bill\BillServiceInterface;
use App\Services\Salary\SalaryService;
use App\Services\Salary\SalaryServiceInterface;
use App\Services\Employee\EmployeeService;
use App\Services\Employee\EmployeeServiceInterface;
use App\Services\Shift\ShiftService;
use App\Services\Shift\ShiftServiceInterface;
use App\Services\Discount\DiscountService;
use App\Services\Discount\DiscountServiceInterface;
use App\Services\ImportedProduct\ImportedProductService;
use App\Services\ImportedProduct\ImportedProductServiceInterface;

use App\Repositories\Category\CategoryRepository;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Order\OrderRepository;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\Ship\ShipRepository;
use App\Repositories\Ship\ShipRepositoryInterface;
use App\Repositories\Bill\BillRepository;
use App\Repositories\Bill\BillRepositoryInterface;
use App\Repositories\Salary\SalaryRepository;
use App\Repositories\Salary\SalaryRepositoryInterface;
use App\Repositories\Employee\EmployeeRepository;
use App\Repositories\Employee\EmployeeRepositoryInterface;
use App\Repositories\Shift\ShiftRepository;
use App\Repositories\Shift\ShiftRepositoryInterface;
use App\Repositories\Discount\DiscountRepository;
use App\Repositories\Discount\DiscountRepositoryInterface;
use App\Repositories\ImportedProduct\ImportedProductRepository;
use App\Repositories\ImportedProduct\ImportedProductRepositoryInterface;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //Service
        $this->app->bind(CategoryServiceInterface::class, CategoryService::class);
        $this->app->bind(ProductServiceInterface::class, ProductService::class);
        $this->app->bind(OrderServiceInterface::class, OrderService::class);
        $this->app->bind(ShipServiceInterface::class, ShipService::class);
        $this->app->bind(BillServiceInterface::class, BillService::class);
        $this->app->bind(SalaryServiceInterface::class, SalaryService::class);
        $this->app->bind(EmployeeServiceInterface::class, EmployeeService::class);
        $this->app->bind(ShiftServiceInterface::class, ShiftService::class);
        $this->app->bind(DiscountServiceInterface::class, DiscountService::class);
        $this->app->bind(ImportedProductServiceInterface::class, ImportedProductService::class);
        
        //Repository
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(ShipRepositoryInterface::class, ShipRepository::class);
        $this->app->bind(BillRepositoryInterface::class, BillRepository::class);
        $this->app->bind(SalaryRepositoryInterface::class, SalaryRepository::class);
        $this->app->bind(EmployeeRepositoryInterface::class, EmployeeRepository::class);
        $this->app->bind(ShiftRepositoryInterface::class, ShiftRepository::class);
        $this->app->bind(DiscountRepositoryInterface::class, DiscountRepository::class);
        $this->app->bind(ImportedProductRepositoryInterface::class, ImportedProductRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}