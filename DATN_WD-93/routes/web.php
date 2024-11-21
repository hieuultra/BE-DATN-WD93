<?php

use Illuminate\Support\Facades\Auth;
//
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BillController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Client\AuthController;
//
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Client\AboutController;
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Client\CouponController;
use App\Http\Controllers\Client\ReviewController;
use App\Http\Middleware\CheckRoleAdminMiddleware;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Client\ContactController;
use App\Http\Controllers\Admin\AdminBlogController;
use App\Http\Controllers\Admin\SpecialtyController;
use App\Http\Controllers\Admin\AdminTopicController;
use App\Http\Controllers\Admin\AdminCouponController;
use App\Http\Controllers\Client\AppoinmentController;
use App\Http\Controllers\Client\ClientBlogController;
use App\Http\Controllers\Admin\VariantPackageController;
use App\Http\Controllers\Admin\VariantProductsController;
use App\Http\Controllers\Admin\VariantProPackageController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;

//Guest
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'about'])->name('about');
Route::get('/contact', [ContactController::class, 'contact'])->name('contact');
Route::get('/products', [HomeController::class, 'products'])->name('products');
Route::get('/search', [HomeController::class, 'search'])->name('products.search');
Route::get('/products/detail/{product_id}', [HomeController::class, 'detail'])->name('productDetail');
Route::get('/products/{category_id}', [HomeController::class, 'products'])->name('productsByCategoryId');
Route::post('/adminProducts/category', [ProductController::class, 'filterByCategory'])->name('filterByCategory');
Route::get('/get-product-info', [HomeController::class, 'getProductInfo'])->name('getProductInfo');
Route::get('/get-price-quantity-variant', [HomeController::class, 'getPriceQuantiVariant'])->name('getPriceQuantiVariant');
Route::post('/add-to-cart-home', [HomeController::class, 'addToCartHome'])->name('addToCartHome');  //
Route::get('/get-price-quantity-vp', [CartController::class, 'getPriceQuantiVariant'])->name('getPriceQuantiVariant');
Route::get('/products/filter', [HomeController::class, 'filter'])->name('products.filter');

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
//appoinment
Route::prefix('appoinment')
    ->as('appoinment.')
    ->group(function () {
        Route::get('/', [AppoinmentController::class, 'appoinment'])->name('index');
        Route::get('specialistExamination', [AppoinmentController::class, 'specialistExamination'])->name('specialistExamination');
        Route::get('/doctors/{specialty_id}', [AppoinmentController::class, 'doctors'])->name('doctorsBySpecialtyId');
        Route::post('/schedule', [AppoinmentController::class, 'schedule'])->name('schedule');
    });

Auth::routes();
//user management
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/login', [AuthController::class, 'viewLogin'])->name('viewLogin');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/viewEditAcc', [AuthController::class, 'viewEditAcc'])->name('viewEditAcc');
Route::post('/editAcc', [AuthController::class, 'editAcc'])->name('editAcc');

Route::get('/listCart', [CartController::class, 'listCart'])->name('cart.listCart');
Route::post('/addCart', [CartController::class, 'addCart'])->name('cart.addCart');               //
Route::post('/updateCart', [CartController::class, 'updateCart'])->name('cart.updateCart');
Route::post('/removeCart', [CartController::class, 'removeCart'])->name('cart.removeCart');
Route::post('/reorder/{orderId}', [CartController::class, 'reorder'])->name('cart.reorder');
Route::post('/cart/apply-coupon', [CouponController::class, 'applyCoupon'])->name('cart.applyCoupon');

// Route Blog
Route::get('/blog',       [ClientBlogController::class, 'index'])->name('blog.index');
Route::get('/blog/list/{topic_id}',       [ClientBlogController::class, 'list'])->name('blog.list');
Route::get('/blog/show/{id}',  [ClientBlogController::class, 'show'])->name('blog.show');
// order
Route::middleware('auth')->prefix('orders')
    ->as('orders.')
    ->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/status/{status}', [OrderController::class, 'index'])->name('indexByStatus');
        Route::get('/create', [OrderController::class, 'create'])->name('create');
        Route::post('/store', [OrderController::class, 'store'])->name('store');
        Route::get('/show/{id}', [OrderController::class, 'show'])->name('show');
        Route::put('{id}/update', [OrderController::class, 'update'])->name('update');
    });
