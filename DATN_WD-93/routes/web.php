<?php

use App\Models\Bill;
//admin
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BillController;
use App\Http\Controllers\Admin\UserController;


//client
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Client\AuthController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\AboutController;
use App\Http\Middleware\CheckRoleAdminMiddleware;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\StaffController;
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

//admin
Route::middleware(['auth', CheckRoleAdminMiddleware::class])->prefix('admin')
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
        // Route::prefix('products')
        //     ->as('products.')
        //     ->group(function () {
        //         Route::get('/productList', [AdminController::class, 'productList'])->name('productList');
        //         Route::get('/viewProAdd', [AdminController::class, 'viewProAdd'])->name('viewProAdd');
        //         Route::post('/productAdd', [AdminController::class, 'productAdd'])->name('productAdd');
        //         Route::get('/productUpdateForm/{id}', [AdminController::class, 'productUpdateForm'])->name('productUpdateForm');
        //         Route::post('/productUpdate', [AdminController::class, 'productUpdate'])->name('productUpdate');
        //         Route::delete('/productDestroy/{id}', [AdminController::class, 'productDestroy'])->name('productDestroy');
        //     });
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

        //User
        Route::get('/users/exportexcel', [UserController::class, 'exportexcel'])->name('users.exportexcel');
        Route::get('/users/exportpdf', [UserController::class, 'exportPDF'])->name('users.exportPDF');
        Route::resource('users', UserController::class);
        Route::get('/users/activate/{id}', [UserController::class, 'activate'])->name('users.activate');
        //Nhân viên
        Route::get('/staffs/exportexcel', [StaffController::class, 'exportexcel'])->name('staffs.exportexcel');
        Route::get('/staffs/exportpdf', [StaffController::class, 'exportPDF'])->name('staffs.exportPDF');
        Route::resource('staffs', StaffController::class);
        Route::get('/staffs/activate/{id}', [StaffController::class, 'activate'])->name('staffs.activate');

        Route::resource('bill', BillController::class);
    });
