<?php

use Illuminate\Support\Facades\Auth;
//
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BillController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminController;
//
use App\Http\Controllers\Client\AuthController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\AboutController;
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Middleware\CheckRoleAdminMiddleware;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\SpecialtyController;
use App\Http\Controllers\Client\ContactController;
use App\Http\Controllers\Admin\VariantPackageController;
use App\Http\Controllers\Admin\VariantProductsController;
use App\Http\Controllers\Admin\VariantProPackageController;
use App\Http\Controllers\Client\AppoinmentController;
use App\Models\Category;
use App\Models\Doctor;

// Route::get('/', function () {
//     return view('welcome'); physicianManagement
// });
//Guest
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'about'])->name('about');
Route::get('/contact', [ContactController::class, 'contact'])->name('contact');
Route::get('/products', [HomeController::class, 'products'])->name('products');
Route::get('/search', [HomeController::class, 'search'])->name('products.search');
Route::get('/products/detail/{product_id}', [HomeController::class, 'detail'])->name('productDetail');
Route::get('/products/{category_id}', [HomeController::class, 'products'])->name('productsByCategoryId');
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
        Route::get('/booKingCare/{id}', [AppoinmentController::class, 'booKingCare'])->name('booKingCare');
        Route::get('/search-autocomplete', [AppoinmentController::class, 'autocompleteSearch'])->name('autocompleteSearch');
        Route::get('/appointmentHistory/{id}', [AppoinmentController::class, 'appointmentHistory'])->name('appointmentHistory');
        Route::get('/physicianManagement/{id}', [AppoinmentController::class, 'physicianManagement'])->name('physicianManagement');
        Route::get('/doctorDetails/{id}', [AppoinmentController::class, 'doctorDetails'])->name('doctorDetails');
        Route::get('/formbookingdt/{id}', [AppoinmentController::class, 'formbookingdt'])->name('formbookingdt');
        Route::post('/bookAnAppointment', [AppoinmentController::class, 'bookAnAppointment'])->name('bookAnAppointment');
        Route::get('/appointmentHistory/{id}', [AppoinmentController::class, 'appointmentHistory'])->name('appointmentHistory');
        Route::post('/reviewDortor', [AppoinmentController::class, 'reviewDortor'])->name('reviewDortor');

        Route::get('/statistics/{id}', [AppoinmentController::class, 'statistics'])->name('statistics');
        Route::get('/appointments/pending', [AppoinmentController::class, 'getPendingAppointments'])->name('appointments.pending');

        Route::post('/appointments/{id}/confirm', [AppoinmentController::class, 'confirmAppointment'])->name('appointments.confirm');
        Route::post('/appointments/{id}/confirmhuy', [AppoinmentController::class, 'confirmAppointmenthuy'])->name('appointments.confirmhuy');
        Route::post('/confirmAppointmentkoden', [AppoinmentController::class, 'confirmAppointmentkoden'])->name('confirmAppointmentkoden');
        Route::get('/appointment-history/{appointment_id}', [AppoinmentController::class, 'getAppointmentHistory'])->name('appointment.history');

        Route::post('/confirmAppointmentHistories', [AppoinmentController::class, 'confirmAppointmentHistories'])->name('confirmAppointmentHistories');
        Route::get('/appointments/get-details', [AppoinmentController::class, 'getDetails']);
        Route::get('/appointments/get_patient_info', [AppoinmentController::class, 'getPatientInfo']);

        //siuuu
        Route::post('/appointments/get-review-data', [AppoinmentController::class, 'getReviewData'])->name('appointments.getReviewData');
        Route::get('/reviews/{id}/edit', [AppoinmentController::class, 'edit']);
        Route::post('/reviewDortor', [AppoinmentController::class, 'reviewDortor'])->name('reviewDortor');
        Route::put('/reviews/{id}', [AppoinmentController::class, 'updateReview']);
        Route::post('/appointments/{id}/cancel', [AppoinmentController::class, 'cancel'])->name('appointments.cancel');


        Route::get('specialistExamination', [AppoinmentController::class, 'specialistExamination'])->name('specialistExamination');
        Route::get('/doctors/{specialty_id}', [AppoinmentController::class, 'doctors'])->name('doctorsBySpecialtyId');
        Route::post('/schedule', [AppoinmentController::class, 'schedule'])->name('schedule');

        Route::get('/appointment_histories/{appointment}/prescriptions',  [AppoinmentController::class, 'getPrescriptions']);
    });

Route::get('/viewSikibidi', function () {
    $orderCount = 1;
    if (Auth::check()) {
        $user = Auth::user();
        $orderCount = $user->bill()->count();
    }
    $categories = Category::orderBy('name', 'asc')->get();
    return view('client.ai.viewSikibidi', compact('orderCount', 'categories'));
});
Route::get('/chat-ai', function () {
    $orderCount = 1;
    if (Auth::check()) {
        $user = Auth::user();
        $orderCount = $user->bill()->count();
    }
    $categories = Category::orderBy('name', 'asc')->get();
    return view('client.ai.chatAI', compact('orderCount', 'categories'));
});
Route::get('/chat-zalo', function () {
    $orderCount = 1;
    if (Auth::check()) {
        $user = Auth::user();
        $orderCount = $user->bill()->count();
    }
    $categories = Category::orderBy('name', 'asc')->get();
    return view('client.ai.chatZalo', compact('orderCount', 'categories'));
});



