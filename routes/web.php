<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\BrandsProfileController;
use App\Http\Controllers\Authentication;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\SuperadminController;
use App\Http\Controllers\EnquiryController;
use App\Http\Middleware\IsSubscriber;
use App\Http\Middleware\IsSuperadmin;
use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnnotationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PlansController;


Route::get('/register', [RouteController::class, 'register'])->name('register');
Route::get('/login', [RouteController::class, 'login'])->name('login');
Route::post('/login', [Authentication::class, 'userLogin']);
Route::post('/register', [Authentication::class, 'userRegister']);
Route::post('/logout', [Authentication::class, 'userLogout'])->name('logout');


Route::post('/paypal/create', [PaymentController::class, 'createPayment'])->name('paypal.create');
Route::get('/paypal/success', [PaymentController::class, 'paymentSuccess'])->name('paypal.success');
Route::get('/paypal/cancel', [PaymentController::class, 'paymentCancel'])->name('paypal.cancel');
Route::get('/plans', [PlansController::class, 'index'])->name('plans');


Route::middleware([IsSubscriber::class])->group(function () {
    Route::get('/', [RouteController::class, 'home'])->name('subscribers.dashboard');
    Route::get('/billing', [RouteController::class, 'billing'])->name('billing');

    //Brandprofile Routes
    Route::get('/brandprofile', [RouteController::class, 'brandProfile'])->name('brandprofile');
    Route::get('/add-brand', [RouteController::class, 'brandForm'])->name('addbrand');
    Route::post('/add-brand', [BrandsProfileController::class, 'store']);
    Route::get('/view-brand/{id}', [RouteController::class, 'viewBrand']);
    Route::get('/edit-brand/{id}', [RouteController::class, 'editBrand'])->name('brand.edit');
    Route::put('/update-brand/{id}', [BrandsProfileController::class, 'updateBrand'])->name('update.brand');
    Route::delete('/delete-brand/{id}', [BrandsProfileController::class, 'deleteBrand'])->name('delete.brand');

    Route::get('/search-brand', [BrandsProfileController::class, 'searchBrand']);


    Route::get('/profile', [RouteController::class, 'profile'])->name('profile');
    Route::get('/designbrief', [RouteController::class, 'designBrief'])->name('designbrief');
    Route::get('/revisiontool', [RouteController::class, 'revisionTool'])->name('revisiontool');
    Route::get('/helpcenter', [RouteController::class, 'helpCenter'])->name('helpcenter');



    Route::get('/requests', [RouteController::class, 'requests'])->name('requests');
    Route::get('/add-order', [RouteController::class, 'addOrder'])->name('create.order');
    Route::post('/add-order', [OrdersController::class, 'store'])->name('create.order');



    Route::get('/usage', [RouteController::class, 'usage'])->name('usage');
    Route::get('/users', [RouteController::class, 'users'])->name('users');
    Route::post('/submit-enquiry', [EnquiryController::class, 'store'])->name('submit.enquiry');


});

Route::post('/save-annotation', [AnnotationController::class, 'store'])->name('save.annotation');


Route::get('/view-order/{id}', [RouteController::class, 'viewOrder'])->name('view.order');
Route::put('/update-order/{id}', [SuperadminController::class, 'updateOrder'])->name('update.order');

Route::middleware([IsSuperadmin::class])->group(function (){
    Route::get('/superadmin-dashboard', [RouteController::class, 'superadminDashboard'])->name('superadmin.dashboard');
    Route::get('/superadmin-orders', [RouteController::class, 'superadminOrders'])->name('superadmin.orders');
    Route::get('/superadmin-subscribers', [RouteController::class, 'superadminSubscribers'])->name('superadmin.subscribers');
    Route::get('/admins-list', [RouteController::class, 'adminsList'])->name('superadmin.admins'); 
    Route::get('/add-admin', [RouteController::class, 'addAdminForm'])->name('superadmin.addadmins');
    Route::post('/add-admin', [SuperadminController::class, 'createAdmin']);
    Route::get('/edit-admin/{id}', [SuperadminController::class, 'updateAdminform'])->name('superadmin.editadmin');
    Route::put('/edit-admin/{id}', [SuperadminController::class, 'updateAdmin'])->name('superadmin.editadmin');
    Route::delete('/delete-admin/{id}', [SuperadminController::class, 'deleteAdmin'])->name('delete.admin');
    Route::get('/superadmin-enquires', [RouteController::class, 'superadminEnquires'])->name('superadmin.enquires');
    Route::get('/edit-order/{id}', [RouteController::class, 'editOrder'])->name('edit.order');
});



Route::middleware([IsAdmin::class])->group(function (){
    Route::get('/admin-dashboard', [RouteController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/admin-orders', [RouteController::class, 'adminOrders'])->name('admin.orders');
    Route::get('/admin-vieworders/{id}', [AdminController::class, 'adminViewOrders'])->name('admin.vieworders');
    Route::get('/admin-editorders/{id}', [AdminController::class, 'adminEditOrders'])->name('admin.editorders');
    Route::put('/admin-editorders/{id}', [AdminController::class, 'updateOrder'])->name('admin.updateorders');
});