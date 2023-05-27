<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Role;

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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

//========Admin Dashboard========
Route::prefix('admin')->group(function () {
    Route::get('dashboard', [AdminController::class, 'AdminDashboard']);
    Route::get('logout', [AdminController::class, 'AdminDestroy']);
    Route::get('profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('change_password', [AdminController::class, 'AdminChangePassword'])->name('admin.change_password');
    Route::post('update/password', [AdminController::class, 'AdminUpdatePassword'])->name('admin.update.password');
})->middleware(['auth','role:admin']);

//========Vendor Dashboard========
Route::prefix('vendor')->group(function () {
    Route::get('dashboard', [VendorController::class, 'VendorDashboard']);
})->middleware(['auth','role:vendor']);
