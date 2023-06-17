<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\SubCategoryController;
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

Route::get('admin/login', [AdminController::class, 'AdminLogin']);

// ==========Vendor Mangements =========
Route::middleware(['auth','role:admin'])->controller(AdminController::class)->group(function (){
    Route::get('active/vendor','ActiveVendor')->name('active.vendor');
    Route::get('active/vendor/details/{id}','ActiveVendorDetails')->name('active.vendor.details');
    Route::post('active/vendor/deactive/{id}','ActiveVendorDeactive')->name('active.vendor.deactive');

    Route::get('inactive/vendor','InactiveVendor')->name('inactive.vendor');
    Route::get('inactive/vendor/details/{id}','InactiveVendorDetails')->name('inactive.vendor.details');
    Route::post('inactive/vendor/approve/{id}','InactiveVendorApprove')->name('inactive.vendor.approve');
});
    // Brand section
Route::middleware(['auth','role:admin'])->controller(BrandController::class)->group(function (){
    Route::get('all/brand','AllBrand')->name('all.brand');
    Route::get('add/brand','AddBrand')->name('add.brand');
    Route::post('store/brand','StoreBrand')->name('store.brand');
    Route::get('edit/brand/{id}','EditBrand')->name('edit.brand');
    Route::post('update/brand','UpdateBrand')->name('update.brand');
    Route::get('delete/brand/{id}','DeleteBrand')->name('delete.brand');
});
    // Category section
Route::middleware(['auth','role:admin'])->controller(CategoryController::class)->group(function (){
    Route::get('all/category','AllCategory')->name('all.category');
    Route::get('add/category','AddCategory')->name('add.category');
    Route::post('store/category','StoreCategory')->name('store.category');
    Route::get('edit/category/{id}','EditCategory')->name('edit.category');
    Route::post('update/category','UpdateCategory')->name('update.category');
    Route::get('delete/category/{id}','DeleteCatgory')->name('delete.category');
});
    // Sub Category section
Route::middleware(['auth','role:admin'])->controller(SubCategoryController::class)->group(function (){
    Route::get('all/subcategory','AllSubCategory')->name('all.subcategory');
    Route::get('add/subcategory','AddSubCategory')->name('add.subcategory');
    Route::post('store/subcategory','StoreSubCategory')->name('store.subcategory');
    Route::get('edit/subcategory/{id}','EditSubCategory')->name('edit.subcategory');
    Route::post('update/subcategory/{id}','UpdateSubCategory')->name('update.subcategory');
    Route::get('delete/subcategory/{id}','DeleteSubCatgory')->name('delete.subcategory');
    Route::get('/subcategory/ajax/{id}','GetSubCatgory');
});
Route::middleware(['auth','role:admin'])->controller(ProductController::class)->group(function (){
    Route::get('all/product','AllProduct')->name('all.product');
    Route::get('add/product','AddProduct')->name('add.product');
    Route::post('store/product','StoreProduct')->name('store.product');
    // Route::get('edit/subcategory/{id}','EditSubCategory')->name('edit.subcategory');
    // Route::post('update/subcategory/{id}','UpdateSubCategory')->name('update.subcategory');
    // Route::get('delete/subcategory/{id}','DeleteSubCatgory')->name('delete.subcategory');
});
//========Vendor Login Register========
Route::get('vendor/login', [VendorController::class, 'VendorLogin'])->name('vendor.login');
Route::get('become/vendor', [VendorController::class, 'BecomeVendor'])->name('become.vendor');
Route::post('vendor/register', [VendorController::class, 'VendorRegister'])->name('vendor.register');
//========Vendor Dashboard========
Route::prefix('vendor')->middleware(['auth','role:vendor'])->group(function () {

    Route::get('dashboard', [VendorController::class, 'VendorDashboard']);
    Route::get('logout', [VendorController::class, 'VendorDestroy']);
    Route::get('profile', [VendorController::class, 'VendorProfile'])->name('vendor.profile');
    Route::post('profile/store', [VendorController::class, 'VendorProfileStore'])->name('vendor.profile.store');
    Route::get('change_password', [VendorController::class, 'VendorChangePassword'])->name('vendor.change_password');
    Route::post('update/password', [VendorController::class, 'VendorUpdatePassword'])->name('vendor.update.password');
});