//review
Route::post('/products/{productId}/reviews/{billId}', [ReviewController::class, 'store'])->name('reviews.store')->middleware('auth');

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
        //variantPackages
        Route::prefix('variantPackages')
            ->as('variantPackages.')
            ->group(function () {
                Route::get('/variantPackageList', [VariantPackageController::class, 'variantPackageList'])->name('variantPackageList');
                Route::get('/viewVariantPackageAdd', [VariantPackageController::class, 'viewVariantPackageAdd'])->name('viewVariantPackageAdd');
                Route::post('/variantPackageAdd', [VariantPackageController::class, 'variantPackageAdd'])->name('variantPackageAdd');
                Route::get('/packageUpdateForm/{id}', [VariantPackageController::class, 'packageUpdateForm'])->name('packageUpdateForm');
                Route::post('/packageUpdate', [VariantPackageController::class, 'packageUpdate'])->name('packageUpdate');
                Route::delete('/packageDestroy/{id}', [VariantPackageController::class, 'packageDestroy'])->name('packageDestroy');
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
                // Route::delete('/productDestroy/{id}', [ProductController::class, 'productDestroy'])->name('productDestroy');
                Route::delete('/soft-delete/{id}', [ProductController::class, 'softDelete'])->name('softDelete');
                Route::delete('/hard-delete/{id}', [ProductController::class, 'hardDelete'])->name('hardDelete');
                Route::get('/restore/{id}', [ProductController::class, 'restore'])->name('restore');
                //
                Route::get('/productVariant/{id}', [ProductController::class, 'productVariant'])->name('productVariant');
                Route::get('/productVariantAdd', [ProductController::class, 'productVariantAdd'])->name('productVariantAdd');
                Route::post('/get-variant-quantity', [ProductController::class, 'getQuantity'])->name('getVariantQuantity');
                Route::post('/get-variant-product-update', [VariantProductsController::class, 'variantProductUpdate'])->name('variantProductUpdate');
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
                Route::post('/VariantProductDestroy', [VariantProductsController::class, 'VariantProductDestroy'])->name('VariantProductDestroy');
            });
        // order
        Route::prefix('bills')
            ->as('bills.')
            ->group(function () {
                Route::get('/',               [BillController::class, 'index'])->name('index');
                Route::get('/show/{id}',     [BillController::class, 'show'])->name('show');
                Route::put('{id}/update',    [BillController::class, 'update'])->name('update');
                Route::delete('{id}/destroy', [BillController::class, 'destroy'])->name('destroy');
            });
        //account
        Route::prefix('user')
            ->as('users.')
            ->group(function () {
                Route::get('/userList', [UserController::class, 'userList'])->name('userList');
                Route::get('/viewUserAdd', [UserController::class, 'viewUserAdd'])->name('viewUserAdd');
                Route::post('/userAdd', [UserController::class, 'userAdd'])->name('userAdd');
                Route::get('/userUpdateForm/{id}', [UserController::class, 'userUpdateForm'])->name('userUpdateForm');
                Route::post('/userUpdate', [UserController::class, 'userUpdate'])->name('userUpdate');
                Route::delete('/userDestroy/{id}', [UserController::class, 'userDestroy'])->name('userDestroy');
            });
        //specialty
        Route::prefix('specialties')
            ->as('specialties.')
            ->group(function () {
                Route::get('/specialtyDoctorList', [SpecialtyController::class, 'specialtyDoctorList'])->name('specialtyDoctorList');
                Route::get('/viewSpecialtyAdd', [SpecialtyController::class, 'viewSpecialtyAdd'])->name('viewSpecialtyAdd');
                Route::post('/specialtyAdd', [SpecialtyController::class, 'specialtyAdd'])->name('specialtyAdd');
                Route::get('/specialtyUpdateForm/{id}', [SpecialtyController::class, 'specialtyUpdateForm'])->name('specialtyUpdateForm');
                Route::post('/specialtyUpdate', [SpecialtyController::class, 'specialtyUpdate'])->name('specialtyUpdate');
                Route::delete('/specialtyDestroy/{id}', [SpecialtyController::class, 'specialtyDestroy'])->name('specialtyDestroy');
            });
        //doctor
        Route::prefix('doctors')
            ->as('doctors.')
            ->group(function () {
                Route::get('/viewDoctorAdd', [DoctorController::class, 'viewDoctorAdd'])->name('viewDoctorAdd');
                Route::post('/doctorAdd', [DoctorController::class, 'doctorAdd'])->name('doctorAdd');
                Route::get('/doctorUpdateForm/{id}', [DoctorController::class, 'doctorUpdateForm'])->name('doctorUpdateForm');
                Route::post('/doctorUpdate', [DoctorController::class, 'doctorUpdate'])->name('doctorUpdate');
                Route::delete('/doctorDestroy/{id}', [DoctorController::class, 'doctorDestroy'])->name('doctorDestroy');
            });
        //timeslot
        Route::prefix('timeslot')
            ->as('timeslot.')
            ->group(function () {
                Route::get('/timeslotList', [DoctorController::class, 'timeslotList'])->name('timeslotList');
                Route::get('/viewTimeslotAdd/{id}', [DoctorController::class, 'viewTimeslotAdd'])->name('viewTimeslotAdd');
                Route::post('{doctorId}/timeslotAdd', [DoctorController::class, 'timeslotAdd'])->name('timeslotAdd');
                Route::get('/timeslotUpdateForm/{id}', [DoctorController::class, 'timeslotUpdateForm'])->name('timeslotUpdateForm');
                Route::post('/timeslotUpdate', [DoctorController::class, 'timeslotUpdate'])->name('timeslotUpdate');
                Route::delete('/timeslotDestroy/{id}', [DoctorController::class, 'timeslotDestroy'])->name('timeslotDestroy');
            });
        Route::prefix('reviews')
            ->as('reviews.')
            ->group(function () {
                Route::get('/list', [AdminReviewController::class, 'list'])->name('listReviews');
                Route::delete('/reviews/{id}', [AdminReviewController::class, 'destroy'])->name('destroyReviews');
                Route::get('/listDeleted', [AdminReviewController::class, 'listDeleted'])->name('listDeletedReviews');
                Route::post('/listDeleted/{id}/restore', [AdminReviewController::class, 'restore'])->name('restore');
            });
        Route::resource('coupons', AdminCouponController::class);
        Route::prefix('topics')
            ->as('topics.')
            ->group(function () {
                Route::get('/index',           [AdminTopicController::class, 'index'])->name('index');
                Route::get('/create',          [AdminTopicController::class, 'create'])->name('create');
                Route::post('/store',          [AdminTopicController::class, 'store'])->name('store');
                Route::get('/show/{id}',       [AdminTopicController::class, 'show'])->name('show');
                Route::get('/{id}/edit',       [AdminTopicController::class, 'edit'])->name('edit');
                Route::put('/{id}/update',     [AdminTopicController::class, 'update'])->name('update');
                Route::delete('/{id}/destroy', [AdminTopicController::class, 'destroy'])->name('destroy');
            });
        Route::prefix('blogs')
            ->as('blogs.')
            ->group(function () {
                Route::get('/index',           [AdminBlogController::class, 'index'])->name('index');
                Route::get('/create',          [AdminBlogController::class, 'create'])->name('create');
                Route::post('/store',          [AdminBlogController::class, 'store'])->name('store');
                Route::get('/show/{id}',       [AdminBlogController::class, 'show'])->name('show');
                Route::get('/{id}/edit',       [AdminBlogController::class, 'edit'])->name('edit');
                Route::put('/{id}/update',     [AdminBlogController::class, 'update'])->name('update');
                Route::delete('/{id}/destroy', [AdminBlogController::class, 'destroy'])->name('destroy');
            });
    });
