<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\Backend\BrandController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Role;
use App\Http\Middleware\Authenticate;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('frontend.index');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'UserDashboard'])->name('dashboard');
    Route::post('user/store', [UserController::class, 'UserStore'])->name('user.store');
    Route::get('user/logout', [UserController::class, 'UserLogout'])->name('user.logout');
    Route::post('user/change-password', [UserController::class, 'UserChangePassword'])->name('user.change.password');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

//========Admin Dashboard========
Route::prefix('admin')->middleware(['auth','role:admin'])->group(function () {
    Route::get('dashboard', [AdminController::class, 'AdminDashboard']);
    Route::get('logout', [AdminController::class, 'AdminDestroy']);
    Route::get('profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('change_password', [AdminController::class, 'AdminChangePassword'])->name('admin.change_password');
    Route::post('update/password', [AdminController::class, 'AdminUpdatePassword'])->name('admin.update.password');
});

//========Vendor Dashboard========
Route::prefix('vendor')->middleware(['auth','role:vendor'])->group(function () {

    Route::get('dashboard', [VendorController::class, 'VendorDashboard']);
    Route::get('logout', [VendorController::class, 'VendorDestroy']);
    Route::get('profile', [VendorController::class, 'VendorProfile'])->name('vendor.profile');
    Route::post('profile/store', [VendorController::class, 'VendorProfileStore'])->name('vendor.profile.store');
    Route::get('change_password', [VendorController::class, 'VendorChangePassword'])->name('vendor.change_password');
    Route::post('update/password', [VendorController::class, 'VendorUpdatePassword'])->name('vendor.update.password');
});

    Route::get('admin/login', [AdminController::class, 'AdminLogin']);

    Route::get('vendor/login', [VendorController::class, 'VendorLogin']);
    Route::get('vendor/register',[VendorController::class, 'VendorRegister']);

    Route::controller(BrandController::class)->middleware(['auth','role:admin'])->group(function (){
        Route::get('all/brand','AllBrand')->name('all.brand');
        Route::get('add/brand','AddBrand')->name('add.brand');
    });