Auth::routes();
//user management
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/login', [AuthController::class, 'viewLogin'])->name('viewLogin');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/viewEditAcc', [AuthController::class, 'viewEditAcc'])->name('viewEditAcc');
Route::post('/editAcc', [AuthController::class, 'editAcc'])->name('editAcc');

Route::get('/listCart', [CartController::class, 'listCart'])->name('cart.listCart');
Route::post('/addCart', [CartController::class, 'addCart'])->name('cart.addCart');
Route::post('/updateCart', [CartController::class, 'updateCart'])->name('cart.updateCart');
Route::post('/removeCart', [CartController::class, 'removeCart'])->name('cart.removeCart');

// order
Route::middleware('auth')->prefix('orders')
    ->as('orders.')
    ->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/create', [OrderController::class, 'create'])->name('create');
        Route::post('/store', [OrderController::class, 'store'])->name('store');
        Route::get('/show/{id}', [OrderController::class, 'show'])->name('show');
        Route::put('{id}/update', [OrderController::class, 'update'])->name('update');
    });

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
                Route::get('/filter-specialty', [DoctorController::class, 'filterSpecialty'])->name('filterSpecialty');
                Route::post('/doctorAdd', [DoctorController::class, 'doctorAdd'])->name('doctorAdd');
                Route::get('/doctorUpdateForm/{id}', [DoctorController::class, 'doctorUpdateForm'])->name('doctorUpdateForm');
                Route::post('/doctorUpdate', [DoctorController::class, 'doctorUpdate'])->name('doctorUpdate');
                Route::delete('/doctorDestroy/{id}', [DoctorController::class, 'doctorDestroy'])->name('doctorDestroy');
            });
        //timeslot
        Route::prefix('timeslot')
            ->as('timeslot.')
            ->group(function () {
                Route::get('/schedule/{doctorId}', [DoctorController::class, 'showSchedule'])->name('doctor.schedule');
                Route::post('/scheduleAdd', [DoctorController::class, 'scheduleAdd'])->name('scheduleAdd');
                Route::get('/scheduleEdit/{id}', [DoctorController::class, 'scheduleEdit']);
                Route::put('/scheduleUpdate/{id}', [DoctorController::class, 'scheduleUpdate'])->name('scheduleUpdate');
                Route::delete('/scheduleDestroy/{id}', [DoctorController::class, 'scheduleDestroy']);


                Route::get('/showPackages/{packageId}', [DoctorController::class, 'showPackages'])->name('showPackages');
                Route::post('/schedulePackageAdd', [DoctorController::class, 'schedulePackageAdd'])->name('schedulePackageAdd');
            });

        Route::prefix('achievements')
            ->as('achievements.')
            ->group(function () {
                Route::get('/achievements/{doctorId}', [DoctorController::class, 'showAchievements'])->name('doctor.achievements');
                Route::post('/achievementsAdd', [DoctorController::class, 'achievementsAdd'])->name('achievementsAdd');
                Route::delete('/achievementsds/{id}', [DoctorController::class, 'destroy']);
                Route::post('/achievementsUpdate', [DoctorController::class, 'achievementsUpdate'])->name('achievementsUpdate');
            });

        Route::prefix('packages')
            ->as('packages.')
            ->group(function () {
                Route::get('/viewPackagesAdd', [DoctorController::class, 'viewPackagesAdd'])->name('viewPackagesAdd');
                Route::post('/PackageAdd', [DoctorController::class, 'PackageAdd'])->name('PackageAdd');
                Route::get('/packageUpdateForm/{id}', [DoctorController::class, 'packageUpdateForm'])->name('packageUpdateForm');
                Route::post('/packageUpdate/{id}', [DoctorController::class, 'packageUpdate'])->name('packageUpdate');
                Route::delete('/packageDestroy/{id}', [DoctorController::class, 'packageDestroy'])->name('packageDestroy');
            });

        Route::prefix('medicalPackages')
            ->as('medicalPackages.')
            ->group(function () {
                Route::get('/medicalPackages/{doctorId}', [DoctorController::class, 'medicalPackages'])->name('medicalPackages');
                Route::post('/viewmedicalPackagesAdd', [DoctorController::class, 'viewmedicalPackagesAdd'])->name('viewmedicalPackagesAdd');
                Route::post('/medicalPackagesUpdate', [DoctorController::class, 'medicalPackagesUpdate'])->name('medicalPackagesUpdate');
                Route::delete('/medicalPackagesDestroy/{id}', [DoctorController::class, 'medicalPackagesDestroy'])->name('medicalPackagesDestroy');
            });
    });
