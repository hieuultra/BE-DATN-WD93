<?php

use Illuminate\Support\Facades\Auth;
//admin
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\VariantProPackageController;
use App\Http\Controllers\Admin\VariantProductsController;
//client
use App\Http\Controllers\Client\AuthController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\AboutController;
use App\Http\Middleware\CheckRoleAdminMiddleware;
use App\Http\Controllers\Client\ContactController;


// Route::get('/', function () {
//     return view('welcome');
// });
//Guest
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'about'])->name('about');
Route::get('/contact', [ContactController::class, 'contact'])->name('contact');
//Login + signup
Route::get('/login', [AuthController::class, 'viewLogin'])->name('viewLogin');
Route::post('/login', [AuthController::class, 'login'])->name('login');
// Route::get('/loginSuccess', [AuthController::class, 'loginSuccess'])->name('loginSuccess')->middleware('auth');
Route::get('/account', [AuthController::class, 'account'])->name('account');
Route::get('/viewRegister', [AuthController::class, 'viewRegister'])->name('viewRegister');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//login success + admin
Route::middleware('auth')->group(function () {
    Route::get('/loginSuccess', [AuthController::class, 'loginSuccess'])->name('loginSuccess')->middleware('auth');
    Route::middleware('auth.admin')->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin');
    });
});

Auth::routes();
//user management
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/login', [AuthController::class, 'viewLogin'])->name('viewLogin');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/viewEditAcc', [AuthController::class, 'viewEditAcc'])->name('viewEditAcc');
Route::post('/editAcc', [AuthController::class, 'editAcc'])->name('editAcc');

//admin
Route::middleware(['auth', 'auth.admin'])->prefix('admin')
    ->as('admin.')
    ->group(function () {
        Route::get('/dashborad', function () {
            return view('admin.dashboard');
        })->name('dashboard');
        //categories
        Route::prefix('categories')
            ->as('categories.')
            ->group(function () {
                Route::get('/categoriesList', [CategoryController::class, 'categoriesList'])->name('categoriesList');
                Route::get('/viewCateAdd', [CategoryController::class, 'viewCateAdd'])->name('viewCateAdd');
                Route::post('/cateAdd', [CategoryController::class, 'cateAdd'])->name('cateAdd');
                Route::get('/cateUpdateForm/{id}', [CategoryController::class, 'cateUpdateForm'])->name('cateUpdateForm');
                Route::post('/cateUpdate', [CategoryController::class, 'cateUpdate'])->name('cateUpdate');
                Route::delete('/cateDestroy/{id}', [CategoryController::class, 'cateDestroy'])->name('cateDestroy');
            });
        //products
        Route::prefix('products')
            ->as('products.')
            ->group(function () {
                Route::get('/productList', [ProductController::class, 'productList'])->name('productList');
                Route::get('/viewProAdd', [ProductController::class, 'viewProAdd'])->name('viewProAdd');
                Route::post('/productAdd', [ProductController::class, 'productAdd'])->name('productAdd');
                Route::get('/productUpdateForm/{id}', [ProductController::class, 'productUpdateForm'])->name('productUpdateForm');
                Route::post('/productUpdate', [ProductController::class, 'productUpdate'])->name('productUpdate');
                Route::delete('/productDestroy/{id}', [ProductController::class, 'productDestroy'])->name('productDestroy');
            });
        //variantPackages
        Route::prefix('variantPros')
        ->as('variantPros.')
        ->group(function () {
            Route::get('/variantProList', [VariantProPackageController::class, 'variantProList'])->name('variantProList');
            Route::get('/VariantPackageAdd', [VariantProPackageController::class, 'variantProAdd'])->name('packageAdd');
            Route::post('/VariantPackageAdd', [VariantProPackageController::class, 'packageAdd'])->name('packageAdd');
            Route::get('/packageUpdate/{id}', [VariantProPackageController::class, 'packegeUpdate'])->name('viewpackageUpdate');
            Route::post('/packageUpdate', [VariantProPackageController::class, 'packageUpdate'])->name('packageUpdate');
            Route::delete('/packageDestroy/{id}', [VariantProPackageController::class, 'packageDestroy'])->name('packageDestroy');
        });
        //variantProducs
        Route::prefix('productVariant')
        ->as('productVariant.')
        ->group(function () {
            Route::get('/viewVariantProductAdd', [VariantProductsController::class, 'viewProductVariantAdd'])->name('viewProductVariantAdd');
            Route::post('/VariantProductAdd', [VariantProductsController::class, 'variantProductAdd'])->name('variantProductAdd');
            Route::get('/VariantProductUpdate/{id}', [VariantProductsController::class, 'VariantProductUpdateForm'])->name('viewVariantProductUpdate');
            Route::post('/VariantProductUpdate', [VariantProductsController::class, 'VariantProductUpdate'])->name('variantProductUpdate');
            Route::delete('/VariantProductDestroy/{id}', [VariantProductsController::class, 'VariantProductDestroy'])->name('VariantProductDestroy');
        });
        //order
        // Route::prefix('bills')
        //     ->as('bills.')
        //     ->group(function () {
        //         Route::get('/',               [BillsController::class, 'index'])->name('index');
        //         Route::get('/show/{id}',     [BillsController::class, 'show'])->name('show');
        //         Route::put('{id}/update',    [BillsController::class, 'update'])->name('update');
        //         Route::delete('{id}/destroy', [BillsController::class, 'destroy'])->name('destroy');
        //     });
        //account
        // Route::prefix('account')
        //     ->as('account.')
        //     ->group(function () {
        //         Route::get('/accountList', [AccountController::class, 'accountList'])->name('accountList');
        //         Route::get('/viewAccAdd', [AccountController::class, 'viewAccAdd'])->name('viewAccAdd');
        //         Route::post('/accAdd', [AccountController::class, 'accAdd'])->name('accAdd');
        //         Route::get('/accUpdateForm/{id}', [AccountController::class, 'accUpdateForm'])->name('accUpdateForm');
        //         Route::post('/accUpdate', [AccountController::class, 'accUpdate'])->name('accUpdate');
        //         Route::delete('/accDestroy/{id}', [AccountController::class, 'accDestroy'])->name('accDestroy');
        //     });
    });
