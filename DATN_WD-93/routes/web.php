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
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Client\AboutController;
<<<<<<< Updated upstream
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\Admin\ProductController;
=======
use App\Http\Controllers\Client\BookingDoctorController;
>>>>>>> Stashed changes
use App\Http\Middleware\CheckRoleAdminMiddleware;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\SpecialtyController;
use App\Http\Controllers\Client\ContactController;
<<<<<<< Updated upstream
use App\Http\Controllers\Admin\VariantPackageController;
use App\Http\Controllers\Admin\VariantProductsController;
use App\Http\Controllers\Admin\VariantProPackageController;
use App\Http\Controllers\Client\AppoinmentController;
=======
//
>>>>>>> Stashed changes

// Route::get('/', function () {
//     return view('welcome');
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


// bookingdoctor
Route::get('/viewBookingDoctor', [BookingDoctorController::class, 'viewBookingDoctor'])->name('viewBookingDoctor');
Route::get('/appointmentHistory/{id}', [BookingDoctorController::class, 'appointmentHistory'])->name('appointmentHistory');
Route::get('/booKingCare/{id}', [BookingDoctorController::class, 'booKingCare'])->name('booKingCare');
Route::get('/doctorDetails/{id}', [BookingDoctorController::class, 'doctorDetails'])->name('doctorDetails');
Route::get('/formbookingdt/{id}', [BookingDoctorController::class, 'formbookingdt'])->name('formbookingdt');
Route::get('/search-autocomplete', [BookingDoctorController::class, 'autocompleteSearch'])->name('autocompleteSearch');
Route::post('/bookAnAppointment', [BookingDoctorController::class, 'bookAnAppointment'])->name('bookAnAppointment');
Route::post('/appointments/{id}/cancel', [BookingDoctorController::class, 'cancel'])->name('appointments.cancel');
Route::get('/generalExamination', [BookingDoctorController::class, 'generalExamination'])->name('generalExamination');
Route::get('/statistics/{id}', [BookingDoctorController::class, 'statistics'])->name('statistics');
Route::post('/medical-chat', [BookingDoctorController::class, 'ask']);
Route::get('/viewSikibidi', function () {
    return view('client.bookingdoctor.viewSikibidi');
});
Route::get('/chat-ai', function () {
    return view('client.bookingdoctor.chatAI');
});
Route::get('/chat-zalo', function () {
    return view('client.bookingdoctor.chatZalo');
});


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
<<<<<<< Updated upstream
                Route::get('/specialtyDoctorList', [SpecialtyController::class, 'specialtyDoctorList'])->name('specialtyDoctorList');
                Route::get('/viewSpecialtyAdd', [SpecialtyController::class, 'viewSpecialtyAdd'])->name('viewSpecialtyAdd');
                Route::post('/specialtyAdd', [SpecialtyController::class, 'specialtyAdd'])->name('specialtyAdd');
                Route::get('/specialtyUpdateForm/{id}', [SpecialtyController::class, 'specialtyUpdateForm'])->name('specialtyUpdateForm');
                Route::post('/specialtyUpdate', [SpecialtyController::class, 'specialtyUpdate'])->name('specialtyUpdate');
                Route::delete('/specialtyDestroy/{id}', [SpecialtyController::class, 'specialtyDestroy'])->name('specialtyDestroy');
=======
                Route::get('/specialtyList', [SpecialtyController::class, 'index'])->name('specialtyList');
                Route::post('/specialtyAdd', [SpecialtyController::class, 'store']);
                Route::get('/specialtyedit/{id}', [SpecialtyController::class, 'edit'])->name('specialtyedit');
                Route::put('/specialtyUpdate/{id}', [SpecialtyController::class, 'update'])->name('specialtyUpdate');
                Route::delete('/specialtyDestroy/{id}', [SpecialtyController::class, 'destroy']);
>>>>>>> Stashed changes
            });
        //doctor
        Route::prefix('doctors')
            ->as('doctors.')
            ->group(function () {
<<<<<<< Updated upstream
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
=======
                Route::get('/doctorsList', [DoctorController::class, 'index'])->name('doctors.index');
                Route::post('/doctorsAdd', [DoctorController::class, 'store'])->name('doctors.store');
                Route::get('/doctorsEdit/{id}', [DoctorController::class, 'show'])->name('doctors.show');
                Route::get('/doctorsDetails/{id}', [DoctorController::class, 'showDetails']);
                Route::put('/doctorsUpdate/{id}', [DoctorController::class, 'update'])->name('doctors.update');
                Route::delete('/doctorsDestroy/{id}', [DoctorController::class, 'destroy'])->name('doctors.destroy');
                Route::get('/physicianManagement/{id}', [DoctorController::class, 'physicianManagement'])->name('physicianManagement');

                // Appointment routes
                Route::get('/appointments/pending', [DoctorController::class, 'getPendingAppointments'])->name('appointments.pending');
                Route::patch('/appointments/{id}/confirm', [DoctorController::class, 'confirmAppointment'])->name('appointments.confirm');
                Route::patch('/appointments/{id}/confirmhuy', [DoctorController::class, 'confirmAppointmenthuy'])->name('appointments.confirmhuy');
                Route::get('/appointments/get-details', [DoctorController::class, 'getDetails']);
                Route::post('/confirmAppointmentkoden', [DoctorController::class, 'confirmAppointmentkoden'])->name('confirmAppointmentkoden');
                Route::get('/appointments/get_patient_info', [DoctorController::class, 'getPatientInfo']);
                Route::post('/confirmAppointmentHistories', [DoctorController::class, 'confirmAppointmentHistories'])->name('confirmAppointmentHistories');
                Route::post('/appointments/get-review-data', [DoctorController::class, 'getReviewData'])->name('appointments.getReviewData');
                Route::post('/reviewDortor', [DoctorController::class, 'reviewDortor'])->name('reviewDortor');
                Route::get('/reviews/{id}/edit', [DoctorController::class, 'edit']);
                Route::put('/reviews/{id}', [DoctorController::class, 'updateReview']);




                Route::get('/doctor/schedule/{doctorId}', [DoctorController::class, 'showSchedule'])->name('doctor.schedule');
                Route::post('/doctor/scheduleAdd', [DoctorController::class, 'scheduleAdd'])->name('scheduleAdd');
                Route::get('/doctor/scheduleEdit/{id}', [DoctorController::class, 'scheduleEdit']);
                Route::put('/doctor/scheduleUpdate/{id}', [DoctorController::class, 'scheduleUpdate'])->name('scheduleUpdate');
                Route::delete('/doctor/scheduleDestroy/{id}', [DoctorController::class, 'scheduleDestroy']);
>>>>>>> Stashed changes
            });
    });
